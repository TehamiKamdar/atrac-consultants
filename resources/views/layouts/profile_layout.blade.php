<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Azeret+Mono:ital,wght@0,100..900;1,100..900&family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="{{ asset('assets/remixicons/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/iziToast/iziToast.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('student/css/profile.css') }}" rel="stylesheet">
</head>

<body>

    @yield('content')

</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/student-form.js') }}"></script>
<script src="{{ asset('website/register_form.js') }}"></script>
<script src="{{ asset('assets/iziToast/iziToast.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@yield('scripts')
