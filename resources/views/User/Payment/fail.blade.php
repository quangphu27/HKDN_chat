@extends('User.Layout.layout')
@section('main')
<div class="container">
    @if(session('error'))
    <div class="alert error">
        {{ session('error') }}
    </div>
    @endif

    <div class="text-center mt-5 notification_payment">
        <h1>Nâng cấp Premium không thành công!</h1>
        <a href="{{ route('user.chat') }}" class="btn btn-primary">Quay lại Trang chính</a>
    </div>
</div>
@endsection