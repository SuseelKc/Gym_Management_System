<!DOCTYPE html>
<html lang="en">
@section('title','Dashboard')   
@include('admin.include.head')

    <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
        <div class="wrapper">
            {{-- navbar --}}
            @include('admin.include.navbar')

            <!-- Main Sidebar Container -->
            @include('admin.include.sidebar')

            <div class="content-wrapper">
                @include('sweetalert::alert')

                @yield('content')
               
            </div>

            {{-- footer --}}
            <footer class="main-footer">
               <strong> Copyright © 2024 Gym Manager X. All rights reserved.</a></strong>
                
            </footer>
            {{--  --}}

            @include('admin.include.script')

        </div>
    </body>
</html>