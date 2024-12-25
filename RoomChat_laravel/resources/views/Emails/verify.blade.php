<!DOCTYPE html>
<html lang="en">

<head>
    @include('header')
</head>

<body>
<?php ?>
  <main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('Một liên kết xác minh mới đã được gửi tới địa chỉ email của bạn.') }}
                            </div>
                        @endif

                        {{ __('Trước khi tiếp tục, vui lòng kiểm tra email để biết liên kết xác minh.') }}
                        {{ __('Nếu bạn không nhận được email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('nhấp vào đây để yêu cầu một cái khác') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@include('footer')

</body>

</html> 