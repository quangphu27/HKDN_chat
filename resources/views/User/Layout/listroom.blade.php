@php
$avatar= (Auth::user() && Auth::user()->avatar ? Auth::user()->avatar : 'avatar-default.png');
$name= (Auth::user() && Auth::user()->name ? Auth::user()->name : '')
@endphp
<aside id="sidebar" class="sidebar" style="height:92vh; display: flex; flex-direction: column;overflow: hidden;">
    <x-list-room />
    <div class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="bi bi-chevron-down"></i>
    </div>
    <ul class="sidebar-nav ultogle ">
        <li class="nav-heading">Chức năng</li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'user.room.join' ? 'collapsed' : '' }} " href="{{route('user.room.join')}}">
                <i class="fas fa-users"></i>
                <span>Gia nhập nhóm</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'user.room.create' ? 'collapsed' : '' }} " href="{{route('user.room.create')}}">
                <i class="fas fa-plus"></i>
                <span>Tạo nhóm</span>
            </a>
        </li>
        @auth
        @if (Auth::user()->isPremium == 0)
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() === 'user.payment' ? 'collapsed' : '' }}" href="{{ route('user.payment') }}">
                <i class="bi bi-person"></i>
                <span>Nâng cấp Premium</span>
            </a>
        </li>
        @endif
        @endauth
        <li class="nav-heading">Các trang</li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'user.profile' ? 'collapsed' : '' }} " href="{{route('user.profile')}}">
                <img src="/template/assets/img/avatar/{{$avatar}}" class="image-group" />
                <span>{{$name}}</span>
            </a>
        </li>
        <li class="nav-heading">Chức năng khác</li>
    </ul>
</aside>