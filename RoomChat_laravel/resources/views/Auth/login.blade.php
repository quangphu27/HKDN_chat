<!DOCTYPE html>
<html lang="en">

<head>
    @include('header')
    <title>{{$title}}</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #2e3b4e;
            color: #fff;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        .container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .section {
            background-color: #1c232d;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
            max-width: 700px;
            width: 100%;
            text-align: center;
        }

        .logo img {
            width: 80px;
            margin-bottom: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border-radius: 6px;
            border: 2px solid #3a4d6e;
            background-color: #2e3b4e;
            color: #fff;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #00d1b2;
            outline: none;
        }

        .form-control::placeholder {
            color: #b0b0b0;
        }

        .btn-primary {
            background-color: #00d1b2;
            color: #fff;
            border: none;
            padding: 12px;
            font-weight: bold;
            border-radius: 6px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #007b8a;
        }

        .btn-google {
            background-color: #db4437;
            color: #fff;
            padding: 12px;
            font-weight: bold;
            width: 100%;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }

        .btn-google:hover {
            background-color: #c1351d;
        }

        .text-center a {
            color: #00d1b2;
            text-decoration: none;
            font-weight: bold;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .small {
            font-size: 12px;
        }

        .form-check-input {
            margin-top: 3px;
        }

        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #00d1b2;
            padding: 10px;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: none;
            transition: opacity 0.3s ease;
        }

        .back-to-top:hover {
            background-color: #007b8a;
        }
    </style>
</head>

<body>
    <main>
        <div class="container">
            <section class="section register">


                <!-- Login Form -->
                <div class="card-body">
                    <h3 class="pb-3">Đăng nhập</h3>
                    <p class="small text-muted">Nhập email và mật khẩu của bạn</p>

                    <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('formLogin') }}">

                        <!-- Email Field -->
                        <div class="col-12">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="example@mail.com" required>
                            @error('email')<small style="color: red;">{{$message}}</small>@enderror
                        </div>

                        <!-- Password Field -->
                        <div class="col-12">
                            <label for="password" class="form-label">Mật khẩu:</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Mật khẩu của bạn" required>
                            @error('password')<small style="color: red;">{{$message}}</small>@enderror
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rememberMe" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Nhớ mật khẩu</label>
                            </div>
                        </div>

                        @error('error')<small style="color: red;">{{$message}}</small>@enderror

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Đăng nhập</button>
                        </div>

                        <!-- Register Link -->
                        <div class="col-12">
                            <p class="small mb-0">Bạn chưa có tài khoản? <a href="{{ route('formRegister') }}">Đăng ký tài khoản</a></p>
                        </div>

                        <!-- Forgot Password Link -->
                        <div class="col-12">
                            <p class="text-center"><a href="{{ route('forget.password.get') }}" class="link-primary text-decoration-none">{{ __('Quên mật khẩu?') }}</a></p>
                        </div>

                        <!-- Google Login -->
                        <div class="col-12">
                            <a href="{{ route('auth.google') }}" class="btn btn-google"><i class="bi bi-google"></i> Đăng nhập với Google</a>
                        </div>

                        @csrf
                    </form>
                </div>
            </section>
        </div>
    </main>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    @include('footer')

</body>

</html>
