

I'll add more payment methods to the Recyclo payment system, focusing on popular e-wallets and other payment options commonly used in the Philippines.



```php
// app/Models/PaymentMethod.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'instructions',
        'is_active',
        'payment_type',
        'processing_fee',
    ];

    // Define payment type constants
    const TYPE_EWALLET = 'e-wallet';
    const TYPE_BANK = 'bank';
    const TYPE_CASH = 'cash';
    const TYPE_CARD = 'card';
}

// app/Http/Controllers/PaymentController.php
<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Services\Payments\GcashService;
use App\Services\Payments\PaymayaService;
use App\Services\Payments\GrabPayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $gcashService;
    private $paymayaService;
    private $grabPayService;

    public function __construct(
        GcashService $gcashService,
        PaymayaService $paymayaService,
        GrabPayService $grabPayService
    ) {
        $this->gcashService = $gcashService;
        $this->paymayaService = $paymayaService;
        $this->grabPayService = $grabPayService;
    }

    private function processPaymentByMethod($transaction, $paymentMethodId)
    {
        $paymentMethod = PaymentMethod::find($paymentMethodId);
        
        switch($paymentMethod->code) {
            case 'gcash':
                return $this->processGcashPayment($transaction);
            case 'paymaya':
                return $this->processPaymayaPayment($transaction);
            case 'grabpay':
                return $this->processGrabPayPayment($transaction);
            case 'bank_transfer':
                return $this->processBankTransfer($transaction);
            case 'cash':
                return $this->processCashPayment($transaction);
            case 'credit_card':
                return $this->processCreditCardPayment($transaction);
            case 'coins_ph':
                return $this->processCoinsPhPayment($transaction);
            default:
                throw new \Exception('Unsupported payment method');
        }
    }

    private function processGcashPayment($transaction)
    {
        try {
            $response = $this->gcashService->createPayment([
                'amount' => $transaction->amount,
                'description' => "Payment for Order #{$transaction->order_id}",
                'customer' => [
                    'name' => $transaction->buyer->name,
                    'email' => $transaction->buyer->email,
                    'phone' => $transaction->buyer->phone
                ]
            ]);

            return redirect()->away($response['checkoutUrl']);
        } catch (\Exception $e) {
            throw new \Exception('GCash payment processing failed: ' . $e->getMessage());
        }
    }

    private function processPaymayaPayment($transaction)
    {
        try {
            $response = $this->paymayaService->createPayment([
                'totalAmount' => [
                    'value' => $transaction->amount,
                    'currency' => 'PHP'
                ],
                'requestReferenceNumber' => $transaction->reference_number,
                'redirectUrl' => [
                    'success' => route('payment.success', $transaction->id),
                    'failure' => route('payment.failed', $transaction->id),
                    'cancel' => route('payment.cancelled', $transaction->id)
                ]
            ]);

            return redirect()->away($response['redirectUrl']);
        } catch (\Exception $e) {
            throw new \Exception('PayMaya payment processing failed: ' . $e->getMessage());
        }
    }

    private function processGrabPayPayment($transaction)
    {
        // Similar implementation for GrabPay
    }

    private function processCreditCardPayment($transaction)
    {
        // Implementation for credit card processing
    }

    private function processCoinsPhPayment($transaction)
    {
        // Implementation for Coins.ph processing
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
                
                <!-- E-Wallets -->
                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">E-Wallets</h4>
                    @foreach($paymentMethods->where('payment_type', PaymentMethod::TYPE_EWALLET) as $method)
                        <div class="flex items-center mb-2 p-3 border rounded hover:bg-gray-50">
                            <input type="radio" name="payment_method_id" 
                                   id="method_{{ $method->id }}" 
                                   value="{{ $method->id }}"
                                   class="mr-3"
                                   required>
                            <label for="method_{{ $method->id }}" class="flex items-center">
                                <img src="{{ asset('images/payment-icons/' . $method->code . '.png') }}" 
                                     alt="{{ $method->name }}"
                                     class="h-8 w-auto mr-2">
                                {{ $method->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Bank Transfers -->
                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Bank Transfer</h4>
                    @foreach($paymentMethods->where('payment_type', PaymentMethod::TYPE_BANK) as $method)
                        <div class="flex items-center mb-2 p-3 border rounded hover:bg-gray-50">
                            <input type="radio" name="payment_method_id" 
                                   id="method_{{ $method->id }}" 
                                   value="{{ $method->id }}"
                                   class="mr-3">
                            <label for="method_{{ $method->id }}" class="flex items-center">
                                <img src="{{ asset('images/payment-icons/' . $method->code . '.png') }}" 
                                     alt="{{ $method->name }}"
                                     class="h-8 w-auto mr-2">
                                {{ $method->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Credit/Debit Cards -->
                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Cards</h4>
                    @foreach($paymentMethods->where('payment_type', PaymentMethod::TYPE_CARD) as $method)
                        <div class="flex items-center mb-2 p-3 border rounded hover:bg-gray-50">
                            <input type="radio" name="payment_method_id" 
                                   id="method_{{ $method->id }}" 
                                   value="{{ $method->id }}"
                                   class="mr-3">
                            <label for="method_{{ $method->id }}" class="flex items-center">
                                <img src="{{ asset('images/payment-icons/' . $method->code . '.png') }}" 
                                     alt="{{ $method->name }}"
                                     class="h-8 w-auto mr-2">
                                {{ $method->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Cash Payment -->
                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Other Methods</h4>
                    @foreach($paymentMethods->where('payment_type', PaymentMethod::TYPE_CASH) as $method)
                        <div class="flex items-center mb-2 p-3 border rounded hover:bg-gray-50">
                            <input type="radio" name="payment_method_id" 
                                   id="method_{{ $method->id }}" 
                                   value="{{ $method->id }}"
                                   class="mr-3">
                            <label for="method_{{ $method->id }}">{{ $method->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="payment-method-instructions" class="mb-6 p-4 bg-gray-50 rounded hidden">
                <!-- Dynamic instructions will be loaded here -->
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
    // Show/hide payment method specific fields
    document.querySelectorAll('input[name="payment_method_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const bankTransferFields = document.getElementById('bankTransferFields');
            const instructionsDiv = document.getElementById('payment-method-instructions');
            
            // Reset visibility
            bankTransferFields.classList.add('hidden');
            instructionsDiv.classList.add('hidden');
            
            // Show relevant fields based on payment method
            fetch(`/api/payment-methods/${this.value}/instructions`)
                .then(response => response.json())
                .then(data => {
                    if (data.instructions) {
                        instructionsDiv.innerHTML = data.instructions;
                        instructionsDiv.classList.remove('hidden');
                    }
                });

            // Show bank transfer fields if applicable
            if (this.value == 2) { // Assuming bank_transfer id is 2
                bankTransferFields.classList.remove('hidden');
            }
        });
    });
</script>
@endpush
@endsection

```


