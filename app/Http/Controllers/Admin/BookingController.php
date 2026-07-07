<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Schedule;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
	public function index(Request $request)
	{
		if ($request->ajax() || $request->wantsJson()) {
			$query = Booking::with('schedule.train', 'user');
			$totalRecords = $query->count();
			if ($request->filled('search.value')) {
				$searchValue = $request->input('search.value');
				$query->where(function ($q) use ($searchValue) {
					$q->where('booking_code', 'like', '%' . $searchValue . '%')
						->orWhere('customer_name', 'like', '%' . $searchValue . '%')
						->orWhereHas('user', function ($q2) use ($searchValue) {
							$q2->where('name', 'like', '%' . $searchValue . '%');
						});
				});
			}
			$filteredRecords = $query->count();
			$query->latest();
			$start = $request->input('start', 0);
			$length = $request->input('length', 10);
			$bookings = $query->skip($start)->take($length)->get();

			return response()->json([
				'draw' => intval($request->input('draw')),
				'recordsTotal' => $totalRecords,
				'recordsFiltered' => $filteredRecords,
				'data' => $bookings,
			]);
		}

		return view('admin.bookings.index');
	}

	public function create()
	{
		$schedules = Schedule::with(['train', 'route.originStation', 'route.destinationStation'])
			->where('departure_time', '>=', now())
			->orderBy('departure_time', 'asc')
			->get();

		return view('admin.bookings.create', compact('schedules'));
	}

	public function store(Request $request, BookingService $bookingService)
	{
		$request->validate([
			'schedule_id' => 'required|exists:schedules,id',
			'customer_name' => 'required|string|max:255',
			'customer_email' => 'required|email|max:255',
			'customer_phone' => 'required|string|max:20',
			'payment_method' => 'required|string|in:cash,bank_transfer,ewallet',
			'payment_status' => 'required|string|in:pending,success',
			'passengers' => 'required|array|min:1',
			'passengers.*.passenger_name' => 'required|string|max:255',
			'passengers.*.passenger_id_type' => 'required|string|in:ktp,passport,sim',
			'passengers.*.passenger_id_number' => 'required|string|max:50',
			'passengers.*.seat_id' => 'required|exists:seats,id',
		]);
		$schedule = Schedule::findOrFail($request->schedule_id);
		$bookedSeatIds = Passenger::whereHas('booking', function ($q) use ($schedule) {
			$q->where('schedule_id', $schedule->id)
				->whereIn('status', ['pending', 'paid']);
		})->pluck('seat_id')->toArray();
		foreach ($request->passengers as $p) {
			if (in_array($p['seat_id'], $bookedSeatIds)) {
				return back()->withErrors(['passengers' => 'One or more of the selected seats are already booked.'])->withInput();
			}
		}
		$booking = $bookingService->bookTicket($request->all(), auth()->id());

		return redirect()->route('admin.bookings.show', $booking)->with('success', 'Booking created successfully.');
	}

	public function getSeats(Request $request)
	{
		$request->validate([
			'schedule_id' => 'required|exists:schedules,id',
		]);
		$schedule = Schedule::with('train.carriages.seats')->findOrFail($request->schedule_id);
		$bookedSeatIds = Passenger::whereHas('booking', function ($q) use ($schedule) {
			$q->where('schedule_id', $schedule->id)
				->whereIn('status', ['pending', 'paid']);
		})->pluck('seat_id')->toArray();
		$carriagesData = [];
		foreach ($schedule->train->carriages as $carriage) {
			$seatsData = [];
			foreach ($carriage->seats as $seat) {
				$isBooked = in_array($seat->id, $bookedSeatIds);
				$isAvailable = $seat->status === 'available' && ! $isBooked;
				$seatsData[] = [
					'id' => $seat->id,
					'seat_number' => $seat->seat_number,
					'is_available' => $isAvailable,
				];
			}
			$carriagesData[] = [
				'id' => $carriage->id,
				'name' => $carriage->name,
				'class' => $carriage->class,
				'seats' => $seatsData,
			];
		}

		return response()->json($carriagesData);
	}

	public function show(Booking $booking)
	{
		$booking->load('schedule.train', 'schedule.route.originStation', 'schedule.route.destinationStation', 'passengers.seat', 'payment', 'user');

		return view('admin.bookings.show', compact('booking'));
	}

	public function update(Request $request, Booking $booking)
	{
		$data = $request->validate([
			'status' => 'required|in:pending,paid,cancelled,expired',
		]);

		$booking->update($data);

		return redirect()->route('admin.bookings.index')->with('success', 'Booking status updated successfully.');
	}
}
