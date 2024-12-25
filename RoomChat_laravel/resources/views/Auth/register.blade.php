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


        <!-- Register Form -->
        <div class="card-body">
          <h3 class="pb-3">Đăng ký tài khoản</h3>
          <p class="small text-muted">Nhập thông tin cá nhân của bạn</p>

          <form class="row g-3 needs-validation" method="POST" novalidate>
            <!-- Name Field -->
            <div class="col-12">
              <label for="yourName" class="form-label">Tên của bạn:</label>
              <input type="text" name="name" class="form-control" id="yourName" placeholder="Tên đầy đủ" required>
              @error('name')<small style="color: red;">{{$message}}</small>@enderror
            </div>

            <!-- Email Field -->
            <div class="col-12">
              <label for="yourUsername" class="form-label">Email:</label>
              <div class="input-group has-validation">
                <input type="email" name="email" class="form-control" id="yourUsername" placeholder="example@mail.com" required>
              </div>
              @error('email')<small style="color: red;">{{$message}}</small>@enderror
            </div>

            <!-- Password Field -->
            <div class="col-12">
              <label for="yourPassword" class="form-label">Mật khẩu:</label>
              <input type="password" name="password" class="form-control" id="yourPassword" placeholder="Mật khẩu của bạn" required>
              @error('password')<small style="color: red;">{{$message}}</small>@enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="col-12">
              <label for="yourConfirmPassword" class="form-label">Xác thực mật khẩu:</label>
              <input type="password" name="confirmPassword" class="form-control" id="yourConfirmPassword" placeholder="Xác nhận mật khẩu" required>
              @error('confirmPassword')<small style="color: red;">{{$message}}</small>@enderror
            </div>

            <!-- Register Button -->
            <div class="col-12">
              <button class="btn btn-primary w-100" type="submit">Đăng ký</button>
            </div>

            <!-- Login Link -->
            <div class="col-12 text-center">
              <p class="small mb-0">Bạn đã có tài khoản? <a href="{{route('formLogin')}}">Đăng nhập</a></p>
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
