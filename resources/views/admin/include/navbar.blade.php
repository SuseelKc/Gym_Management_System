<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="javascript:void()" class="nav-link">Welcome @if (Auth::check())
                    {{ Auth::user()->name }}
                @endif</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-sm-inline-block float-right">

            <!--Pending Leave Notification -->
            {{-- <span id="group">
                <button type="button" class="btn btn-info">
                    <i class="fas fa-bell"></i>
                </button>
                @if($PendingLeaveCount)
                <a href="{{route('leave.index')}}" class="badge badge-light" style=" color: white;background-color: #ff5722;position: absolute;right: 98px;bottom: 34px;
                " >{{$PendingLeaveCount}}</a>
            </span>
            @else
            <span style=" color: white;background-color: #ff5722;position: absolute;right: 98px;bottom: 34px;
                " class="badge badge-light">0</span>
            </span>
            @endif --}}

        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                {{-- <span class="dropdown-item dropdown-header">Settings</span> --}}
                <div class="dropdown-divider"></div>
                {{-- <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                </a> --}}
                {{-- <div class="dropdown-divider"></div> --}}
                <a href={{ route('profile.edit') }} class="dropdown-item">
                    <i class="fas fa-user-cog mr-2"></i> Settings
                </a>
                <div class="dropdown-divider"></div>

                {{-- <a href="{{ route('change.pwd') }}" class="dropdown-item">
                    <i class="fas fa-lock mr-2"></i> Change Password
                </a> --}}
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type='submit' class="dropdown-item">
                        <i class="fas fa-power-off mr-2"></i> Logout
                    </button>
                </form>

            </div>
        </li>
    </ul>
</nav>
