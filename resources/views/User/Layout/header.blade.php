<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="/template/assets/css/search.css">
</head>
<body>
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
    {{-- <a href="{{route('Admin.users.home')}}" class="logo d-flex align-items-center"> --}}
    <a href="#" class="logo d-flex align-items-center">
      <span class="d-none d-lg-block">Momota</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="{{ route('search.find') }}">
      {{ csrf_field() }}
        <input type="text" id="search" name="search" placeholder="Tìm kiếm phòng..." title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div>
    <div id="result" class="panel panel-default" style="display:none">
                <ul class="list-group" id="roomList">
                 
                </ul>
    </div><!-- End Search Bar -->
  <select onchange="window.location.href='/lang/' + this.value">
    <option value="vi" {{ App::getLocale() == 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
    <option value="en" {{ App::getLocale() == 'en' ? 'selected' : '' }}>English</option>
  </select>
  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle " href="#">
          <i class="bi bi-search"></i>
        </a>
      </li><!-- End Search Icon-->



      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="/template/assets/img/avatar/{{ (Auth::user() && Auth::user()->avatar ? Auth::user()->avatar : 'avatar-default.png') }}" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2"></span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            {{-- <h6>{{$users->name}}</h6> --}}
            {{-- <h6>{{ auth()->user()->name}}</h6> --}}
            <h6>{{ (Auth::user() && Auth::user()->name ? Auth::user()->name: '') }}</h6>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{route('user.profile')}}">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
              <i class="bi bi-gear"></i>
              <span>Lịch sử thanh toán</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
              <i class="bi bi-question-circle"></i>
              <span>Need Help?</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            {{-- <a class="dropdown-item d-flex align-items-center" href="{{ route('Admin.users.logout')}}"> --}}
            <a class="dropdown-item d-flex align-items-center" href="{{ route('formLogin') }}">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header>
<script type="text/javascript">
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
    $('#search').keyup(function(){
        var search = $('#search').val();
        if(search==""){
            $("#roomList").html("");
            $('#result').hide();
        }
        else{
            $.get("{{ URL::to('search-room') }}",{search:search}, function(data){
                $('#roomList').empty().html(data);
                $('#result').show();
            })
        }
    });
});
// Ẩn dropdown khi click ngoài form
$(document).click(function (e) {
      if (!$(e.target).closest(".search").length) {
        $("#result").fadeOut();
        $("#search").val(''); // Xóa nội dung input
      }
    });
</script>
</body>
</html>