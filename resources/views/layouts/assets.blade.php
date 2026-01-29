<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="{{ $description ?? "Atrac Consultants is your trusted partner in education and career advancement. Established with a commitment to excellence" }}">
    <meta property="og:title"
        content="{{ $meta_title ?? "Atrac Consultants. Trusted by students, recommended by success" }}">
    <meta property="og:description"
        content="{{ $meta_description ?? "Atrac Consultants is your trusted partner in education and career advancement. Established with a commitment to excellence" }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Favicon (no problem) -->
    <link rel="shortcut icon" href="{{ asset('website/favicon.svg') }}" type="image/x-icon">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <!-- Custom Font -->
    <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/bambino-2">

    <!-- jQuery (must be first) -->
    <script src="{{ asset('website/lib/js/jquery.min.js') }}"></script>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <title>Atrac Consultants | @stack('title')</title>
    <style>
        /* Disable text selection */
        body {
            -webkit-user-select: none;
            /* Safari */
            -ms-user-select: none;
            /* IE 10+ */
            user-select: none;
            /* Standard */
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
<script>
    document.addEventListener('contextmenu', event => event.preventDefault());
</script>
@yield('scripts')