<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #517A5B 0%, #3a5c42 100%); color: white; border-bottom: none;">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="bi bi-person-gear me-2"></i>Edit Profile
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <!-- Profile Picture Section -->
                    <div class="text-center mb-4">
                        <div class="profile-picture-container position-relative d-inline-block">
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                 alt="Profile Picture" 
                                 class="rounded-circle profile-picture-preview"
                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #517A5B; box-shadow: 0 4px 12px rgba(81, 122, 91, 0.2);">
                            <label for="profile_picture" class="profile-picture-edit">
                                <i class="bi bi-camera-fill"></i>
                            </label>
                            <input type="file" 
                                   class="d-none" 
                                   id="profile_picture" 
                                   name="profile_picture" 
                                   accept="image/*"
                                   onchange="previewProfilePicture(this)">
                        </div>
                        <small class="text-muted d-block mt-2">Click the camera icon to change your profile picture</small>
                    </div>

                    <!-- Form Fields -->
                    <div class="row g-3">
                        <!-- Name Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', auth()->user()->name) }}" 
                                       placeholder="Your Name"
                                       required>
                                <label for="name">Full Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', auth()->user()->email) }}" 
                                       placeholder="your.email@example.com"
                                       required>
                                <label for="email">Email Address</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', auth()->user()->phone) }}" 
                                       placeholder="+63 XXX XXX XXXX">
                                <label for="phone">Phone Number</label>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Address Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" 
                                       class="form-control @error('address') is-invalid @enderror" 
                                       id="address" 
                                       name="address" 
                                       value="{{ old('address', auth()->user()->address) }}" 
                                       placeholder="Your Address">
                                <label for="address">Address</label>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Fields -->
                        <div class="col-12">
                            <div class="card bg-light border-0 p-3">
                                <h6 class="card-title mb-3">
                                    <i class="bi bi-key me-2"></i>Change Password
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" 
                                                   class="form-control @error('current_password') is-invalid @enderror" 
                                                   id="current_password" 
                                                   name="current_password" 
                                                   placeholder="Current Password">
                                            <label for="current_password">Current Password</label>
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" 
                                                   class="form-control @error('new_password') is-invalid @enderror" 
                                                   id="new_password" 
                                                   name="new_password" 
                                                   placeholder="New Password">
                                            <label for="new_password">New Password</label>
                                            @error('new_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="modal-footer border-0 pt-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #517A5B 0%, #3a5c42 100%); border: none;">
                            <i class="bi bi-check-circle me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Profile Picture Styles */
    .profile-picture-container {
        position: relative;
        transition: all 0.3s ease;
    }

    .profile-picture-preview {
        transition: all 0.3s ease;
    }

    .profile-picture-edit {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #517A5B;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(81, 122, 91, 0.3);
    }

    .profile-picture-edit:hover {
        background: #3a5c42;
        transform: scale(1.1);
    }

    /* Form Styles */
    .form-floating > .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .form-floating > .form-control:focus {
        border-color: #517A5B;
        box-shadow: 0 0 0 0.25rem rgba(81, 122, 91, 0.25);
    }

    .form-floating > label {
        color: #666;
    }

    /* Card Styles */
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .card-title {
        color: #517A5B;
        font-weight: 600;
    }

    /* Button Styles */
    .btn {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(81, 122, 91, 0.2);
    }

    .btn-light {
        background-color: #f8f9fa;
        border: 1px solid #e0e0e0;
    }

    .btn-light:hover {
        background-color: #e9ecef;
    }

    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-radius: 16px 16px 0 0;
        padding: 1.5rem;
    }

    .modal-title {
        font-weight: 600;
        font-size: 1.25rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
    }
</style>

<script>
function previewProfilePicture(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.profile-picture-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script> 