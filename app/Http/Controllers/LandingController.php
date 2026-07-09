<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Schedule;
use App\Models\Station;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
  public function index(Request $request): View
  {
    $stations = Station::orderBy('name')->get();
    $schedules = collect();
    $originId = $request->input('origin_station_id');
    $destinationId = $request->input('destination_station_id');
    $departureDate = $request->input('departure_date');

    if ($originId && $destinationId && $departureDate) {
      $schedules = Schedule::with(['train', 'route.originStation', 'route.destinationStation'])
        ->whereHas('route', function ($q) use ($originId, $destinationId) {
          $q->where('origin_station_id', $originId)
            ->where('destination_station_id', $destinationId);
        })
        ->whereDate('departure_time', $departureDate)
        ->orderBy('departure_time')
        ->get();
    }

    return view('landing.index', compact('stations', 'schedules', 'originId', 'destinationId', 'departureDate'));
  }

  public function search(Request $request): View
  {
    $stations = Station::orderBy('name')->get();
    $originId = $request->input('origin_station_id');
    $destinationId = $request->input('destination_station_id');
    $departureDate = $request->input('departure_date');

    if ($originId && $destinationId && $departureDate) {
      $schedules = Schedule::with(['train', 'route.originStation', 'route.destinationStation'])
        ->whereHas('route', function ($q) use ($originId, $destinationId) {
          $q->where('origin_station_id', $originId)
            ->where('destination_station_id', $destinationId);
        })
        ->whereDate('departure_time', $departureDate)
        ->orderBy('departure_time')
        ->get();
    } else {
      $schedules = collect();
    }

    return view('landing.search-results', compact('stations', 'schedules', 'originId', 'destinationId', 'departureDate'));
  }

  public function getSeats(Request $request): JsonResponse
  {
    $request->validate([
      'schedule_id' => 'required|exists:schedules,id',
    ]);

    $schedule      = Schedule::with('train.carriages.seats')->findOrFail($request->schedule_id);
    $bookedSeatIds = Passenger::whereHas('booking', function ($q) use ($schedule) {
      $q->where('schedule_id', $schedule->id)
        ->whereIn('status', ['pending', 'paid']);
    })->pluck('seat_id')->toArray();

    $carriagesData = [];

    foreach ($schedule->train->carriages as $carriage) {
      $seatsData = [];

      foreach ($carriage->seats as $seat) {
        $isBooked            = in_array($seat->id, $bookedSeatIds);
        $seatsData[] = [
          'id'           => $seat->id,
          'seat_number'  => $seat->seat_number,
          'is_available' => $seat->status === 'available' && !$isBooked,
        ];
      }

      $carriagesData[] = [
        'id'    => $carriage->id,
        'name'  => $carriage->name,
        'class' => $carriage->class,
        'seats' => $seatsData,
      ];
    }

    return response()->json($carriagesData);
  }

  public function storeBooking(Request $request, BookingService $bookingService): JsonResponse|RedirectResponse
  {
    $request->validate([
      'schedule_id'       => 'required|exists:schedules,id',
      'customer_name'     => 'required|string|max:255',
      'customer_email'    => 'required|email|max:255',
      'customer_phone'    => 'required|string|max:20',
      'payment_method'    => 'required|string|in:bank_transfer,ewallet',
      'passengers'        => 'required|array|min:1',
      'passengers.*.passenger_name'      => 'required|string|max:255',
      'passengers.*.passenger_id_type'   => 'required|string|in:ktp,passport,sim',
      'passengers.*.passenger_id_number' => 'required|string|max:50',
      'passengers.*.seat_id'             => 'required|exists:seats,id',
    ]);

    $schedule      = Schedule::findOrFail($request->schedule_id);
    $bookedSeatIds = Passenger::whereHas('booking', function ($q) use ($schedule) {
      $q->where('schedule_id', $schedule->id)
        ->whereIn('status', ['pending', 'paid']);
    })->pluck('seat_id')->toArray();

    foreach ($request->passengers as $p) {
      if (in_array($p['seat_id'], $bookedSeatIds)) {
        if ($request->expectsJson() || $request->ajax()) {
          return response()->json(['message' => 'Salah satu kursi yang dipilih sudah dipesan.'], 422);
        }
        return back()->withErrors(['passengers' => 'Salah satu kursi yang dipilih sudah dipesan.'])->withInput();
      }
    }

    $data     = $request->all();
    $data['payment_status'] = 'pending';

    $booking = $bookingService->bookTicket($data, auth()->id() ?? null);

    if ($request->expectsJson() || $request->ajax()) {
      return response()->json(['redirect' => route('landing.bookings.success', $booking->booking_code)]);
    }

    return redirect()->route('landing.bookings.success', $booking->booking_code);
  }

  public function bookingSuccess(string $bookingCode): View
  {
    $booking = Booking::with([
      'schedule.train',
      'schedule.route.originStation',
      'schedule.route.destinationStation',
      'passengers.seat',
      'payment',
    ])->where('booking_code', $bookingCode)->firstOrFail();

    return view('landing.success', compact('booking'));
  }
}