<!DOCTYPE html>
<html lang="en">

<head>
  @include('header')
  <title>@yield('title', '')</title>
  @yield('styles')
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="/template/assets/css/search.css">
  <style>
    /* New color scheme */
    :root {
      --primary-color: #4CAF50; /* Green */
      --secondary-color: #333;  /* Dark gray */
      --accent-color: #F5A623;  /* Yellow */
      --background-color: #F4F7FC; /* Light blue */
      --text-color: #333;
      --hover-color: rgba(0, 0, 0, 0.1);
    }

    /* General Styles */
    body {
      background-color: var(--background-color);
      font-family: Arial, sans-serif;
      color: var(--text-color);
    }

    header {
      background-color: var(--primary-color);
      color: white;
    }

    .header .logo {
      color: white;
    }

    .header .search-form input {
      background-color: white;
      border-radius: 25px;
      padding: 10px;
      border: 1px solid #ccc;
      width: 300px;
    }

    .header .search-form button {
      background-color: var(--secondary-color);
      border-radius: 50%;
      padding: 8px;
      margin-left: -50px;
      color: white;
      border: none;
    }

    .header select {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 10px;
      border-radius: 5px;
    }

    .nav-profile img {
      border: 2px solid var(--primary-color);
    }

    /* Sidebar Styles */
    .sidebar {
      background-color: #fff;
      border-right: 1px solid #ddd;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar a {
      color: var(--secondary-color);
      padding: 15px;
      text-decoration: none;
      display: block;
      transition: background-color 0.3s ease;
    }

    .sidebar a:hover {
      background-color: var(--hover-color);
      color: var(--primary-color);
    }

    /* Footer Styles */
    footer {
      background-color: var(--secondary-color);
      color: white;
      padding: 20px;
      text-align: center;
    }

    footer a {
      color: var(--accent-color);
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

    /* Hover Effects for Buttons */
    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      color: white;
    }

    .btn-primary:hover {
      background-color: darkgreen;
      border-color: darkgreen;
    }
  </style>
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">Admin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!-- Search -->
    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="{{ route('search.find') }}">
        {{ csrf_field() }}
        <input type="text" id="search" name="search" placeholder="Tìm kiếm phòng..." title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div>
    <div id="result" class="panel panel-default" style="display:none">
      <ul class="list-group" id="roomList">
        <!-- Search results will appear here -->
      </ul>
    </div><!-- End Search Bar -->

    <!-- Language Selector -->
    <select onchange="window.location.href='/lang/' + this.value">
      <option value="vi" {{ App::getLocale() == 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
      <option value="en" {{ App::getLocale() == 'en' ? 'selected' : '' }}>English</option>
    </select>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="/template/assets/img/avatar/{{ (Auth::user() && Auth::user()->avatar ? Auth::user()->avatar : 'avatar-default.png') }}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"></span>
          </a><!-- End Profile Image Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ (Auth::user() && Auth::user()->name ? Auth::user()->name : '') }}</h6>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center" href="{{route('user.profile')}}"><i class="bi bi-person"></i><span>My Profile</span></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center" href="{{ route('formLogin') }}"><i class="bi bi-box-arrow-right"></i><span>Sign Out</span></a></li>
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @if (Auth::user()->role == 'admin')
    @include('sidebarAdmin')
  @endif
  @if (Auth::user()->role == 'normal_user')
    @include('sidebarUser')
  @endif

  <!-- ======= Main ======= -->
  <main id="main" class="main">
    @yield('main')
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="">
      Chào bạn! chúc bạn 1 ngày vui
    </div>

  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @include('footer')

  <!-- Script Search -->
  <script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('#search').keyup(function(){
            var search = $('#search').val();
            if(search == ""){
                $("#roomList").html("");
                $('#result').hide();
            } else {
                $.get("{{ URL::to('search') }}", {search:search}, function(data){
                    $('#roomList').empty().html(data);
                    $('#result').show();
                })
            }
        });
    });

    $(document).click(function (e) {
        if (!$(e.target).closest(".search").length) {
            $("#result").fadeOut();
            $("#search").val('');
        }
    });
  </script>
</body>
@yield('scripts')
</html>
