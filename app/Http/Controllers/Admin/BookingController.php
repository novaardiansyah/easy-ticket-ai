<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('schedule.train', 'user')->latest()->get();

        return view('admin.bookings.index', compact('bookings'));
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
