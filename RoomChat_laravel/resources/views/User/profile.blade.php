@extends('User.Layout.layout')
@section('title', __('messages.profile_title'))

@section('main')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if (session('error'))
<div class="alert alert-error">
    {{ session('error') }}
</div>
@endif
<div class="container">

    <div class="pagetitle">
        <h1>{{ __('messages.profile_page') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('messages.profile_page') }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img width="100" height="100" src="{{ asset('/template/assets/img/avatar/' . ($user['avatar'] ?: 'avatar-default.png')) }}" alt="Profile" class="rounded-circle">
                        <h2>{{$user['name']}}</h2>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">{{ __('messages.overview') }}</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">{{ __('messages.edit_profile') }}</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">{{ __('messages.setting') }}</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">{{ __('messages.change_password') }}</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">{{ __('messages.about') }}</h5>
                                <p class="small fst-italic">{{$user['about'] ?? 'No about information available'}}</p>

                                <h5 class="card-title">{{ __('messages.profile_details') }}</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">{{ __('messages.fullname') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user['name'] }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('messages.address') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user['address'] ?? 'No address provided' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('messages.phone') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user['phone_number'] ?? 'No phone number provided' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('messages.email') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user['email'] }}</div>
                                </div>

                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <!-- Profile Edit Form -->
                                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mb-3">

                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">{{ __('messages.profile_image') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <!-- Hiển thị ảnh avatar người dùng -->
                                            <img id="profileAvatar" width="100" height="100" src="{{ asset('/template/assets/img/avatar/' . ($user['avatar'] ?: 'avatar-default.png')) }}" alt="Profile" class="rounded-circle">
                                            <div class="pt-2">
                                                <!-- Nút chọn tệp ảnh đại diện -->
                                                <input type="file" name="avatar" id="profileImage" class="form-control d-none" onchange="updateAvatarImage()" accept="image/*">

                                                <!-- Nút upload avatar -->
                                                <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image" id="uploadButton">
                                                    <i class="bi bi-upload"></i> Upload Image
                                                </a>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-lg-3 col-form-label">{{ __('messages.fullname') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="name" type="text" class="form-control" id="fullName" value="{{ $user['name']  }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="about" class="col-md-4 col-lg-3 col-form-label">{{ __('messages.about') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <textarea name="about" class="form-control" id="about" style="height: 100px" placeholder="{{ $user['about'] ? $user['about'] : 'No about information available' }}">{{ $user['about'] }}</textarea>
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">{{ __('messages.address') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="address" type="text" class="form-control" id="Address" placeholder="{{ $user['address'] ? $user['address'] : 'No address provided' }}" value="{{ $user['address']  }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">{{ __('messages.phone') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone_number" type="text" class="form-control" id="Phone" placeholder="{{ $user['phone_number'] ? $user['phone_number'] : 'No phone provided' }}" value="{{ $user['phone_number']  }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">{{ __('messages.email') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="Email" value="{{ $user['email']}}">
                                        </div>
                                    </div>


                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('messages.savechange') }}</button>
                                    </div>
                                </form>
                                <!-- End Profile Edit Form -->

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-settings">

                                <!-- Settings Form -->
                                <form>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                                <label class="form-check-label" for="changesMade">
                                                    Changes made to your account
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                                <label class="form-check-label" for="newProducts">
                                                    Information on new products and services
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="proOffers">
                                                <label class="form-check-label" for="proOffers">
                                                    Marketing and promo offers
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                                                <label class="form-check-label" for="securityNotify">
                                                    Security alerts
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End settings Form -->

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->

                                <form action="{{ route('user.profile.updatePassword') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control" id="currentPassword">
                                            @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="newpassword" type="password" class="form-control" id="newPassword">
                                            @error('newpassword')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                                            @error('renewpassword')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection
@section('scripts')
<script>
    // Khi nhấn vào nút upload, kích hoạt input file
    document.getElementById('uploadButton').addEventListener('click', function(event) {
        event.preventDefault(); // Ngừng hành động mặc định
        document.getElementById('profileImage').click(); // Kích hoạt hộp thoại chọn tệp
    });

    // Cập nhật tên tệp khi người dùng chọn ảnh mới
    function updateAvatarImage() {
        const fileInput = document.getElementById('profileImage');
        const file = fileInput.files[0];

        if (file) {
            // Tạo URL tạm thời cho ảnh
            const reader = new FileReader();

            reader.onload = function(event) {
                // Cập nhật ảnh đại diện bằng ảnh vừa chọn
                document.getElementById('profileAvatar').src = event.target.result;
            };

            // Đọc ảnh và tạo URL tạm thời
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection