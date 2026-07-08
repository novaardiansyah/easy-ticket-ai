<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingService
{
	public function bookTicket(array $data, ?int $userId): Booking
	{
		$schedule      = Schedule::findOrFail($data['schedule_id']);
		$bookingStatus = $data['payment_status'] === 'success' ? 'paid' : 'pending';
		$paymentStatus = $data['payment_status'];

		return DB::transaction(function () use ($data, $schedule, $bookingStatus, $paymentStatus, $userId) {
			do {
				$bookingCode = Str::upper(Str::random(8));
			} while (Booking::where('booking_code', $bookingCode)->exists());
			$totalPrice = $schedule->base_price * count($data['passengers']);
			$booking = Booking::create([
				'booking_code'   => $bookingCode,
				'user_id'        => $userId,
				'customer_name'  => $data['customer_name'],
				'customer_email' => $data['customer_email'],
				'customer_phone' => $data['customer_phone'],
				'schedule_id'    => $schedule->id,
				'total_price'    => $totalPrice,
				'status'         => $bookingStatus,
				'expired_at'     => now()->addHours(2),
			]);
			Payment::create([
				'booking_id'     => $booking->id,
				'payment_method' => $data['payment_method'],
				'transaction_id' => $data['payment_method'] === 'cash' ? 'CASH-' . $bookingCode : 'TXN-' . Str::upper(Str::random(10)),
				'amount'         => $totalPrice,
				'status'         => $paymentStatus,
				'paid_at'        => $paymentStatus === 'success' ? now() : null,
			]);
			foreach ($data['passengers'] as $p) {
				Passenger::create([
					'booking_id'          => $booking->id,
					'seat_id'             => $p['seat_id'],
					'passenger_name'      => $p['passenger_name'],
					'passenger_id_type'   => $p['passenger_id_type'],
					'passenger_id_number' => $p['passenger_id_number'],
					'ticket_number'       => 'TKT-' . $bookingCode . '-' . $p['seat_id'],
				]);
			}
			return $booking;
		});
	}
}
