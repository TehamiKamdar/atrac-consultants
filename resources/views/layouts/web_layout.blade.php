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
    <!-- Font Awesome -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    </noscript>

    <!-- Favicon (no problem) -->
    <link rel="shortcut icon" href="{{ asset('website/favicon.svg') }}" type="image/x-icon">

    <!-- Custom Font -->
    <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/bambino-2">

    <!-- Remix Icons -->
    <link rel="stylesheet" href="{{ asset('website/lib/remixicons-fonts/remixicon.css') }}">

    <!-- iziToast CSS -->
    <link rel="stylesheet" href="{{ asset('website/lib/iziToast/iziToast.min.css') }}">

    <!-- Your Main CSS -->
    <link rel="stylesheet" href="{{ asset('website/style.css') }}">

    <!-- jQuery (must be first) -->
    <script src="{{ asset('website/lib/js/jquery.min.js') }}"></script>

    <!-- Bootstrap Bundle -->
    <script src="{{ asset('website/lib/bootstrap/bootstrap.bundle.min.js') }}" defer></script>

    <!-- Slick Carousel -->
    <script src="{{ asset('website/lib/js/slick.min.js') }}" defer></script>

    <!-- Typed.js -->
    <script src="{{ asset('website/lib/js/typed.js') }}" defer></script>

    <!-- Owl Carousel -->
    <script src="{{ asset('website/lib/js/owl.carousel.min.js') }}" defer></script>

    {{-- Swiper --}}
    <script src="{{ asset('website/lib/js/swiper-bundle.min.js') }}" defer></script>

    <!-- iziToast JS -->
    <script src="{{ asset('website/lib/iziToast/iziToast.min.js') }}" defer></script>

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
    <div class="marquee-container" role="contentinfo">
        <div class="marquee">
            🎉 Exciting News! We're now in Lahore! Explore amazing opportunities waiting for you. Stay tuned! 🎉
        </div>
    </div>
    <nav class="atrac-navbar navbar navbar-expand-lg" style="z-index: 100" role="menuitem">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/">
                <img src="{{asset('website/logo.png')}}" alt="Atrac Consultants" class="navbar-logo">
            </a>

            <!-- Mobile Toggle Button -->
            <button class="mobile-menu-btn d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Desktop Menu -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link-item {{ Route::is('home') ? 'active' : '' }}" href="/">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link-item {{ Route::is('about') ? 'active' : '' }}"
                            href="{{route('about')}}">About Us</a>
                    </li>

                    <!-- Countries Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link-item" href="#" id="countriesDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Countries
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="countriesDropdown"
                            style="background-color: #f8f8f8; width: 400px;">
                            @foreach ($countries as $country)
                                <li>
                                    <a class="dropdown-item dropdown-toggle"
                                        href="{{route('country-details', strtolower($country->slug))}}"
                                        style="color: #333; padding: 8px 16px;">{{ $country->name }}</a>

                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link-item" href="{{ '/' . '#form' }}">Book an Appointment</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link-item {{ Route::is('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">Contact Us</a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link-item bg-primary px-4 py-2 md-py-0 rounded text-white text-xl" style="font-size: 1.1rem; text-shadow: 1px 1px black;"
                            href="{{ route('register') }}">Register Here</a>
                    </li> --}}
                </ul>

            </div>
        </div>
    </nav>

    <!-- Mobile Menu (will be shown when toggled) -->
    <div class="mobile-menu collapse d-lg-none" id="navbarContent" role="menuitem">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="mobile-nav-link active" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="mobile-nav-link" href="{{route('about')}}">About Us</a>
            </li>
            <!-- Countries Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link-item" href="#" id="countriesDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Countries
                </a>
                <ul class="dropdown-menu" aria-labelledby="countriesDropdown" style="background-color: #f8f8f8;">
                    @foreach ($countries as $country)
                        <li><a class="dropdown-item" href="{{route('country-details', strtolower($country->name))}}"
                                style="color: #333; padding: 8px 16px;">{{ $country->name }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link-item" href="{{ '/' . '#form' }}">Book an Appointment</a>
            </li>
            <li class="nav-item">
                <a class="nav-link-item {{ Route::is('contact') ? 'active' : '' }}"
                    href="{{ route('contact') }}">Contact Us</a>
            </li>

            <li class="nav-item mt-3">
                <a class="nav-link-item bg-primary px-4 rounded text-white"
                    href="{{ route('contact') }}">Register Here</a>
            </li>
        </ul>
    </div>
    @yield('content')

    <footer class="consultancy-footer" role="footer">
        <!-- Decorative elements -->
        <i class="ri-leaf-fill footer-decoration decoration-1"></i>
        <i class="ri-global-line footer-decoration decoration-2"></i>

        <div class="container">
            <div class="row g-4">
                <!-- About Column -->
                <div class="col-lg-4 col-md-6 footer-col">
                    <img src="{{ asset('website/logo.png') }}" alt="Atrac Consultants Logo" class="footer-logo">
                    {{-- <div class="brand-name">Atrac Consultants</div> --}}
                    <p class="mb-4">Providing expert consultancy services with integrity and innovation to help
                        businesses thrive in competitive markets.</p>
                </div>

                <!-- Quick Links Column -->
                <div class="col-lg-4 col-md-6 footer-col">
                    <h3 class="footer-heading">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="ri-arrow-right-s-line"></i> Home</a></li>
                        <li><a href="{{ route('about') }}"><i class="ri-arrow-right-s-line"></i> About Us</a></li>
                        <li><a href="{{ '/' . '#country' }}"><i class="ri-arrow-right-s-line"></i> Countries We
                                Offer</a>
                        </li>
                        <li><a href="{{ route('contact') }}"><i class="ri-arrow-right-s-line"></i> Our Locations</a>
                        </li>
                        <li><a href="{{ route('contact') }}"><i class="ri-arrow-right-s-line"></i> Contact</a></li>
                    </ul>
                </div>

                <!-- Social/Newsletter Column -->
                <div class="col-lg-4 col-md-6 footer-col">
                    {{-- <h3 class="footer-heading">Stay Connected</h3>
                    <p>Subscribe to our newsletter for industry insights and company updates.</p>

                    <form class="mb-4">
                        <div class="input-group">
                            <input type="email" class="form-control bg-dark border-dark text-white"
                                placeholder="Your Email">
                            <button class="btn btn-primary" type="submit"
                                style="background-color: var(--primary-green); border-color: var(--primary-green);">
                                <i class="ri-send-plane-fill"></i>
                            </button>
                        </div>
                    </form> --}}

                    <h3 class="footer-heading">Follow Us</h3>
                    <div class="social-links">
                        <a href="https://www.facebook.com/atracconsultants"><i class="ri-facebook-fill"></i></a>
                        <a href="https://www.instagram.com/atracconsultants"><i class="ri-instagram-line"></i></a>
                        <a href="https://www.youtube.com/@AtracConsultants"><i class="ri-youtube-fill"></i></a>
                        <a href="https://www.linkedin.com/in/atrac-consultants-54158a316/"><i
                                class="ri-linkedin-fill"></i></a>
                        <a href="https://www.tiktok.com/@atracconsultants"><i class="ri-tiktok-fill"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-divider"></div>

            <div class="row">
                <div class="col-12">
                    <div class="copyright" style="letter-spacing: 0.5;">
                        &copy; 2020 - {{ date('Y') }} <span class="text-primary"
                            style="font-family: 'Bambino-Bold'">Atrac Consultants.</span> All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>
    {{-- <script>
        // Disable right-click
        document.addEventListener('contextmenu', event => event.preventDefault());

        // Disable keyboard shortcuts (Ctrl+U, Ctrl+C, Ctrl+S, F12)
        document.addEventListener('keydown', function (e) {
            if (
                (e.ctrlKey && (e.key === 'u' || e.key === 's' || e.key === 'c')) ||
                e.key === 'F12'
            ) {
                e.preventDefault();
            }
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof $ !== 'undefined' && typeof $.fn.owlCarousel !== 'undefined') {
                $('.owl-carousel').owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 3
                        },
                        1000: {
                            items: 5
                        }
                    }
                });
            } else {
                console.warn('Owl Carousel not loaded properly.');
            }
        });
    </script>

    @yield('scripts')
</body>

</html>