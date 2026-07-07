<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = Payment::with('booking.schedule.train');
            $totalRecords = $query->count();
            if ($request->filled('search.value')) {
                $searchValue = $request->input('search.value');
                $query->where(function ($q) use ($searchValue) {
                    $q->where('payment_method', 'like', '%'.$searchValue.'%')
                        ->orWhere('transaction_id', 'like', '%'.$searchValue.'%')
                        ->orWhereHas('booking', function ($q2) use ($searchValue) {
                            $q2->where('booking_code', 'like', '%'.$searchValue.'%');
                        });
                });
            }
            $filteredRecords = $query->count();
            $query->latest();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $payments = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $payments,
            ]);
        }

        return view('admin.payments.index');
    }

    public function show(Payment $payment)
    {
        $payment->load('booking');

        return view('admin.payments.show', compact('payment'));
    }
}
