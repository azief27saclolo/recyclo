@extends('components.layout')

@section('content')
<div class="container">
    <section class="section checkout" id="checkout" aria-label="checkout">
        <div class="container">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 class="h2 section-title" style="font-size: 36px;">Checkout</h2>
                <p style="color: #666; margin-top: 5px; font-size: 18px;">Complete your purchase</p>
            </div>

            @if(session('warning'))
            <div style="max-width: 800px; margin: 0 auto 20px auto; background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 10px; padding: 15px 20px; text-align: center;">
                <i class="bi bi-exclamation-triangle" style="font-size: 20px; margin-right: 10px; vertical-align: middle;"></i>
                <span style="vertical-align: middle; font-size: 16px;">{{ session('warning') }}</span>
            </div>
            @endif

            <!-- Admin Approval Notice -->
            <div style="max-width: 800px; margin: 0 auto 20px auto; background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 10px; padding: 15px 20px; text-align: center;">
                <i class="bi bi-info-circle" style="font-size: 20px; margin-right: 10px; vertical-align: middle;"></i>
                <span style="vertical-align: middle; font-size: 16px;">Your order will be submitted as a request and requires admin approval before processing.</span>
            </div>

            <div style="max-width: 800px; margin: 0 auto; padding: 20px;">
                <!-- Order Summary -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 25px; overflow: hidden;">
                    <div style="background: #517a5b; color: white; padding: 15px 20px;">
                        <h3 style="margin: 0; font-size: 20px;">Order Summary</h3>
                    </div>
                    <div style="padding: 20px;">
                        @php 
                            // Filter out items with missing data first
                            $validItems = $cart->items->filter(function($item) {
                                return $item->product && $item->product->post && $item->product->post->user;
                            });
                            
                            // Group only valid items by seller ID
                            $sellerGroups = $validItems->groupBy(function($item) {
                                return $item->product->post->user->id;
                            });
                            
                            $totalItems = $validItems->sum('quantity');
                        @endphp

                        @foreach($sellerGroups as $sellerId => $items)
                            @php 
                                $firstItem = $items->first();
                                $seller = $firstItem->product->post->user;
                                $sellerTotal = $items->sum(function($item) { 
                                    return $item->quantity * $item->price; 
                                });
                            @endphp

                            <div style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eee;">
                                <div style="color: #517a5b; font-size: 16px; margin-bottom: 10px; font-weight: 600;">
                                    <i class="bi bi-shop"></i> {{ $seller->username }}'s Shop
                                </div>

                                @foreach($items as $item)
                                    <div style="display: flex; gap: 20px; padding-bottom: 15px; margin-bottom: 15px; border-bottom: 1px dashed #eee;">
                                        <!-- Product Image -->
                                        <img src="{{ asset('storage/' . $item->product->post->image) }}" alt="{{ $item->product->post->title }}" 
                                            style="width: 80px; height: 80px; border-radius: 10px; object-fit: cover;">
                                        
                                        <!-- Product Details -->
                                        <div style="flex: 1;">
                                            <h4 style="margin: 0 0 5px 0; font-size: 18px;">{{ $item->product->post->title }}</h4>
                                            <div style="color: #666; font-size: 16px;">₱{{ number_format($item->price, 2) }} × {{ $item->quantity }} kg</div>
                                            <div style="color: #517a5b; font-weight: 600; font-size: 16px; margin-top: 5px;">
                                                ₱{{ number_format($item->price * $item->quantity, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <!-- Seller Subtotal -->
                                <div style="display: flex; justify-content: space-between; padding: 10px 15px; background: #f9f9f9; border-radius: 8px;">
                                    <span style="font-size: 16px;">Seller Subtotal:</span>
                                    <span style="font-size: 16px; font-weight: 600;">₱{{ number_format($sellerTotal, 2) }}</span>
                                </div>
                            </div>
                        @endforeach

                        <div style="margin-top: 20px;">
                            <div style="display: flex; justify-content: space-between; padding: 10px 0; color: #666;">
                                <span style="font-size: 18px;">Subtotal ({{ $totalItems }} items)</span>
                                <span style="font-size: 18px;">₱{{ number_format($totalPrice, 2) }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-top: 2px solid #eee; margin-top: 10px; padding-top: 15px; font-weight: 600; color: #517a5b; font-size: 24px;">
                                <span>Total</span>
                                <span>₱{{ number_format($totalPrice, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 25px; overflow: hidden;">
                    <div style="background: #517a5b; color: white; padding: 15px 20px;">
                        <h3 style="margin: 0; font-size: 20px;">Payment Details</h3>
                    </div>
                    <div style="padding: 20px;">
                        <div style="background: #f8f9fa; border-radius: 10px; padding: 30px; margin-bottom: 20px; text-align: center;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
                                <img src="{{ asset('/images/gcash-qr.jpeg') }}" alt="GCash" style="height: 500px; width: auto; object-fit: contain; max-width: 100%;">
                                <div style="width: 100%; text-align: center; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                                    <p style="color: #666; margin-bottom: 10px; font-size: 18px;">Scan / Send payment to:</p>
                                    <p style="font-size: 32px; font-weight: 600; color: #517a5b; margin: 10px 0;">0929 519 0987</p>
                                    <p style="color: #333; font-size: 22px; font-weight: 500;">Recyclo Admin</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Delivery Method Selection -->
                        <div style="margin: 25px 0; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                            <h4 style="color: #517a5b; margin-bottom: 15px; font-size: 20px;">Delivery Method</h4>
                            <p style="margin-bottom: 15px; color: #666; font-size: 16px;">Choose your preferred delivery method.</p>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <!-- Pickup Option -->
                                <label class="delivery-option" for="pickup" style="cursor: pointer; border: 2px solid #e0e0e0; border-radius: 10px; padding: 20px; background: white; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; text-align: center;">
                                    <input type="radio" id="pickup" name="delivery_method" value="pickup" checked style="margin-bottom: 10px; transform: scale(1.2);">
                                    <i class="bi bi-geo-alt" style="font-size: 32px; color: #517a5b; margin-bottom: 10px;"></i>
                                    <h5 style="margin-bottom: 5px; color: #333; font-size: 18px;">Pickup</h5>
                                    <p style="color: #666; font-size: 14px; margin: 0;">Pick up from seller's location</p>
                                    <span style="color: #28a745; font-weight: 600; font-size: 16px; margin-top: 5px;">Free</span>
                                </label>
                                
                                <!-- Delivery Option -->
                                <label class="delivery-option" for="delivery" style="cursor: pointer; border: 2px solid #e0e0e0; border-radius: 10px; padding: 20px; background: white; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; text-align: center;">
                                    <input type="radio" id="delivery" name="delivery_method" value="delivery" style="margin-bottom: 10px; transform: scale(1.2);">
                                    <i class="bi bi-truck" style="font-size: 32px; color: #517a5b; margin-bottom: 10px;"></i>
                                    <h5 style="margin-bottom: 5px; color: #333; font-size: 18px;">Delivery</h5>
                                    <p style="color: #666; font-size: 14px; margin: 0;">We'll deliver to your address</p>
                                    <span style="color: #dc3545; font-weight: 600; font-size: 16px; margin-top: 5px;">₱50 - ₱150</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Receipt Upload Section -->
                        <div style="margin: 25px 0; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                            <h4 style="color: #517a5b; margin-bottom: 15px; font-size: 20px;">Upload Payment Receipt</h4>
                            <p style="margin-bottom: 15px; color: #666; font-size: 16px;">Please upload a screenshot of your payment receipt for verification.</p>
                            
                            <div style="display: flex; flex-direction: column; gap: 15px;">
                                <div style="position: relative; border: 2px dashed #517a5b; border-radius: 10px; padding: 20px; text-align: center; background: white;">
                                    <input type="file" id="receiptImage" accept="image/*" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;">
                                    <div id="uploadPlaceholder">
                                        <i class="bi bi-cloud-arrow-up" style="font-size: 40px; color: #517a5b;"></i>
                                        <p style="margin-top: 10px; color: #517a5b;">Click to upload or drag and drop</p>
                                        <p style="font-size: 14px; color: #666;">PNG, JPG or JPEG (max. 5MB)</p>
                                    </div>
                                    <div id="imagePreviewContainer" style="display: none;">
                                        <img id="imagePreview" src="" alt="Receipt Preview" style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                                        <button type="button" id="removeImage" style="position: absolute; top: 10px; right: 10px; background: #ff6b6b; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="uploadError" style="color: #dc3545; font-size: 14px; display: none;"></div>
                            </div>
                        </div>
                        
                        
                        <!-- Pickup Information Section -->
                        <div id="pickupInfoSection" style="margin: 25px 0; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                            <h4 style="color: #517a5b; margin-bottom: 15px; font-size: 20px;">
                                <i class="bi bi-geo-alt" style="margin-right: 8px;"></i>
                                Pickup Information
                            </h4>
                            
                            @foreach($sellerGroups as $sellerId => $items)
                                @php 
                                    $firstItem = $items->first();
                                    $seller = $firstItem->product->post->user;
                                    $location = $firstItem->product->post->location ?? 'Location not specified';
                                @endphp
                                <div style="margin-bottom: 15px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #517a5b;">
                                    <div style="display: flex; align-items: center; margin-bottom: 12px;">
                                        <i class="bi bi-shop" style="font-size: 20px; color: #517a5b; margin-right: 10px;"></i>
                                        <h5 style="margin: 0; color: #333; font-size: 18px; font-weight: 600;">{{ $seller->username }}'s Shop</h5>
                                    </div>
                                    
                                    <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                        <i class="bi bi-geo-alt-fill" style="font-size: 16px; color: #666; margin-right: 8px;"></i>
                                        <span style="color: #333; font-size: 16px;">{{ $location }}</span>
                                    </div>
                                    
                                    <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                        <i class="bi bi-telephone-fill" style="font-size: 16px; color: #666; margin-right: 8px;"></i>
                                        <span style="color: #333; font-size: 16px;">{{ $seller->number ?? 'Contact number not available' }}</span>
                                    </div>
                                    
                                    <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                        <i class="bi bi-clock-fill" style="font-size: 16px; color: #666; margin-right: 8px;"></i>
                                        <span style="color: #333; font-size: 16px;">Business Hours: 9:00 AM - 6:00 PM</span>
                                    </div>

                                    <!-- Pickup Status Badge -->
                                    <div style="display: flex; align-items: center; margin-top: 12px;">
                                        <i class="bi bi-check-circle-fill" style="font-size: 16px; color: #28a745; margin-right: 8px;"></i>
                                        <span style="background: #d4edda; color: #155724; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">Available for Pickup</span>
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Pickup Preferences Section -->
                            <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px;">
                                <h5 style="color: #333; margin-bottom: 15px; font-size: 18px;">
                                    <i class="bi bi-calendar-check" style="margin-right: 8px;"></i>
                                    Pickup Preferences
                                </h5>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                                    <div>
                                        <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 500;">Preferred Pickup Date</label>
                                        <input type="date" id="pickupDate" name="pickup_date" 
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                               value="{{ date('Y-m-d', strtotime('+2 days')) }}"
                                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 500;">Preferred Time</label>
                                        <select id="pickupTime" name="pickup_time" 
                                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                                            <option value="morning">Morning (9:00 AM - 12:00 PM)</option>
                                            <option value="afternoon">Afternoon (12:00 PM - 3:00 PM)</option>
                                            <option value="evening">Evening (3:00 PM - 6:00 PM)</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 500;">Pickup Notes (Optional)</label>
                                    <textarea id="pickupNotes" name="pickup_notes" rows="3" placeholder="Any special instructions or notes for the seller..."
                                              style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: vertical;"></textarea>
                                </div>
                            </div>
                            
                            <!-- Enhanced Pickup Instructions -->
                            <div style="background: #e7f3ff; border-left: 4px solid #007bff; padding: 15px; border-radius: 8px; margin-top: 15px;">
                                <div style="display: flex; align-items: flex-start;">
                                    <i class="bi bi-info-circle-fill" style="font-size: 18px; color: #007bff; margin-right: 10px; margin-top: 2px;"></i>
                                    <div>
                                        <p style="color: #333; font-size: 16px; margin: 0 0 10px 0; font-weight: 600;">Pickup Instructions:</p>
                                        <ul style="color: #666; font-size: 14px; margin: 0; padding-left: 20px;">
                                            <li><strong>Timing:</strong> Pick up your order within 3 days after approval</li>
                                            <li><strong>Requirements:</strong> Bring a valid ID and your order reference number</li>
                                            <li><strong>Contact:</strong> Call the seller 30 minutes before your visit</li>
                                            <li><strong>Verification:</strong> Inspect and verify all items before leaving</li>
                                            <li><strong>Payment:</strong> Ensure your payment receipt is ready for verification</li>
                                        </ul>
                                        
                                        <div style="margin-top: 15px; padding: 10px; background: #fff3cd; border-radius: 6px; border-left: 3px solid #ffc107;">
                                            <p style="color: #856404; font-size: 14px; margin: 0; font-weight: 500;">
                                                <i class="bi bi-exclamation-triangle-fill" style="margin-right: 5px;"></i>
                                                Important: Orders not picked up within 3 days will be automatically cancelled and refunded.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Information Section -->
                        <div id="deliveryInfoSection" style="margin: 25px 0; padding: 20px; background: #f8f9fa; border-radius: 10px; display: none;">
                            <h4 style="color: #517a5b; margin-bottom: 15px; font-size: 20px;">
                                <i class="bi bi-truck" style="margin-right: 8px;"></i>
                                Delivery Information
                            </h4>
                            
                            <!-- Delivery Address Form -->
                            <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px;">
                                <h5 style="color: #333; margin-bottom: 15px; font-size: 18px;">
                                    <i class="bi bi-house-door" style="margin-right: 8px;"></i>
                                    Delivery Address
                                </h5>
                                
                                <!-- Address Selection Options -->
                                @if($userLocation)
                                <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #517a5b;">
                                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                        <input type="radio" id="useSavedAddress" name="address_option" value="saved" checked 
                                               style="margin-right: 10px; transform: scale(1.2);">
                                        <label for="useSavedAddress" style="font-weight: 600; color: #333; cursor: pointer;">
                                            <i class="bi bi-geo-alt-fill" style="color: #517a5b; margin-right: 5px;"></i>
                                            Use my saved address
                                        </label>
                                    </div>
                                    <div style="padding-left: 30px; color: #666; font-size: 14px;">
                                        {{ $userLocation }}
                                    </div>
                                </div>
                                
                                <div style="margin-bottom: 20px;">
                                    <div style="display: flex; align-items: center;">
                                        <input type="radio" id="useDifferentAddress" name="address_option" value="different" 
                                               style="margin-right: 10px; transform: scale(1.2);">
                                        <label for="useDifferentAddress" style="font-weight: 600; color: #333; cursor: pointer;">
                                            <i class="bi bi-plus-circle" style="color: #517a5b; margin-right: 5px;"></i>
                                            Use a different address
                                        </label>
                                    </div>
                                </div>
                                @endif
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                                    <div>
                                        <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 500;">Full Name *</label>
                                        <input type="text" id="deliveryName" name="delivery_name" value="{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}" 
                                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;" required>
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 500;">Phone Number *</label>
                                        <input type="text" id="deliveryPhone" name="delivery_phone" value="{{ Auth::user()->number }}" 
                                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;" required>
                                    </div>
                                </div>
                                
                                <div id="manualAddressFields" style="{{ $userLocation ? 'display: none;' : '' }}">
                                    <div style="margin-bottom: 15px;">
                                        <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 500;">Street Address *</label>
                                        <input type="text" id="deliveryAddress" name="delivery_address" placeholder="House number, street name" 
                                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;" {{ !$userLocation ? 'required' : '' }}>
                                    </div>
                                    
                                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                                        <div>
                                            <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 500;">City *</label>
                                            <input type="text" id="deliveryCity" name="delivery_city" 
                                                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;" {{ !$userLocation ? 'required' : '' }}>
                                        </div>
                                        <div>
                                            <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 500;">Province *</label>
                                            <input type="text" id="deliveryProvince" name="delivery_province" 
                                                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;" {{ !$userLocation ? 'required' : '' }}>
                                        </div>
                                        <div>
                                            <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 500;">Postal Code</label>
                                            <input type="text" id="deliveryPostal" name="delivery_postal" 
                                                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hidden input to store the selected address -->
                                <input type="hidden" id="selectedDeliveryAddress" name="selected_delivery_address" value="{{ $userLocation ?? '' }}">
                                
                                <div>
                                    <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 500;">Delivery Instructions (Optional)</label>
                                    <textarea id="deliveryInstructions" name="delivery_instructions" rows="3" placeholder="Any special instructions for delivery..."
                                              style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: vertical;"></textarea>
                                </div>
                            </div>
                            
                            <!-- Delivery Options -->
                            <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px;">
                                <h5 style="color: #333; margin-bottom: 15px; font-size: 18px;">
                                    <i class="bi bi-clock" style="margin-right: 8px;"></i>
                                    Delivery Options
                                </h5>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                    <label class="delivery-speed-option" for="standard" style="cursor: pointer; border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; background: white; transition: all 0.3s ease;">
                                        <input type="radio" id="standard" name="delivery_speed" value="standard" checked style="margin-bottom: 8px;">
                                        <div style="font-weight: 600; color: #333; margin-bottom: 4px;">Standard Delivery</div>
                                        <div style="color: #666; font-size: 14px; margin-bottom: 4px;">3-5 business days</div>
                                        <div style="color: #28a745; font-weight: 600;">₱50</div>
                                    </label>
                                    
                                    <label class="delivery-speed-option" for="express" style="cursor: pointer; border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; background: white; transition: all 0.3s ease;">
                                        <input type="radio" id="express" name="delivery_speed" value="express" style="margin-bottom: 8px;">
                                        <div style="font-weight: 600; color: #333; margin-bottom: 4px;">Express Delivery</div>
                                        <div style="color: #666; font-size: 14px; margin-bottom: 4px;">1-2 business days</div>
                                        <div style="color: #dc3545; font-weight: 600;">₱150</div>
                                    </label>
                                </div>
                            </div>
                            
                            <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; border-radius: 8px;">
                                <div style="display: flex; align-items: flex-start;">
                                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 18px; color: #856404; margin-right: 10px; margin-top: 2px;"></i>
                                    <div>
                                        <p style="color: #856404; font-size: 16px; margin: 0 0 5px 0; font-weight: 600;">Delivery Notes:</p>
                                        <ul style="color: #856404; font-size: 14px; margin: 0; padding-left: 20px;">
                                            <li>Delivery fees may vary based on location and distance</li>
                                            <li>Orders will be delivered during business hours (9 AM - 6 PM)</li>
                                            <li>Someone must be available to receive the delivery</li>
                                            <li>Additional charges may apply for remote areas</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="display: grid; gap: 15px; margin-top: 25px;">
                            <button type="button" onclick="placeOrder()" 
                                    style="background: #517a5b; color: white; border: none; padding: 15px; border-radius: 8px; font-size: 18px; cursor: pointer; transition: all 0.3s ease; width: 100%;">
                                Submit Order Request
                            </button>
                            <button type="button" onclick="window.location.href='{{ route('cart.index') }}'" 
                                    style="background: none; border: 2px solid #517a5b; color: #517a5b; padding: 15px; border-radius: 8px; font-size: 18px; cursor: pointer; transition: all 0.3s ease; width: 100%;">
                                Back to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Order Confirmation Modal -->
    <div id="orderModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background-color: white; padding: 30px; border-radius: 10px; max-width: 500px; text-align: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
            <div style="color: #517a5b; font-size: 60px; margin-bottom: 20px;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h3 style="font-size: 24px; margin-bottom: 15px; color: #333;">Order Request Submitted!</h3>
            <p style="font-size: 16px; margin-bottom: 20px; color: #666;">Your order request has been submitted for approval. You will be notified when it is approved by the admin.</p>
            <button onclick="closeModal()" style="background: #517a5b; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-size: 16px; cursor: pointer; transition: all 0.3s ease; display: block; margin: 0 auto;">
                Continue Shopping
            </button>
        </div>
    </div>
</div>

<script>
    // Delivery method switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const pickupRadio = document.getElementById('pickup');
        const deliveryRadio = document.getElementById('delivery');
        const pickupSection = document.getElementById('pickupInfoSection');
        const deliverySection = document.getElementById('deliveryInfoSection');
        
        // Handle delivery method change
        function handleDeliveryMethodChange() {
            if (pickupRadio.checked) {
                pickupSection.style.display = 'block';
                deliverySection.style.display = 'none';
                
                // Update delivery option styling
                document.querySelector('label[for="pickup"]').style.borderColor = '#517a5b';
                document.querySelector('label[for="pickup"]').style.backgroundColor = '#f8f9fa';
                document.querySelector('label[for="delivery"]').style.borderColor = '#e0e0e0';
                document.querySelector('label[for="delivery"]').style.backgroundColor = 'white';
            } else if (deliveryRadio.checked) {
                pickupSection.style.display = 'none';
                deliverySection.style.display = 'block';
                
                // Update delivery option styling
                document.querySelector('label[for="delivery"]').style.borderColor = '#517a5b';
                document.querySelector('label[for="delivery"]').style.backgroundColor = '#f8f9fa';
                document.querySelector('label[for="pickup"]').style.borderColor = '#e0e0e0';
                document.querySelector('label[for="pickup"]').style.backgroundColor = 'white';
            }
        }
        
        // Handle delivery speed option styling
        function handleDeliverySpeedChange() {
            document.querySelectorAll('.delivery-speed-option').forEach(option => {
                const radio = option.querySelector('input[type="radio"]');
                if (radio.checked) {
                    option.style.borderColor = '#517a5b';
                    option.style.backgroundColor = '#f8f9fa';
                } else {
                    option.style.borderColor = '#e0e0e0';
                    option.style.backgroundColor = 'white';
                }
            });
        }
        
        // Add event listeners
        pickupRadio.addEventListener('change', handleDeliveryMethodChange);
        deliveryRadio.addEventListener('change', handleDeliveryMethodChange);
        
        // Add event listeners for delivery speed options
        document.querySelectorAll('input[name="delivery_speed"]').forEach(radio => {
            radio.addEventListener('change', handleDeliverySpeedChange);
        });
        
        // Handle address option change
        const useSavedAddressRadio = document.getElementById('useSavedAddress');
        const useDifferentAddressRadio = document.getElementById('useDifferentAddress');
        const manualAddressFields = document.getElementById('manualAddressFields');
        const selectedDeliveryAddress = document.getElementById('selectedDeliveryAddress');
        
        function handleAddressOptionChange() {
            if (useSavedAddressRadio && useSavedAddressRadio.checked) {
                // Use saved address
                manualAddressFields.style.display = 'none';
                selectedDeliveryAddress.value = '{{ $userLocation ?? '' }}';
                
                // Remove required attributes from manual fields
                document.getElementById('deliveryAddress').removeAttribute('required');
                document.getElementById('deliveryCity').removeAttribute('required');
                document.getElementById('deliveryProvince').removeAttribute('required');
                
                // Clear manual fields
                document.getElementById('deliveryAddress').value = '';
                document.getElementById('deliveryCity').value = '';
                document.getElementById('deliveryProvince').value = '';
                document.getElementById('deliveryPostal').value = '';
            } else if (useDifferentAddressRadio && useDifferentAddressRadio.checked) {
                // Use different address
                manualAddressFields.style.display = 'block';
                selectedDeliveryAddress.value = '';
                
                // Add required attributes to manual fields
                document.getElementById('deliveryAddress').setAttribute('required', 'required');
                document.getElementById('deliveryCity').setAttribute('required', 'required');
                document.getElementById('deliveryProvince').setAttribute('required', 'required');
            }
        }
        
        // Add event listeners for address options
        if (useSavedAddressRadio) {
            useSavedAddressRadio.addEventListener('change', handleAddressOptionChange);
        }
        if (useDifferentAddressRadio) {
            useDifferentAddressRadio.addEventListener('change', handleAddressOptionChange);
        }
        
        // Initialize the view
        handleDeliveryMethodChange();
        handleDeliverySpeedChange();
    });

    // Image preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const receiptInput = document.getElementById('receiptImage');
        const imagePreview = document.getElementById('imagePreview');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const removeButton = document.getElementById('removeImage');
        const errorDisplay = document.getElementById('uploadError');
        
        receiptInput.addEventListener('change', function() {
            errorDisplay.style.display = 'none';
            
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                // Check file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    errorDisplay.textContent = 'File is too large. Maximum size is 5MB.';
                    errorDisplay.style.display = 'block';
                    this.value = '';
                    return;
                }
                
                // Check file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    errorDisplay.textContent = 'Invalid file type. Only JPG, JPEG, and PNG are allowed.';
                    errorDisplay.style.display = 'block';
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    uploadPlaceholder.style.display = 'none';
                    previewContainer.style.display = 'block';
                }
                
                reader.readAsDataURL(file);
            }
        });
        
        removeButton.addEventListener('click', function() {
            receiptInput.value = '';
            previewContainer.style.display = 'none';
            uploadPlaceholder.style.display = 'block';
        });
    });

    function placeOrder() {
        // Show loading state on button
        const submitButton = document.querySelector('button[onclick="placeOrder()"]');
        const originalText = submitButton.innerText;
        submitButton.innerText = 'Processing...';
        submitButton.disabled = true;
        
        const errorDisplay = document.getElementById('uploadError');
        const receiptInput = document.getElementById('receiptImage');
        
        // Check if receipt image is uploaded
        if (!receiptInput.files || !receiptInput.files[0]) {
            errorDisplay.textContent = 'Please upload a payment receipt screenshot.';
            errorDisplay.style.display = 'block';
            submitButton.innerText = originalText;
            submitButton.disabled = false;
            return;
        }
        
        // Get delivery method
        const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked').value;
        
        // Validate delivery address if delivery is selected
        if (deliveryMethod === 'delivery') {
            const useSavedAddress = document.getElementById('useSavedAddress');
            const useDifferentAddress = document.getElementById('useDifferentAddress');
            
            // Check basic required fields
            const basicRequiredFields = ['deliveryName', 'deliveryPhone'];
            let missingFields = [];
            
            basicRequiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    missingFields.push(field.previousElementSibling.textContent.replace(' *', ''));
                }
            });
            
            // Check address fields based on selection
            if (useDifferentAddress && useDifferentAddress.checked) {
                // Validate manual address fields
                const addressFields = ['deliveryAddress', 'deliveryCity', 'deliveryProvince'];
                addressFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (!field.value.trim()) {
                        missingFields.push(field.previousElementSibling.textContent.replace(' *', ''));
                    }
                });
            } else if (useSavedAddress && useSavedAddress.checked) {
                // Check if saved address exists
                const selectedAddress = document.getElementById('selectedDeliveryAddress');
                if (!selectedAddress.value.trim()) {
                    missingFields.push('Saved Address');
                }
            } else {
                // No saved address option available, validate manual fields
                const addressFields = ['deliveryAddress', 'deliveryCity', 'deliveryProvince'];
                addressFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (!field.value.trim()) {
                        missingFields.push(field.previousElementSibling.textContent.replace(' *', ''));
                    }
                });
            }
            
            if (missingFields.length > 0) {
                errorDisplay.textContent = 'Please fill in all required delivery fields: ' + missingFields.join(', ');
                errorDisplay.style.display = 'block';
                submitButton.innerText = originalText;
                submitButton.disabled = false;
                return;
            }
        }
        
        // Create FormData to handle file upload
        const formData = new FormData();
        formData.append('receipt_image', receiptInput.files[0]);
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('delivery_method', deliveryMethod);
        
        // Add pickup information if pickup is selected
        if (deliveryMethod === 'pickup') {
            const pickupDate = document.getElementById('pickupDate');
            const pickupTime = document.getElementById('pickupTime');
            const pickupNotes = document.getElementById('pickupNotes');
            
            if (pickupDate && pickupDate.value) {
                formData.append('pickup_date', pickupDate.value);
            }
            if (pickupTime && pickupTime.value) {
                formData.append('pickup_time', pickupTime.value);
            }
            if (pickupNotes && pickupNotes.value) {
                formData.append('pickup_notes', pickupNotes.value);
            }
        }
        
        // Add delivery information if delivery is selected
        if (deliveryMethod === 'delivery') {
            formData.append('delivery_name', document.getElementById('deliveryName').value);
            formData.append('delivery_phone', document.getElementById('deliveryPhone').value);
            
            // Handle address based on selection
            const useSavedAddress = document.getElementById('useSavedAddress');
            const useDifferentAddress = document.getElementById('useDifferentAddress');
            
            if (useSavedAddress && useSavedAddress.checked) {
                // Use saved address
                formData.append('delivery_address', document.getElementById('selectedDeliveryAddress').value);
                formData.append('use_saved_address', 'true');
            } else {
                // Use manually entered address
                formData.append('delivery_address', document.getElementById('deliveryAddress').value);
                formData.append('delivery_city', document.getElementById('deliveryCity').value);
                formData.append('delivery_province', document.getElementById('deliveryProvince').value);
                formData.append('delivery_postal', document.getElementById('deliveryPostal').value);
                formData.append('use_saved_address', 'false');
            }
            
            formData.append('delivery_instructions', document.getElementById('deliveryInstructions').value);
            formData.append('delivery_speed', document.querySelector('input[name="delivery_speed"]:checked').value);
        }
        
        // Add direct checkout data if this is a direct checkout
        @if(isset($directCheckout) && $directCheckout)
        formData.append('direct_checkout', 'true');
        formData.append('post_id', '{{ $post->id }}');
        formData.append('quantity', '{{ $quantity }}');
        @endif
        
        // Use fetch with FormData to send the file
        fetch("{{ route('orders.store') }}", {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Network response was not ok');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show the confirmation modal instead of immediate redirect
                document.getElementById("orderModal").style.display = "flex";
            } else {
                alert("Failed to place order: " + (data.message || "Unknown error"));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error submitting order request: " + error.message);
        })
        .finally(() => {
            // Restore button state
            submitButton.innerText = originalText;
            submitButton.disabled = false;
        });
    }

    function closeModal() {
        document.getElementById("orderModal").style.display = "none";
        window.location.href = "{{ route('orders.index') }}";
    }
</script>
@endsection