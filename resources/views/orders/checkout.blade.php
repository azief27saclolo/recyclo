@extends('components.layout')

@section('content')
<div class="container">
    <section class="section checkout" id="checkout" aria-label="checkout">
        <div class="container">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 class="h2 section-title" style="font-size: 36px;">Checkout</h2>
                <p style="color: #666; margin-top: 5px; font-size: 18px;">Complete your purchase</p>
            </div>

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
                        <div style="display: flex; gap: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Product Image" 
                                 style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover;">
                            <div style="flex: 1;">
                                <div style="color: #517a5b; font-size: 16px; margin-bottom: 5px;">{{ $post->user->username }}'s Shop</div>
                                <h4 style="margin: 5px 0; font-size: 20px;">{{ $post->title }}</h4>
                                <div style="color: #666; font-size: 18px;">₱{{ $post->price }}.00 × {{ $quantity }}kg</div>
                            </div>
                        </div>

                        <div style="margin-top: 20px;">
                            <div style="display: flex; justify-content: space-between; padding: 10px 0; color: #666;">
                                <span style="font-size: 18px;">Subtotal</span>
                                <span style="font-size: 18px;">₱{{ $post->price * $quantity }}.00</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px 0; color: #666;">
                                <span style="font-size: 18px;">Delivery Fee</span>
                                <span style="font-size: 18px;">₱35.00</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-top: 2px solid #eee; margin-top: 10px; padding-top: 15px; font-weight: 600; color: #517a5b; font-size: 24px;">
                                <span>Total</span>
                                <span>₱{{ $totalPrice }}.00</span>
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
                                    <p style="color: #333; font-size: 22px; font-weight: 500;">{{ $post->user->username }}</p>
                                </div>
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
                        
                        <div style="margin: 25px 0; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                            <h4 style="color: #517a5b; margin-bottom: 15px; font-size: 20px;">Pickup Information</h4>
                            <p style="margin-bottom: 10px; color: #333; font-size: 18px;">{{ $post->user->username }}'s Shop<br>{{ $post->location }}</p>
                            <p style="color: #666; font-size: 16px;">Please pick up your order within 3 days after your order has been approved and payment is confirmed.</p>
                        </div>

                        <div style="display: grid; gap: 15px; margin-top: 25px;">
                            <button type="button" onclick="placeOrder()" 
                                    style="background: #517a5b; color: white; border: none; padding: 15px; border-radius: 8px; font-size: 18px; cursor: pointer; transition: all 0.3s ease; width: 100%;">
                                Submit Order Request
                            </button>
                            <button type="button" onclick="window.location.href='{{ route('posts') }}'" 
                                    style="background: none; border: 2px solid #517a5b; color: #517a5b; padding: 15px; border-radius: 8px; font-size: 18px; cursor: pointer; transition: all 0.3s ease; width: 100%;">
                                Continue Shopping
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
        
        var quantity = "{{ $quantity }}";
        var post_id = "{{ $post->id }}";
        
        // Create FormData to handle file upload
        const formData = new FormData();
        formData.append('post_id', post_id);
        formData.append('quantity', quantity);
        formData.append('receipt_image', receiptInput.files[0]);
        formData.append('_token', "{{ csrf_token() }}");
        
        // Use fetch with FormData to send the file
        fetch("{{ route('orders.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
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
                // Show the order confirmation modal
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
        window.location.href = "{{ route('posts') }}";
    }
</script>
@endsection