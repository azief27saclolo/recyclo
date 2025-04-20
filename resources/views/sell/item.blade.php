<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell an Item - Recyclo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
    <style>
        :root {
            --hoockers-green: #517A5B;
            --hoockers-green_80: #517A5Bcc;
        }
        
        body {
            font-family: 'Urbanist', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }

        .profile-container {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 40px;
        }
        
        .sell-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .page-title {
            color: var(--hoockers-green);
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
        }
        
        .form-group {
            margin-bottom: 24px;
            width: 100%;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
            font-size: 18px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 18px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: var(--hoockers-green);
            outline: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 16px;
            margin-top: 5px;
        }

        .submit-btn {
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 16px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 20px;
            width: 100%;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: var(--hoockers-green_80);
        }

        /* Loading spinner animation */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* SweetAlert2 custom styles for larger modals */
        .swal2-popup.swal2-modal.bigger-modal {
            width: 32em !important;
            max-width: 90% !important;
            font-size: 1.2rem !important;
            padding: 2em !important;
        }
        
        .swal2-popup.swal2-modal.bigger-modal .swal2-title {
            font-size: 1.8em !important;
            margin-bottom: 0.5em !important;
        }
        
        .swal2-popup.swal2-modal.bigger-modal .swal2-content,
        .swal2-popup.swal2-modal.bigger-modal .swal2-html-container {
            font-size: 1.1em !important;
            line-height: 1.5 !important;
        }
        
        .swal2-popup.swal2-modal.bigger-modal .swal2-confirm,
        .swal2-popup.swal2-modal.bigger-modal .swal2-cancel {
            font-size: 1.1em !important;
            padding: 0.6em 1.5em !important;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Use the sidebar component -->
        <x-sidebar activePage="sell-item" />

        <!-- Main Content -->
        <div class="main-content">
            <div class="sell-container">
                <h1 class="page-title">Sell an Item</h1>
                
                <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="title">Product Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter product title..." value="{{ old('title') }}" required>
                        @error('title')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category">Category</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="">--Select--</option>
                            <option value="Metal" {{ old('category') == 'Metal' ? 'selected' : '' }}>Metal</option>
                            <option value="Plastic" {{ old('category') == 'Plastic' ? 'selected' : '' }}>Plastic</option>
                            <option value="Paper" {{ old('category') == 'Paper' ? 'selected' : '' }}>Paper</option>
                            <option value="Glass" {{ old('category') == 'Glass' ? 'selected' : '' }}>Glass</option>
                            <option value="Wood" {{ old('category') == 'Wood' ? 'selected' : '' }}>Wood</option>
                            <option value="Electronics" {{ old('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="Fabric" {{ old('category') == 'Fabric' ? 'selected' : '' }}>Fabric</option>
                            <option value="Rubber" {{ old('category') == 'Rubber' ? 'selected' : '' }}>Rubber</option>
                        </select>
                        @error('category')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="location">Location</label>
                        <input type="text" name="location" id="location" class="form-control" placeholder="Enter location..." value="{{ old('location') }}" required>
                        @error('location')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="unit">Unit</label>
                        <select name="unit" id="unit" class="form-control" required>
                            <option value="">--Select--</option>
                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                            <option value="g" {{ old('unit') == 'g' ? 'selected' : '' }}>Gram (g)</option>
                            <option value="lb" {{ old('unit') == 'lb' ? 'selected' : '' }}>Pound (lb)</option>
                            <option value="L" {{ old('unit') == 'L' ? 'selected' : '' }}>Liter (L)</option>
                            <option value="m3" {{ old('unit') == 'm3' ? 'selected' : '' }}>Cubic Meter (m3)</option>
                            <option value="gal" {{ old('unit') == 'gal' ? 'selected' : '' }}>Gallon (gal)</option>
                            <option value="pc" {{ old('unit') == 'pc' ? 'selected' : '' }}>Per Piece (pc)</option>
                            <option value="dz" {{ old('unit') == 'dz' ? 'selected' : '' }}>Per Dozen (dz)</option>
                            <option value="bndl" {{ old('unit') == 'bndl' ? 'selected' : '' }}>Per Bundle (bndl)</option>
                            <option value="sack" {{ old('unit') == 'sack' ? 'selected' : '' }}>Per Sack (sack)</option>
                            <option value="bale" {{ old('unit') == 'bale' ? 'selected' : '' }}>Per Bale (bale)</option>
                            <option value="roll" {{ old('unit') == 'roll' ? 'selected' : '' }}>Per Roll (roll)</option>
                            <option value="drum" {{ old('unit') == 'drum' ? 'selected' : '' }}>Per Drum (drum)</option>
                            <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>Per Box (box)</option>
                            <option value="pallet" {{ old('unit') == 'pallet' ? 'selected' : '' }}>Per Pallet (pallet)</option>
                        </select>
                        @error('unit')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity..." value="{{ old('quantity') }}" required>
                        @error('quantity')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="price">Price per unit</label>
                        <input type="text" name="price" id="price" class="form-control" placeholder="Enter price..." value="{{ old('price') }}" required>
                        @error('price')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter description...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="image">Photo</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                        @error('image')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="submit-btn">Post Item for Sale</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check for success message in session and show popup
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#517A5B',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'bigger-modal'
                }
            });
        @endif

        // Check for error message in session and show popup
        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#517A5B',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'bigger-modal'
                }
            });
        @endif
    });
    
    function confirmLogout(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Logout Confirmation',
            text: "Do you really want to logout?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#517A5B',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, logout',
            cancelButtonText: 'No, stay',
            customClass: {
                popup: 'bigger-modal'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
    </script>
</body>
</html>
