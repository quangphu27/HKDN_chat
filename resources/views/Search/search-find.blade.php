@extends('layout')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            @if (session('status'))
                  <h5 class="alert alert-danger">{{session('status')}}</h5>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3>Danh Sách Room Chat <a href="{{route('user.room.create')}}" class="btn btn-primary float-end">Thêm room chat</a>
                        <a href="{{route('user.chat')}}" class="btn btn-primary float-end" style="background-color:red;">Quay lại</a></h3>
                    </div>
                </div>
                <div class="card-body">
                <div class="container my-5">
    <h5 class="text-center display-5 fw-bold py-3"></h5>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($chatrooms as $chatroom)
        <div class="col">
            <div class="card shadow-sm h-100">
                <img src="/uploads/chatrooms/{{$chatroom->path_image}}" class="card-img-top" alt="Ảnh room" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $chatroom->name }}</h5>
                    <p class="card-text text-muted">{{ $chatroom->description }}</p>
                    <p class="card-text text-muted">ID Room: {{ $chatroom->id }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
@endsection