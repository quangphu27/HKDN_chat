@extends('layout')
@section('main')
    <div class="container my-5">
        @if (session('status'))
            <div class="alert alert-danger">{{ session('status') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="m-0">Danh Sách Room Chat</h3>
                <a href="{{ route('admin.roomsUser.addRoom') }}" class="btn btn-primary btn-sm">Thêm room chat</a>
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($chatrooms as $chatroom)
                    <div class="col">
                        <div class="card shadow-sm h-100">
                            <img src="/uploads/chatrooms/{{ $chatroom->path_image }}" class="card-img-top" alt="Ảnh room" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $chatroom->name }}</h5>
                                <p class="card-text text-muted">{{ $chatroom->description }}</p>
                                <p class="card-text text-muted">ID Room: {{ $chatroom->id }}</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('admin.roomsUser.edit', ['id' => $chatroom->id]) }}" class="btn btn-outline-primary btn-sm">Sửa</a>
                                <a href="{{ route('admin.roomsUser.delete', ['id' => $chatroom->id]) }}" class="btn btn-outline-danger btn-sm">Xóa</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
