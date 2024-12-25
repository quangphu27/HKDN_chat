@extends('User.Layout.layout')
@section('main')
<div class="container">
    @if(session('success'))
    <div class="alert success">
        {{ session('success') }}
    </div>
    @endif

    <div class="text-center mt-5 notification_payment">
        <h1>Nâng cấp Premium thành công!</h1>
        <p>Cảm ơn bạn đã nâng cấp tài khoản Premium.</p>
        <a href="{{ route('user.chat') }}" class="btn btn-primary">Quay lại Trang chính</a>
    </div>
</div>
@endsection