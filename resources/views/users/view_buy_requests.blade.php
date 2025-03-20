<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Buy Requests - Recyclo</title>
    
    <!-- Required imports as specified -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/css/login.css', 'resources/js/app.js'])
    
    <!-- SweetAlert for logout confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
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

        .content-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .content-header h1 {
            margin: 0;
            color: var(--hoockers-green);
            font-size: 28px;
            margin-bottom: 20px;
        }

        .buy-requests-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .request-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }
        
        .request-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #e9ecef;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            min-height: 220px;
        }
        
        .request-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .request-card h3 {
            color: var(--hoockers-green);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .request-card p {
            margin: 8px 0;
            color: #495057;
        }
        
        .request-card .timestamp {
            font-size: 12px;
            color: #868e96;
            margin-top: 15px;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 0;
        }
        
        .empty-state h3 {
            font-size: 20px;
            color: #495057;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            color: #868e96;
            margin-bottom: 25px;
        }
        
        .create-btn {
            background: var(--hoockers-green);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .create-btn:hover {
            background: #3c5c44;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            margin: 50px auto;
            padding: 30px;
            width: 90%;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .modal-title {
            color: var(--hoockers-green);
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
            padding: 0;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            display: block;
        }

        .form-control:focus {
            border-color: var(--hoockers-green);
            outline: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .submit-btn {
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .submit-btn:hover {
            background: #3c5c44;
        }

        /* Ensure modal form controls take full width */
        #addRequestModal .form-control,
        #editRequestModal .form-control {
            width: 100%;
            max-width: none;
        }
        
        #addRequestModal form,
        #editRequestModal form {
            width: 100%;
        }
        
        #addRequestModal .form-group,
        #editRequestModal .form-group {
            padding: 0;
            margin-bottom: 20px;
        }
        
        #addRequestModal textarea.form-control,
        #editRequestModal textarea.form-control {
            min-height: 120px;
        }
        
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: auto;
            padding-top: 15px;
        }
        
        .edit-btn, .delete-btn {
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .edit-btn {
            background-color: #4dabf7;
            color: white;
        }
        
        .edit-btn:hover {
            background-color: #3793dd;
        }
        
        .delete-btn {
            background-color: #fa5252;
            color: white;
        }
        
        .delete-btn:hover {
            background-color: #e03e3e;
        }
        
        .action-buttons i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Include the sidebar component -->
        <x-sidebar :activePage="'buy-requests'" />

        <!-- Main Content -->
        <div class="main-content">
            @if (session('success'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="content-header">
                <div class="flex justify-between items-center">
                    <div>
                        <h1>My Buy Requests</h1>
                        <p>View and manage your recycling material requests</p>
                    </div>
                    <div>
                        <a href="#" class="create-btn" id="addRequestBtn">
                            <i class="bi bi-plus-circle"></i> Add Buy Request
                        </a>
                    </div>
                </div>
            </div>

            <div class="buy-requests-container">
                @if($buyRequests->count() > 0)
                    <div class="request-grid">
                        @foreach ($buyRequests as $buyRequest)
                            <div class="request-card">
                                <h3>{{ $buyRequest->category }}</h3>
                                <p><strong>Quantity:</strong> {{ $buyRequest->quantity }} {{ $buyRequest->unit }}</p>
                                <p><strong>Description:</strong> {{ $buyRequest->description }}</p>
                                <p class="timestamp">Posted: {{ $buyRequest->created_at->diffForHumans() }}</p>
                                <div class="action-buttons">
                                    <button class="edit-btn" onclick="openEditModal({{ $buyRequest->id }}, '{{ $buyRequest->category }}', {{ $buyRequest->quantity }}, '{{ $buyRequest->unit }}', '{{ addslashes($buyRequest->description) }}')">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="delete-btn" onclick="confirmDelete({{ $buyRequest->id }})">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-basket" style="font-size: 48px; color: #dee2e6; display: block; margin-bottom: 15px;"></i>
                        <h3>You haven't posted any buy requests yet</h3>
                        <p>Create a buy request to let sellers know what you're looking for</p>
                        <a href="#" class="create-btn" onclick="openAddRequestModal(event)">Create Buy Request</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Buy Request Form Modal -->
    <div id="addRequestModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Create a Buy Request</h2>
                <span class="close">&times;</span>
            </div>
            
            <form id="addRequestForm" action="{{ route('buy.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="category">Category</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">--Select--</option>
                        <option value="Metal">Metal</option>
                        <option value="Plastic">Plastic</option>
                        <option value="Paper">Paper</option>
                        <option value="Glass">Glass</option>
                        <option value="Wood">Wood</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fabric">Fabric</option>
                        <option value="Rubber">Rubber</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity..." required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="unit">Unit</label>
                    <select name="unit" id="unit" class="form-control" required>
                        <option value="">--Select--</option>
                        <option value="kg">Kilogram (kg)</option>
                        <option value="g">Gram (g)</option>
                        <option value="lb">Pound (lb)</option>
                        <option value="L">Liter (L)</option>
                        <option value="m3">Cubic Meter (m3)</option>
                        <option value="gal">Gallon (gal)</option>
                        <option value="pc">Per Piece (pc)</option>
                        <option value="dz">Per Dozen (dz)</option>
                        <option value="bndl">Per Bundle (bndl)</option>
                        <option value="sack">Per Sack (sack)</option>
                        <option value="bale">Per Bale (bale)</option>
                        <option value="roll">Per Roll (roll)</option>
                        <option value="drum">Per Drum (drum)</option>
                        <option value="box">Per Box (box)</option>
                        <option value="pallet">Per Pallet (pallet)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter description..." required></textarea>
                </div>

                <button type="submit" class="submit-btn">Post Request</button>
            </form>
        </div>
    </div>

    <!-- Edit Buy Request Modal -->
    <div id="editRequestModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Buy Request</h2>
                <span class="close">&times;</span>
            </div>
            
            <form id="editRequestForm" action="" method="post">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="edit_category">Category</label>
                    <select name="category" id="edit_category" class="form-control" required>
                        <option value="">--Select--</option>
                        <option value="Metal">Metal</option>
                        <option value="Plastic">Plastic</option>
                        <option value="Paper">Paper</option>
                        <option value="Glass">Glass</option>
                        <option value="Wood">Wood</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fabric">Fabric</option>
                        <option value="Rubber">Rubber</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_quantity">Quantity</label>
                    <input type="number" name="quantity" id="edit_quantity" class="form-control" placeholder="Enter quantity..." required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_unit">Unit</label>
                    <select name="unit" id="edit_unit" class="form-control" required>
                        <option value="">--Select--</option>
                        <option value="kg">Kilogram (kg)</option>
                        <option value="g">Gram (g)</option>
                        <option value="lb">Pound (lb)</option>
                        <option value="L">Liter (L)</option>
                        <option value="m3">Cubic Meter (m3)</option>
                        <option value="gal">Gallon (gal)</option>
                        <option value="pc">Per Piece (pc)</option>
                        <option value="dz">Per Dozen (dz)</option>
                        <option value="bndl">Per Bundle (bndl)</option>
                        <option value="sack">Per Sack (sack)</option>
                        <option value="bale">Per Bale (bale)</option>
                        <option value="roll">Per Roll (roll)</option>
                        <option value="drum">Per Drum (drum)</option>
                        <option value="box">Per Box (box)</option>
                        <option value="pallet">Per Pallet (pallet)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_description">Description</label>
                    <textarea name="description" id="edit_description" class="form-control" rows="4" placeholder="Enter description..." required></textarea>
                </div>

                <button type="submit" class="submit-btn">Update Request</button>
            </form>
        </div>
    </div>
    
    <!-- Delete Buy Request Form -->
    <form id="deleteRequestForm" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
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
            cancelButtonText: 'No, stay'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    // Buy Request Modal Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Get modal elements
        const addModal = document.getElementById('addRequestModal');
        const editModal = document.getElementById('editRequestModal');
        const addBtn = document.getElementById('addRequestBtn');
        const addCloseBtn = addModal.querySelector('.close');
        const editCloseBtn = editModal.querySelector('.close');

        // Open modal when Add Request button is clicked
        addBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openAddRequestModal(e);
        });

        // Close add modal when X is clicked
        addCloseBtn.addEventListener('click', function() {
            addModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Enable scrolling again
        });
        
        // Close edit modal when X is clicked
        editCloseBtn.addEventListener('click', function() {
            editModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Enable scrolling again
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === addModal) {
                addModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
            if (e.target === editModal) {
                editModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
        
        // Close modals with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                if (addModal.style.display === 'flex') {
                    addModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
                if (editModal.style.display === 'flex') {
                    editModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            }
        });

        // Add form submission handler
        const addRequestForm = document.getElementById('addRequestForm');
        if (addRequestForm) {
            addRequestForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close the modal
                        addModal.style.display = 'none';
                        document.body.style.overflow = 'auto';
                        
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#517A5B'
                        });
                        
                        // Reset the form
                        addRequestForm.reset();
                        
                        // Reload the buy requests section to show the new request
                        // You could implement a more elegant solution that adds the new request without a full reload
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                });
            });
        }
    });
    
    // Function to open add request modal
    function openAddRequestModal(e) {
        e.preventDefault();
        const addModal = document.getElementById('addRequestModal');
        addModal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
    }
    
    // Function to open edit modal with current data
    function openEditModal(id, category, quantity, unit, description) {
        // Set form action URL
        document.getElementById('editRequestForm').action = `/buy/${id}`;
        
        // Fill form with current values
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_quantity').value = quantity;
        document.getElementById('edit_unit').value = unit;
        document.getElementById('edit_description').value = description;
        
        // Show the modal
        document.getElementById('editRequestModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    // Function to confirm deletion
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fa5252',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteRequestForm');
                form.action = `/buy/${id}`;
                form.submit();
            }
        });
    }
    </script>
</body>
</html>
