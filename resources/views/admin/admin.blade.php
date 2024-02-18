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
                <strong>Copyright &copy;<a href="#">Sushil Khatri</a></strong>
                <div class="float-right d-none d-sm-inline-block">
                    {{-- <b>Version</b> 1.0 --}}
                </div>
            </footer>

            @include('admin.include.script')

        </div>
    </body>
</html>