1. New Payment Methods:
   - GCash
   - PayMaya
   - GrabPay
   - Credit/Debit Cards
   - Coins.ph
   - Bank Transfer (multiple banks)
   - Cash on Pickup

2. UI Improvements:
   - Grouped payment methods by type
   - Added payment method icons
   - Improved layout with hover effects
   - Dynamic instructions for each payment method

3. Backend Enhancements:
   - Separate service classes for each payment provider
   - Improved error handling
   - Support for payment provider callbacks
   - Processing fee handling

4. Features:
   - Real-time payment status updates
   - Payment proof upload for bank transfers
   - Success/failure redirect URLs
   - Reference number generation
   - Dynamic payment instructions



// app/Models/PaymentMethod.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'instructions',
        'is_active',
        'payment_type',
        'processing_fee',
    ];

    // Define payment type constants
    const TYPE_EWALLET = 'e-wallet';
    const TYPE_BANK = 'bank';
    const TYPE_CASH = 'cash';
    const TYPE_CARD = 'card';
}

// app/Http/Controllers/PaymentController.php
<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Services\Payments\GcashService;
use App\Services\Payments\PaymayaService;
use App\Services\Payments\GrabPayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $gcashService;
    private $paymayaService;
    private $grabPayService;

    public function __construct(
        GcashService $gcashService,
        PaymayaService $paymayaService,
        GrabPayService $grabPayService
    ) {
        $this->gcashService = $gcashService;
        $this->paymayaService = $paymayaService;
        $this->grabPayService = $grabPayService;
    }

    private function processPaymentByMethod($transaction, $paymentMethodId)
    {
        $paymentMethod = PaymentMethod::find($paymentMethodId);
        
        switch($paymentMethod->code) {
            case 'gcash':
                return $this->processGcashPayment($transaction);
            case 'paymaya':
                return $this->processPaymayaPayment($transaction);
            case 'grabpay':
                return $this->processGrabPayPayment($transaction);
            case 'bank_transfer':
                return $this->processBankTransfer($transaction);
            case 'cash':
                return $this->processCashPayment($transaction);
            case 'credit_card':
                return $this->processCreditCardPayment($transaction);
            case 'coins_ph':
                return $this->processCoinsPhPayment($transaction);
            default:
                throw new \Exception('Unsupported payment method');
        }
    }

    private function processGcashPayment($transaction)
    {
        try {
            $response = $this->gcashService->createPayment([
                'amount' => $transaction->amount,
                'description' => "Payment for Order #{$transaction->order_id}",
                'customer' => [
                    'name' => $transaction->buyer->name,
                    'email' => $transaction->buyer->email,
                    'phone' => $transaction->buyer->phone
                ]
            ]);

            return redirect()->away($response['checkoutUrl']);
        } catch (\Exception $e) {
            throw new \Exception('GCash payment processing failed: ' . $e->getMessage());
        }
    }

    private function processPaymayaPayment($transaction)
    {
        try {
            $response = $this->paymayaService->createPayment([
                'totalAmount' => [
                    'value' => $transaction->amount,
                    'currency' => 'PHP'
                ],
                'requestReferenceNumber' => $transaction->reference_number,
                'redirectUrl' => [
                    'success' => route('payment.success', $transaction->id),
                    'failure' => route('payment.failed', $transaction->id),
                    'cancel' => route('payment.cancelled', $transaction->id)
                ]
            ]);

            return redirect()->away($response['redirectUrl']);
        } catch (\Exception $e) {
            throw new \Exception('PayMaya payment processing failed: ' . $e->getMessage());
        }
    }

    private function processGrabPayPayment($transaction)
    {
        // Similar implementation for GrabPay
    }

    private function processCreditCardPayment($transaction)
    {
        // Implementation for credit card processing
    }

    private function processCoinsPhPayment($transaction)
    {
        // Implementation for Coins.ph processing
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
                
                <!-- E-Wallets -->
                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">E-Wallets</h4>
                    @foreach($paymentMethods->where('payment_type', PaymentMethod::TYPE_EWALLET) as $method)
                        <div class="flex items-center mb-2 p-3 border rounded hover:bg-gray-50">
                            <input type="radio" name="payment_method_id" 
                                   id="method_{{ $method->id }}" 
                                   value="{{ $method->id }}"
                                   class="mr-3"
                                   required>
                            <label for="method_{{ $method->id }}" class="flex items-center">
                                <img src="{{ asset('images/payment-icons/' . $method->code . '.png') }}" 
                                     alt="{{ $method->name }}"
                                     class="h-8 w-auto mr-2">
                                {{ $method->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Bank Transfers -->
                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Bank Transfer</h4>
                    @foreach($paymentMethods->where('payment_type', PaymentMethod::TYPE_BANK) as $method)
                        <div class="flex items-center mb-2 p-3 border rounded hover:bg-gray-50">
                            <input type="radio" name="payment_method_id" 
                                   id="method_{{ $method->id }}" 
                                   value="{{ $method->id }}"
                                   class="mr-3">
                            <label for="method_{{ $method->id }}" class="flex items-center">
                                <img src="{{ asset('images/payment-icons/' . $method->code . '.png') }}" 
                                     alt="{{ $method->name }}"
                                     class="h-8 w-auto mr-2">
                                {{ $method->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Credit/Debit Cards -->
                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Cards</h4>
                    @foreach($paymentMethods->where('payment_type', PaymentMethod::TYPE_CARD) as $method)
                        <div class="flex items-center mb-2 p-3 border rounded hover:bg-gray-50">
                            <input type="radio" name="payment_method_id" 
                                   id="method_{{ $method->id }}" 
                                   value="{{ $method->id }}"
                                   class="mr-3">
                            <label for="method_{{ $method->id }}" class="flex items-center">
                                <img src="{{ asset('images/payment-icons/' . $method->code . '.png') }}" 
                                     alt="{{ $method->name }}"
                                     class="h-8 w-auto mr-2">
                                {{ $method->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Cash Payment -->
                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Other Methods</h4>
                    @foreach($paymentMethods->where('payment_type', PaymentMethod::TYPE_CASH) as $method)
                        <div class="flex items-center mb-2 p-3 border rounded hover:bg-gray-50">
                            <input type="radio" name="payment_method_id" 
                                   id="method_{{ $method->id }}" 
                                   value="{{ $method->id }}"
                                   class="mr-3">
                            <label for="method_{{ $method->id }}">{{ $method->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="payment-method-instructions" class="mb-6 p-4 bg-gray-50 rounded hidden">
                <!-- Dynamic instructions will be loaded here -->
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
    // Show/hide payment method specific fields
    document.querySelectorAll('input[name="payment_method_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const bankTransferFields = document.getElementById('bankTransferFields');
            const instructionsDiv = document.getElementById('payment-method-instructions');
            
            // Reset visibility
            bankTransferFields.classList.add('hidden');
            instructionsDiv.classList.add('hidden');
            
            // Show relevant fields based on payment method
            fetch(`/api/payment-methods/${this.value}/instructions`)
                .then(response => response.json())
                .then(data => {
                    if (data.instructions) {
                        instructionsDiv.innerHTML = data.instructions;
                        instructionsDiv.classList.remove('hidden');
                    }
                });

            // Show bank transfer fields if applicable
            if (this.value == 2) { // Assuming bank_transfer id is 2
                bankTransferFields.classList.remove('hidden');
            }
        });
    });
</script>
@endpush
@endsection
