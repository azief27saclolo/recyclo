<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuyMarketplaceController;

Route::get('/buy-marketplace', [BuyMarketplaceController::class, 'index'])->name('buy.marketplace');
