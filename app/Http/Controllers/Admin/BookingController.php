<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
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
                    $q->where('booking_code', 'like', '%'.$searchValue.'%')
                        ->orWhere('customer_name', 'like', '%'.$searchValue.'%')
                        ->orWhereHas('user', function ($q2) use ($searchValue) {
                            $q2->where('name', 'like', '%'.$searchValue.'%');
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
