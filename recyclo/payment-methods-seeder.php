

<!-- 
 


<!-- 
This will:

Add all payment methods to your database
Set up proper descriptions and instructions
Configure processing fees
Set active status

The seeder includes:

E-wallets (GCash, PayMaya, GrabPay, Coins.ph)
Bank transfers (BDO, BPI, Union Bank)
Credit/Debit cards
Cash on pickup -->


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodsSeeder extends Seeder
{
    public function run()
    {
        // E-Wallets
        $ewallets = [
            [
                'name' => 'GCash',
                'code' => 'gcash',
                'description' => 'Pay using GCash e-wallet',
                'instructions' => 'You will be redirected to GCash to complete your payment.',
                'payment_type' => PaymentMethod::TYPE_EWALLET,
                'processing_fee' => 2.00,
                'is_active' => true
            ],
            [
                'name' => 'PayMaya',
                'code' => 'paymaya',
                'description' => 'Pay using PayMaya e-wallet',
                'instructions' => 'You will be redirected to PayMaya to complete your payment.',
                'payment_type' => PaymentMethod::TYPE_EWALLET,
                'processing_fee' => 2.00,
                'is_active' => true
            ],
            [
                'name' => 'GrabPay',
                'code' => 'grabpay',
                'description' => 'Pay using GrabPay e-wallet',
                'instructions' => 'You will be redirected to GrabPay to complete your payment.',
                'payment_type' => PaymentMethod::TYPE_EWALLET,
                'processing_fee' => 2.00,
                'is_active' => true
            ],
            [
                'name' => 'Coins.ph',
                'code' => 'coins_ph',
                'description' => 'Pay using Coins.ph wallet',
                'instructions' => 'You will be redirected to Coins.ph to complete your payment.',
                'payment_type' => PaymentMethod::TYPE_EWALLET,
                'processing_fee' => 2.00,
                'is_active' => true
            ]
        ];

        // Bank Transfers
        $banks = [
            [
                'name' => 'BDO Transfer',
                'code' => 'bdo',
                'description' => 'Direct bank transfer to BDO account',
                'instructions' => "Account Name: RECYCLO\nAccount Number: 1234567890\nBank: BDO\n\nPlease upload your proof of payment after transferring.",
                'payment_type' => PaymentMethod::TYPE_BANK,
                'processing_fee' => 0.00,
                'is_active' => true
            ],
            [
                'name' => 'BPI Transfer',
                'code' => 'bpi',
                'description' => 'Direct bank transfer to BPI account',
                'instructions' => "Account Name: RECYCLO\nAccount Number: 0987654321\nBank: BPI\n\nPlease upload your proof of payment after transferring.",
                'payment_type' => PaymentMethod::TYPE_BANK,
                'processing_fee' => 0.00,
                'is_active' => true
            ],
            [
                'name' => 'Union Bank Transfer',
                'code' => 'unionbank',
                'description' => 'Direct bank transfer to Union Bank account',
                'instructions' => "Account Name: RECYCLO\nAccount Number: 1357924680\nBank: Union Bank\n\nPlease upload your proof of payment after transferring.",
                'payment_type' => PaymentMethod::TYPE_BANK,
                'processing_fee' => 0.00,
                'is_active' => true
            ]
        ];

        // Credit/Debit Cards
        $cards = [
            [
                'name' => 'Credit/Debit Card',
                'code' => 'card',
                'description' => 'Pay using Visa, Mastercard, or JCB',
                'instructions' => 'You will be redirected to our secure payment gateway to complete your card payment.',
                'payment_type' => PaymentMethod::TYPE_CARD,
                'processing_fee' => 2.50,
                'is_active' => true
            ]
        ];

        // Cash Payment
        $cash = [
            [
                'name' => 'Cash on Pickup',
                'code' => 'cash',
                'description' => 'Pay with cash when picking up items',
                'instructions' => 'Please prepare the exact amount when picking up your items.',
                'payment_type' => PaymentMethod::TYPE_CASH,
                'processing_fee' => 0.00,
                'is_active' => true
            ]
        ];

        // Insert all payment methods
        foreach (array_merge($ewallets, $banks, $cards, $cash) as $method) {
            PaymentMethod::updateOrCreate(
                ['code' => $method['code']],
                $method
            );
        }
    }
}
