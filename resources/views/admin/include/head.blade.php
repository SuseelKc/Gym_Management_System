<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gym Manager X - @yield('title')</title>
    <link rel="icon" href="{{ url('images/mylogo.png') }}" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="preload" href="https://fonts.googleapis.com">
    <link rel="preload" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet">

    <!-- sweetalert -->
    {{-- <link rel="stylesheet" href="{{ asset('vendor/sweetalert/sweetalert.css') }}"> --}}

    <!--Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- main Theme style css-->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.css') }}">
    <!-- Datatables style css -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css "> --}}
    <link rel="stylesheet" href="{{asset('admin/dist/datatables.min.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}
    <script src="{{ asset('admin/dist/jquery.js')}}"></script>

    <!-- jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <!-- Include Bootstrap JS -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>