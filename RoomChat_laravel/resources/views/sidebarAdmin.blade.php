<aside id="sidebarAdmin" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">
    
    <!-- Dashboard Section -->
    <li class="nav-item">
      <a class="nav-link" href="{{route('admin.user.index')}}">
        <i class="bi bi-person-circle"></i> <!-- Updated icon -->
        <span>User</span>
      </a>
    </li><!-- End User Nav -->

    <li class="nav-item">
      <a class="nav-link" href="{{route('admin.roomsUser.index')}}">
        <i class="bi bi-house-door"></i> <!-- Updated icon -->
        <span>Room</span>
      </a>
    </li><!-- End Room Nav -->

    <!-- Pages Section -->
    <li class="nav-heading">Pages</li>

    <li class="nav-item">
      <a class="nav-link" href="{{route('admin.profile')}}">
        <i class="bi bi-person"></i> <!-- Updated icon -->
        <span>Profile</span>
      </a>
    </li><!-- End Profile Page Nav -->

    <li class="nav-item">
      <a class="nav-link" href="pages-faq.html">
        <i class="bi bi-question-circle"></i>
        <span>F.A.Q</span>
      </a>
    </li><!-- End F.A.Q Page Nav -->


    <li class="nav-item">
      <a class="nav-link" href="pages-error-404.html">
        <i class="bi bi-x-circle"></i> <!-- Updated icon -->
        <span>Error 404</span>
      </a>
    </li><!-- End Error 404 Page Nav -->

  </ul>

</aside>
