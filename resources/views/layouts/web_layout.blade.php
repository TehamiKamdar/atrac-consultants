<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.cdnfonts.com/css/bambino-2" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="stylesheet" href="{{asset('assets/dist/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('website/lib/remixicons-fonts/remixicon.css') }}">
    <link rel="stylesheet" crossorigin href="{{asset('website/style.css')}}">

    <title>Atrac Consultants | @stack('title')</title>
    @yield('styles')
</head>

<body>
    <nav class="atrac-navbar navbar navbar-expand-lg" style="z-index: 100">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/">
                <img src="{{asset('website/logo.png')}}" alt="Atrac Consultants"
                    class="navbar-logo">
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
                        <a class="nav-link-item {{ Route::is('user-home') ? 'active' : '' }}" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-item" href="{{ '/' . '#whychooseus' }}">Why Choose Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-item" href="{{ '/' . '#country' }}">Countries</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-item" href="{{'/' . '#blog'}}">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-item" href="{{ '/' . '#consultation' }}">Book an Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-item {{ Route::is('user-about') ? 'active' : '' }}"
                            href="{{route('user-about')}}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-item {{ Route::is('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu (will be shown when toggled) -->
    <div class="mobile-menu collapse d-lg-none" id="navbarContent">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="mobile-nav-link active" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="mobile-nav-link" href="#country">Countries</a>
            </li>
            <li class="nav-item">
                <a class="mobile-nav-link" href="#whatwedo">What We Do</a>
            </li>
            <li class="nav-item">
                <a class="mobile-nav-link" href="#whychooseus">Why Choose Us</a>
            </li>
            <li class="nav-item">
                <a class="mobile-nav-link" href="#testimonial">Testimonials</a>
            </li>
            <li class="nav-item">
                <a class="mobile-nav-link" href="#blog">Blog</a>
            </li>
            <li class="nav-item">
                <a class="mobile-nav-link" href="./contact.html">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="mobile-nav-link" href="{{route('user-about')}}">About Us</a>
            </li>
        </ul>
    </div>
    @yield('content')

    <footer class="consultancy-footer">
        <!-- Decorative elements -->
        <i class="ri-leaf-fill footer-decoration decoration-1"></i>
        <i class="ri-global-line footer-decoration decoration-2"></i>

        <div class="container">
            <div class="row g-4">
                <!-- About Column -->
                <div class="col-lg-4 col-md-6 footer-col">
                    <img src="{{ asset('website/logo.png') }}"
                        alt="Atrac Consultants Logo" class="footer-logo">
                    {{-- <div class="brand-name">Atrac Consultants</div> --}}
                    <p class="mb-4">Providing expert consultancy services with integrity and innovation to help
                        businesses thrive in competitive markets.</p>

                    <div class="contact-info">
                        <p>
                            <i class="ri-map-pin-2-fill"></i>
                            <span>Office #101, Silver Trade Center, Block 13 A<br>Gulshan-e-Iqbal, Karachi,
                                Pakistan</span>
                        </p>
                        <p>
                            <i class="ri-time-fill"></i>
                            <span>Mon-Sat | 10AM-8PM</span>
                        </p>
                        <p>
                            <i class="ri-phone-fill"></i>
                            <span>+92 300 1234567</span>
                        </p>
                        <p>
                            <i class="ri-mail-fill"></i>
                            <span>info@atracconsultants.com</span>
                        </p>
                    </div>
                </div>

                <!-- Quick Links Column -->
                <div class="col-lg-4 col-md-6 footer-col">
                    <h3 class="footer-heading">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('user-home') }}"><i class="ri-arrow-right-s-line"></i> Home</a></li>
                        <li><a href="{{ route('user-about') }}"><i class="ri-arrow-right-s-line"></i> About Us</a></li>
                        <li><a href="{{ '/' . '#country' }}"><i class="ri-arrow-right-s-line"></i> Countries We Offer</a>
                        </li>
                        <li><a href="{{ '/' . '#whychooseus' }}"><i class="ri-arrow-right-s-line"></i> Our Services</a>
                        </li>
                        <li><a href="{{ route('contact') }}"><i class="ri-arrow-right-s-line"></i> Contact</a></li>
                    </ul>
                </div>

                <!-- Social/Newsletter Column -->
                <div class="col-lg-4 col-md-6 footer-col">
                    <h3 class="footer-heading">Stay Connected</h3>
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
                    </form>

                    <h4 class="mt-4 mb-3">Follow Us</h4>
                    <div class="social-links">
                        <a href="#"><i class="ri-twitter-x-fill"></i></a>
                        <a href="#"><i class="ri-facebook-fill"></i></a>
                        <a href="#"><i class="ri-linkedin-fill"></i></a>
                        <a href="#"><i class="ri-instagram-line"></i></a>
                        <a href="#"><i class="ri-youtube-fill"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-divider"></div>

            <div class="row">
                <div class="col-12">
                    <div class="copyright">
                        &copy; {{ date('Y') }} <span class="text-primary">Atrac Consultants.</span> All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{asset('assets/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.10/typed.js"
        integrity="sha512-tQQXRDB2wEmuJGtFrmmoFYzNTq8StA1XJrfO0OQbbTxd9G0CwaTDL6/C1y805IlvBVrMwOqob1kf6r/2U5XXVg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
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
        })

    </script>
    @yield('scripts')
</body>

</html>