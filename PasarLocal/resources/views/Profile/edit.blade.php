<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - PasarLocal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
        }
        .container {
            padding: 20px;
        }
        .profile-sidebar {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        .profile-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-name {
            margin-left: 10px;
            font-weight: 500;
        }
        .nav-link {
            color: #333;
            padding: 10px 15px;
            margin: 5px 0;
        }
        .nav-link.active {
            color: #00B207;
            font-weight: 500;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
        }
        .btn-success {
            background-color: #00B207;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
        }
        .btn-cancel {
            background-color: #fff;
            border: 1px solid #ddd;
            color: #333;
            padding: 10px 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="profile-sidebar">
                    <div class="d-flex align-items-center mb-4">
                        @if(auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" class="profile-image">
                        @else
                            <div class="profile-image d-flex align-items-center justify-content-center bg-light">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        <span class="profile-name">{{ auth()->user()->name }}</span>
                    </div>

                    <nav class="nav flex-column">
                        <a class="nav-link" href="/">Home</a>
                        <a class="nav-link" href="#">My Account</a>
                        <div class="ps-3">
                            <a class="nav-link active" href="#">My Profile</a>
                            <a class="nav-link" href="#">Address Book</a>
                            <a class="nav-link" href="#">My Payment Options</a>
                        </div>
                        <a class="nav-link" href="#">My Orders</a>
                        <div class="ps-3">
                            <a class="nav-link" href="#">My Returns</a>
                            <a class="nav-link" href="#">My Cancellations</a>
                        </div>
                        <a class="nav-link" href="#">My Wishlist</a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h4 class="mb-4">Edit Your Profile</h4>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', explode(' ', auth()->user()->name)[0] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', explode(' ', auth()->user()->name)[1] ?? '') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', auth()->user()->address) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Password Changes</h5>
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-cancel" onclick="window.location='{{ route('profile.show') }}'">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
