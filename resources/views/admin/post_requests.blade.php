<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Requests - Recyclo Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: var(--hoockers-green);
            padding: 20px;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            left: 0;
            top: 0;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 290px;
            min-height: 100vh;
            width: calc(100% - 290px);
            box-sizing: border-box;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.2);
            transform: translateX(5px);
        }

        .logo-section {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .logo-section img {
            width: 45px;
            height: 45px;
            margin-right: 15px;
        }

        .logo-section h2 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 600;
        }

        .post-requests-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .post-requests-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .post-requests-heading h1 {
            color: var(--hoockers-green);
            margin: 0;
            font-size: 1.8rem;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-pending {
            background-color: #FFC107;
            color: #333;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .table th {
            background-color: #f8f9fa;
            color: var(--hoockers-green);
            font-weight: 600;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }

        .btn {
            padding: 6px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: var(--hoockers-green);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--hoockers-green_80);
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-warning {
            background-color: #ffc107;
            color: white;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 60%;
            max-width: 800px;
        }
        
        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .modal-title {
            color: var(--hoockers-green);
            font-size: 1.5rem;
            margin: 0;
        }
        
        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: #333;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .empty-state {
            text-align: center;
            padding: 50px 0;
            color: #666;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }
        
        /* Icon button styles */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            background: transparent;
            border: none;
            transition: transform 0.2s;
        }
        
        .btn-sm:hover {
            transform: scale(1.15);
            background: transparent;
        }
        
        .btn-sm:focus {
            box-shadow: none;
            background: transparent;
        }
        
        /* Actions container */
        .d-flex {
            display: flex;
        }
        
        .gap-2 {
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <?php
    // Helper function to determine text color based on background color
    function getContrastColor($hexColor) {
        // Remove # if present
        $hexColor = str_replace('#', '', $hexColor);
        
        // Default to black if invalid hex color
        if (strlen($hexColor) != 6) {
            return '#000000';
        }
        
        // Convert hex to RGB
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
        
        // Calculate luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        
        // Return black for light colors, white for dark colors
        return ($luminance > 0.5) ? '#000000' : '#ffffff';
    }
    ?>

    <div class="admin-container">
        <div class="sidebar">
            <div class="logo-section">
                <img src="{{ asset('images/mainlogo.png') }}" alt="Recyclo Logo">
                <h2>Recyclo Admin</h2>
            </div>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-link">
                    <i class="bi bi-cart"></i> Orders
                </a>
                <a href="{{ route('admin.users') }}" class="nav-link">
                    <i class="bi bi-people"></i> Users
                </a>
                <a href="{{ route('admin.post.requests') }}" class="nav-link active">
                    <i class="bi bi-file-earmark-plus"></i> Post Requests
                    @if(App\Models\Post::where('status', App\Models\Post::STATUS_PENDING)->count() > 0)
                        <span class="badge" style="background-color: #FF6B6B; color: white; margin-left: 5px; border-radius: 50%; padding: 3px 8px;">
                            {{ App\Models\Post::where('status', App\Models\Post::STATUS_PENDING)->count() }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.products') }}" class="nav-link">
                    <i class="bi bi-box-seam"></i> Products
                </a>
                <a href="{{ route('admin.shops') }}" class="nav-link">
                    <i class="bi bi-shop"></i> Shops
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-link">
                    <i class="bi bi-file-earmark-text"></i> Reports
                </a>
                <a href="javascript:void(0)" class="nav-link" onclick="confirmLogout()">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </nav>
        </div>

        <div class="main-content">
            @if (session('success') && !str_contains(session('success'), 'approved successfully'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="post-requests-card">
                <div class="post-requests-heading">
                    <h1><i class="bi bi-file-earmark-plus"></i> Post Requests</h1>
                    <span class="badge badge-pending">
                        {{ $pendingPosts->total() }} Pending Requests
                    </span>
                </div>
                
                <div class="tab-container" style="margin-bottom: 25px; border-bottom: 2px solid #eee;">
                    <div class="tab-buttons" style="display: flex; gap: 10px;">
                        <button class="tab-btn active" data-tab="all" style="padding: 10px 20px; background: none; border: none; border-bottom: 3px solid var(--hoockers-green); cursor: pointer; font-size: 16px; font-weight: 600; color: var(--hoockers-green);">All Requests</button>
                        <a href="{{ route('admin.products') }}" class="tab-btn" style="padding: 10px 20px; background: none; border: none; border-bottom: 3px solid transparent; cursor: pointer; font-size: 16px; font-weight: 600; color: #666; text-decoration: none;">Approved Products</a>
                    </div>
                </div>
                
                @if(count($pendingPosts) > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Seller</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingPosts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="product-img">
                                    @else
                                        <div style="width: 60px; height: 60px; background-color: #eee; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                                            <i class="bi bi-image" style="font-size: 24px; color: #aaa;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $post->title }}</td>
                                <td>
                                    @php
                                        // Determine if category is an object or string and set color accordingly
                                        $categoryColor = is_object($post->category) && isset($post->category->color) ? $post->category->color : '#f0f0f0';
                                        $categoryName = is_object($post->category) ? $post->category->name : $post->category;
                                    @endphp
                                    <span class="badge" style="background-color: {{ $categoryColor }}; color: {{ getContrastColor($categoryColor) }}">
                                        {{ $categoryName }}
                                    </span>
                                </td>
                                <td>₱{{ number_format($post->price, 2) }} / {{ $post->unit }}</td>
                                <td>{{ $post->quantity }} {{ $post->unit }}</td>
                                <td>
                                    @if($post->user)
                                        {{ $post->user->firstname }} {{ $post->user->lastname }}
                                    @else
                                        Unknown
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm view-product" data-id="{{ $post->id }}" title="View Details">
                                            <i class="bi bi-eye-fill" style="color: var(--hoockers-green); font-size: 1.2rem;"></i>
                                        </button>
                                        <button class="btn btn-sm approve-post" data-id="{{ $post->id }}" data-title="{{ $post->title }}" title="Approve Post">
                                            <i class="bi bi-check-circle-fill" style="color: #28a745; font-size: 1.2rem;"></i>
                                        </button>
                                        <button class="btn btn-sm reject-post" data-id="{{ $post->id }}" data-title="{{ $post->title }}" title="Reject Post">
                                            <i class="bi bi-x-circle-fill" style="color: #dc3545; font-size: 1.2rem;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination">
                    {{ $pendingPosts->links('pagination::bootstrap-4') }}
                </div>
                @else
                <div class="empty-state">
                    <i class="bi bi-check2-circle"></i>
                    <h3>No pending post requests</h3>
                    <p>All post requests have been reviewed.</p>
                </div>
                @endif
            </div>

            <!-- Post View Modal -->
            <div id="postModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Post Request Details</h2>
                        <span class="close">&times;</span>
                    </div>
                    <div class="post-details">
                        <img src="" alt="Product Image" id="modalPostImage" style="max-width: 300px; max-height: 300px; object-fit: cover; border-radius: 10px; margin-bottom: 20px;">
                        <div class="post-info" style="margin-bottom: 20px;">
                            <h3 id="modalPostTitle" style="color: var(--hoockers-green); margin-top: 0;"></h3>
                            <p><strong>Category:</strong> <span id="modalPostCategory"></span></p>
                            <p><strong>Price:</strong> <span id="modalPostPrice"></span></p>
                            <p><strong>Quantity:</strong> <span id="modalPostQuantity"></span></p>
                            <p><strong>Seller:</strong> <span id="modalPostSeller"></span></p>
                            <p><strong>Location:</strong> <span id="modalPostLocation"></span></p>
                            <p><strong>Address:</strong> <span id="modalPostAddress"></span></p>
                            <p><strong>Submitted on:</strong> <span id="modalPostDate"></span></p>
                            
                            <p><strong>Description:</strong></p>
                            <p id="modalPostDescription" style="background-color: #f8f9fa; padding: 10px; border-radius: 5px;"></p>
                        </div>
                        <div class="action-buttons" style="display: flex; gap: 10px; margin-top: 20px;">
                            <form id="approveForm" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle-fill" style="margin-right: 5px;"></i> Approve Post
                                </button>
                            </form>
                            
                            <button type="button" class="btn btn-danger" id="rejectBtn">
                                <i class="bi bi-x-circle-fill" style="margin-right: 5px;"></i> Reject Post
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Function to confirm logout with SweetAlert2
        function confirmLogout() {
            Swal.fire({
                title: 'Confirm Logout',
                text: "Are you sure you want to logout from the admin panel?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#517A5B',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.logout') }}";
                }
            });
        }

        // Function to fetch post details
        function fetchPostDetails(postId) {
            console.log('Fetching details for post ID:', postId); // Add debugging
            
            // Make sure we use the correct URL with leading slash
            fetch(`/admin/post-request/${postId}`)
                .then(response => {
                    if (!response.ok) {
                        console.error('Response not OK:', response.status);
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data); // Add debugging
                    
                    if (data.success) {
                        const post = data.product;
                        const modal = document.getElementById('postModal');
                           
                        // Update modal content
                        document.getElementById('modalPostTitle').textContent = post.title;
                        document.getElementById('modalPostCategory').textContent = post.category.name || post.category;
                        document.getElementById('modalPostPrice').textContent = `₱${parseFloat(post.price).toFixed(2)} / ${post.unit}`;
                        document.getElementById('modalPostQuantity').textContent = `${post.quantity} ${post.unit}`;
                        document.getElementById('modalPostSeller').textContent = post.user ? `${post.user.firstname} ${post.user.lastname}` : 'Unknown';
                        document.getElementById('modalPostLocation').textContent = post.location || 'Not specified';
                        document.getElementById('modalPostAddress').textContent = post.address || 'Not specified';
                        document.getElementById('modalPostDescription').textContent = post.description || 'No description provided';
                        document.getElementById('modalPostDate').textContent = new Date(post.created_at).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        
                        // Set image or placeholder
                        if (post.image) {
                            document.getElementById('modalPostImage').src = `/storage/${post.image}`;
                            document.getElementById('modalPostImage').style.display = 'block';
                        } else {
                            document.getElementById('modalPostImage').style.display = 'none';
                        }
                        
                        // Set up the forms for approval/rejection from the detail view
                        document.getElementById('approveForm').action = `{{ url('admin/post-requests') }}/${postId}/approve`;
                        document.getElementById('rejectBtn').onclick = function() {
                            modal.style.display = 'none';
                            
                            // Use SweetAlert2 for rejection
                            Swal.fire({
                                title: 'Reject Post?',
                                text: `Are you sure you want to reject this post?`,
                                input: 'text',
                                inputPlaceholder: 'Enter reason for rejection (optional)',
                                inputAttributes: {
                                    autocapitalize: 'off'
                                },
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#dc3545',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: 'Yes, reject it!',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Create and submit form for rejection
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = `{{ url('admin/post-requests') }}/${postId}/reject`;
                                    form.style.display = 'none';
                                    
                                    const csrfToken = document.createElement('input');
                                    csrfToken.type = 'hidden';
                                    csrfToken.name = '_token';
                                    csrfToken.value = '{{ csrf_token() }}';
                                    
                                    const remarks = document.createElement('input');
                                    remarks.type = 'hidden';
                                    remarks.name = 'remarks';
                                    remarks.value = result.value || 'Post rejected by admin';
                                    
                                    form.appendChild(csrfToken);
                                    form.appendChild(remarks);
                                    document.body.appendChild(form);
                                    form.submit();
                                }
                            });
                        };
                        
                        // Show modal
                        modal.style.display = 'block';
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Failed to load post details',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error details:', error); // Enhanced error logging
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while loading post details',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                });
        }

        // Initialize event listeners when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Check for success messages in the session and show as SweetAlert2
            @if(session('success') && str_contains(session('success'), 'approved successfully'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#28a745',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
               
            @if(session('success') && str_contains(session('success'), 'rejected'))
                Swal.fire({
                    title: 'Post Rejected',
                    text: "{{ session('success') }}",
                    icon: 'warning',
                    confirmButtonColor: '#dc3545',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            const modal = document.getElementById('postModal');
            const closeBtn = document.querySelector('.close');
            let currentPostId = null;

            // Get all approve buttons
            const approveButtons = document.querySelectorAll('.approve-post');
            
            // Add click event for approve buttons
            approveButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const postId = this.getAttribute('data-id');
                    const postTitle = this.getAttribute('data-title');
                      
                    // Show SweetAlert2 confirmation
                    Swal.fire({
                        title: 'Approve Post?',
                        text: `Are you sure you want to approve "${postTitle}"? This will make it visible in the marketplace.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, approve it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.fire({
                                title: 'Processing...',
                                text: 'Approving the post request',
                                icon: 'info',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            
                            // Create and submit form for approval
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `{{ url('admin/post-requests') }}/${postId}/approve`;
                            form.style.display = 'none';
                            
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            
                            form.appendChild(csrfToken);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
            
            // Similar event for reject buttons
            const rejectButtons = document.querySelectorAll('.reject-post');
            rejectButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const postId = this.getAttribute('data-id');
                    const postTitle = this.getAttribute('data-title');
                    
                    Swal.fire({
                        title: 'Reject Post?',
                        text: `Are you sure you want to reject "${postTitle}"?`,
                        input: 'text',
                        inputPlaceholder: 'Enter reason for rejection (optional)',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, reject it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create and submit form for rejection
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `{{ url('admin/post-requests') }}/${postId}/reject`;
                            form.style.display = 'none';
                            
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            
                            const remarks = document.createElement('input');
                            remarks.type = 'hidden';
                            remarks.name = 'remarks';
                            remarks.value = result.value || 'Post rejected by admin';
                            
                            form.appendChild(csrfToken);
                            form.appendChild(remarks);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // View product modal functionality
            const viewButtons = document.querySelectorAll('.view-product');
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-id');
                    currentPostId = postId;
                    fetchPostDetails(postId);
                });
            });

            // Close modal when clicking X button
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            }

            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
