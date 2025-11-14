<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = auth()->user()->payments()
            ->with('plan')
            ->latest()
            ->paginate(15);
        
        return view('payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::where('user_id', auth()->id())
            ->with(['plan', 'subscription'])
            ->findOrFail($id);
        
        return view('payments.show', compact('payment'));
    }
}
