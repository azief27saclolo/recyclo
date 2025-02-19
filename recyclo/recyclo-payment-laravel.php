// app/Models/Transaction.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'buyer_id',
        'seller_id',
        'payment_method_id',
        'amount',
        'platform_fee',
        'status',
        'reference_number',
        'payment_proof'
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}

// app/Http/Controllers/PaymentController.php
<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentForm($orderId)
    {
        $order = Order::findOrFail($orderId);
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        
        return view('payments.form', compact('order', 'paymentMethods'));
    }

    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_proof' => 'required_if:payment_method,bank_transfer|image|max:2048'
        ]);

        try {
            // Calculate platform fee
            $order = Order::find($validated['order_id']);
            $platformFee = $this->calculatePlatformFee($order->total_amount);

            // Create transaction record
            $transaction = Transaction::create([
                'order_id' => $validated['order_id'],
                'buyer_id' => auth()->id(),
                'seller_id' => $order->seller_id,
                'payment_method_id' => $validated['payment_method_id'],
                'amount' => $order->total_amount,
                'platform_fee' => $platformFee,
                'status' => 'pending',
                'reference_number' => 'PAY-' . uniqid(),
            ]);

            // Handle payment proof upload if bank transfer
            if ($request->hasFile('payment_proof')) {
                $path = $request->file('payment_proof')->store('payment_proofs');
                $transaction->update(['payment_proof' => $path]);
            }

            // Process payment based on method
            $result = $this->processPaymentByMethod(
                $transaction, 
                $validated['payment_method_id']
            );

            return redirect()->route('payment.status', $transaction->id)
                           ->with('success', 'Payment is being processed');

        } catch (\Exception $e) {
            return back()->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    private function calculatePlatformFee($amount)
    {
        // Get platform fee settings from database
        $feeSettings = PlatformFee::where('is_active', true)->first();
        
        $percentageFee = ($amount * $feeSettings->percentage_fee) / 100;
        $totalFee = $percentageFee + $feeSettings->fixed_fee;
        
        // Apply min/max constraints
        return min(max($totalFee, $feeSettings->min_fee), $feeSettings->max_fee);
    }

    private function processPaymentByMethod($transaction, $paymentMethodId)
    {
        $paymentMethod = PaymentMethod::find($paymentMethodId);
        
        switch($paymentMethod->code) {
            case 'gcash':
                return $this->processGcashPayment($transaction);
            case 'bank_transfer':
                return $this->processBankTransfer($transaction);
            case 'cash':
                return $this->processCashPayment($transaction);
            default:
                throw new \Exception('Unsupported payment method');
        }
    }
}

// resources/views/payments/form.blade.php
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Payment Details</h2>
        
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Order Summary</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p>Order ID: #{{ $order->id }}</p>
                <p>Total Amount: ₱{{ number_format($order->total_amount, 2) }}</p>
                <p>Seller: {{ $order->seller->name }}</p>
            </div>
        </div>

        <form action="{{ route('payment.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            
            <div class="mb-6">
                <label class="block mb-2 font-medium">Select Payment Method</label>
                @foreach($paymentMethods as $method)
                    <div class="mb-2">
                        <input type="radio" name="payment_method_id" 
                               id="method_{{ $method->id }}" 
                               value="{{ $method->id }}"
                               class="mr-2"
                               required>
                        <label for="method_{{ $method->id }}">{{ $method->name }}</label>
                    </div>
                @endforeach
            </div>

            <div id="bankTransferFields" class="mb-6 hidden">
                <label class="block mb-2 font-medium">Upload Payment Proof</label>
                <input type="file" name="payment_proof" class="w-full">
                <p class="text-sm text-gray-600 mt-1">
                    Please upload a screenshot of your bank transfer receipt
                </p>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                Proceed with Payment
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Show/hide bank transfer fields based on payment method selection
    document.querySelectorAll('input[name="payment_method_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const bankTransferFields = document.getElementById('bankTransferFields');
            // Assuming bank_transfer method has id 2
            bankTransferFields.classList.toggle('hidden', this.value != 2);
        });
    });
</script>
@endpush
@endsection

// resources/views/payments/status.blade.php
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Payment Status</h2>
        
        <div class="mb-6">
            @if($transaction->status === 'completed')
                <div class="bg-green-100 p-4 rounded">
                    <p class="text-green-700">Payment Successful!</p>
                    <p class="mt-2">Reference Number: {{ $transaction->reference_number }}</p>
                </div>
            @elseif($transaction->status === 'pending')
                <div class="bg-yellow-100 p-4 rounded">
                    <p class="text-yellow-700">Payment is being processed...</p>
                    <p class="mt-2">Reference Number: {{ $transaction->reference_number }}</p>
                </div>
            @else
                <div class="bg-red-100 p-4 rounded">
                    <p class="text-red-700">Payment Failed</p>
                    <p class="mt-2">Please try again or contact support.</p>
                </div>
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ route('orders.show', $transaction->order_id) }}" 
               class="inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                View Order Details
            </a>
        </div>
    </div>
</div>
@endsection




/* NOTES!!!!!!!!!!!!!!!!!!!!!!!! ///

This implementation includes:

Transaction Model:

Defines relationships with users, orders, and payment methods
Handles fillable fields for payment processing


Payment Controller:

Shows payment form
Processes payments
Calculates platform fees
Handles different payment methods
Manages payment proof uploads


Blade Views:

Payment form with multiple payment methods
Status page for payment tracking
Responsive design using Tailwind CSS
JavaScript for dynamic form fields



*/
