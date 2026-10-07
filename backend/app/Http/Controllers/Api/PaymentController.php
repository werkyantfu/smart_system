<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('fee.student');

        if ($request->fee_id) {
            $query->where('fee_id', $request->fee_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $payments,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fee_id' => 'required|exists:fees,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,telebirr,cbe_birr,bank_transfer',
        ]);

        $validated['transaction_ref'] = 'TXN-' . strtoupper(Str::random(10));
        $validated['status'] = 'completed';
        $validated['paid_at'] = now();

        $payment = Payment::create($validated);

        // Update fee status
        $fee = Fee::find($validated['fee_id']);
        $totalPaid = $fee->payments()->sum('amount');
        if ($totalPaid >= $fee->amount) {
            $fee->update(['status' => 'paid']);
        } else if ($totalPaid > 0) {
            $fee->update(['status' => 'partial']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment recorded successfully',
            'data' => $payment,
        ], 201);
    }

    public function show(Payment $payment)
    {
        $payment->load('fee.student');

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }
}
