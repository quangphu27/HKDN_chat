@extends('User.Layout.layout')
@section('main')
<div class="container my-5">
    <h1 class="mb-4 title">Tạo Nhóm Mới</h1>

    <div id="notification" class="alert d-none"></div>
    @auth
    <div class="alert alert-info info-box d-flex justify-content-between align-items-center">
        <div>
            <strong>Số nhóm bạn có thể tạo: </strong>
            @if (Auth::user()->isPremium == 0)
            {{3 - Auth::user()->chatRoomsAsLeader->count()}}
            @else
            <span class="unlimited-text">Unlimited</span>
            @endif
        </div>
        @if (Auth::user()->isPremium == 0)
        <div class="premium-info d-flex align-items-center">
            <span class="mr-3">Muốn không giới hạn?</span>
            <a href="{{route("user.payment")}}" class="btn btn-primary btn-sm upgrade-btn">Nâng cấp Premium</a>
        </div>
        @endif
    </div>
    @endauth


    <!-- Danh sách các nhóm đã tạo -->
    <h3 class="mt-4 subtitle">Các nhóm đang quản lý: {{Auth::user()->chatRoomsAsLeader->count()}}</h3>
    <div class="scrollable-list mb-4">
        <ul class="list-group">
            @foreach ($chatRooms as $chatRoom)
            <li class="list-group-item d-flex justify-content-between align-items-center group-item">
                <div class="d-flex align-items-center">
                    <img src="/uploads/chatrooms/{{$chatRoom->path_image}}" alt="Room Image" class="avatar-img" />
                    <strong class="group-name ms-2">{{$chatRoom->name}}</strong>
                </div>
                <div>
                    <button class="btn btn-warning btn-sm action-btn">Sửa</button>
                    <button class="btn btn-danger btn-sm action-btn">Giải tán nhóm</button>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Form tạo nhóm mới -->
    <h3 class="mt-4 subtitle">Tạo Nhóm Mới</h3>
    <form id="create-group-form" enctype="multipart/form-data" method="post" action="{{route("user.room.store")}}">
        @csrf
        <div class="mb-3">
            <label for="groupAvatar" class="form-label">Avatar Nhóm</label>
            <input type="file" class="form-control custom-file-input" id="path_image" name="path_image" accept="image/*">
            @error('path_image')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="groupName" class="form-label">Tên Nhóm </label>
            <input type="text" class="form-control custom-input" id="name" name="name" placeholder="Nhập tên nhóm" required>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="groupName" class="form-label">Mô tả</label>
            <input type="text" class="form-control custom-input" id="description" name="description" placeholder="Nhập mô tả nhóm" required>
            @error('description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="memberEmail" class="form-label">Mã mời vào nhóm</label>
            <div class="input-group">
                <input type="text" class="form-control custom-input" id="inviteCode" name="invitecode" readonly>
                <button class="btn btn-primary" type="button" onclick="generateInviteCode()">Random lại</button>
            </div>
        </div>
        <button id="create-group-btn" class="btn btn-primary custom-btn {{ Auth::user()->canCreateGroup() ? '' : 'disabled' }}" onclick="submitForm()">Tạo Nhóm</button>
    </form>
</div>

@endsection
@section('script')
<script>
    function generateInviteCode() {
        const timestamp = Date.now();
        const randomString = Math.random().toString(36).substr(2, 5);

        const inviteCode = timestamp.toString(36) + randomString;

        document.getElementById('inviteCode').value = inviteCode;
    }

    generateInviteCode();
</script>
@endsection
@section('styles')
<style>
    #notification {
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 1050;
        padding: 10px 20px;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-size: 16px;
    }

    .unlimited-text {
        font-size: 1rem;
        /* Tăng kích thước chữ */
        font-weight: bold;
        /* Đậm chữ */
        color: #28a745;
        /* Màu xanh lá nổi bật */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        /* Tạo hiệu ứng đổ bóng */
        font-family: 'Arial', sans-serif;
        /* Đổi font chữ nếu cần */
    }

    /* Tùy chỉnh giao diện */
    .title {
        font-family: 'Arial', sans-serif;
        font-size: 36px;
        /* Kích thước chữ lớn */
        font-weight: bold;
        /* Chữ đậm */
        color: #fff;
        /* Màu chữ trắng */
        text-align: center;
        /* Căn giữa */
        background-image: linear-gradient(to right, #4e73df, #1cc88a);
        /* Gradient màu */
        -webkit-background-clip: text;
        /* Áp dụng gradient lên chữ */
        background-clip: text;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        /* Đổ bóng chữ */
        padding-bottom: 10px;
        /* Khoảng cách dưới */
        border-bottom: 3px solid #007bff;
        /* Đường kẻ dưới */
        margin-bottom: 30px;
        /* Khoảng cách dưới tiêu đề */
    }

    .subtitle {
        font-family: 'Arial', sans-serif;
        font-size: 20px;
        color: #555;
        font-weight: bold;
    }

    .info-box {
        position: relative;
        font-size: 16px;
        padding: 10px;
        border-radius: 8px;
        background-color: #e8f7ff;
        animation: fadeIn 1s ease-out;
        /* Thêm animation cho hộp thông báo */
    }

    .premium-info {
        display: flex;
        align-items: center;
    }

    .premium-info span {
        font-weight: 600;
        margin-right: 10px;
        font-size: 14px;
        color: #333;
    }

    .upgrade-btn {
        font-size: 14px;
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 20px;
        background-color: #28a745;
        /* Màu xanh lá */
        color: #fff;
        border: none;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        animation: popIn 0.6s ease-out;
        /* Thêm animation vào nút */
    }

    .upgrade-btn:hover {
        background-color: #218838;
        transform: scale(1.1);
        /* Tạo hiệu ứng phóng to khi hover */
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        /* Thêm bóng đổ khi hover */
    }

    /* Animation cho nút */
    @keyframes popIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Animation cho hộp thông báo */
    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .info-box .btn {
        margin-left: 20px;
    }

    .scrollable-list {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #fafafa;
    }

    .group-item {
        border-radius: 8px;
        margin-bottom: 10px;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .group-item:hover {
        background-color: #f0f8ff;
        transform: scale(1.02);
    }

    .avatar-img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 10px;
    }

    .group-name {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .action-btn {
        margin-left: 5px;
        font-size: 14px;
    }

    .create-group-form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .custom-file-input {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 10px;
    }

    .custom-input {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 10px;
    }

    .custom-btn {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        padding: 10px 20px;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    .custom-btn:hover {
        background-color: #0056b3;
    }
</style>
@endsection