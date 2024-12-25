@extends('layout')
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <h5 class="alert alert-success">{{ session('status') }}</h5>
            @endif
            <div class="card">
            <div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Thêm Room Chat</h3>
            <a href="{{ route('admin.roomsUser.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.roomsUser.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Tên Room -->
                <div class="mb-3">
                    <label for="name" class="form-label">Tên Room <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên room" required>
                </div>

                <!-- Mô Tả -->
                <div class="mb-3">
                    <label for="description" class="form-label">Mô Tả</label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Nhập mô tả (nếu có)"></textarea>
                </div>

                <!-- Ảnh Room -->
                <div class="mb-3">
                    <label for="path_image" class="form-label">Ảnh Room</label>
                    <input type="file" name="path_image" id="path_image" class="form-control" accept="image/*">
                    <small class="form-text text-muted">Tải lên hình ảnh định dạng: jpeg, png, jpg, gif (tối đa 2MB).</small>
                </div>

                <!-- Gmail Người Tạo -->
                <div class="mb-3">
                    <label for="leader_gmail" class="form-label">Gmail Người Tạo <span class="text-danger">*</span></label>
                    <input type="email" name="leader_gmail" id="leader_gmail" class="form-control" placeholder="Nhập Gmail người tạo" required>
                    @error('leader_gmail')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Nút Submit -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle"></i> Tạo Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>
@endsection

