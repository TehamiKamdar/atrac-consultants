@extends('layouts.web_layout')

@push('title')
    Home
@endpush

@section('content')

    {{-- Hero Section --}}

    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h2 class="hero-subtitle">September to February</h2>
                <h1 class="hero-title" id="element">Last Call</h1>
                <p class="hero-description">
                    Discover the realm of opportunity with free access to individual consultation
                    and learn about new scholarships in top study destinations worldwide.
                </p>
                <a href="#country" class="hero-btn">
                    View Details <i class="fas fa-arrow-right"></i>
                </a>

                <div class="country-tags">
                    @foreach ($countries as $country)
                    <a href="{{route('country-details', $country->iso2)}}" style="text-decoration: none;">
                        <span class="country-tag">{{ $country->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    <!-- Why Atrac Section -->
    <section id="whatwedo" class="why-atrac-section">
        <div class="decorative-circle circle-1"></div>
        <div class="decorative-circle circle-2"></div>

        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Why Atrac Consultants?</h2>
                <p class="section-subtitle">
                    Atrac Consultants is your trusted partner in education and career advancement.
                    Established with a commitment to excellence, we specialize in providing comprehensive
                    education consultancy services to students aspiring to study abroad in renowned
                    educational destinations worldwide.
                </p>
            </div>

            <div class="mission-statement">
                <p class="mission-text">
                    Our mission is to empower students and professionals by providing them with the knowledge,
                    resources, and support they need to succeed in an increasingly globalized world.
                    At Atrac Consultants, your dreams are our priority, and we are dedicated to helping you turn them into
                    reality.
                </p>
            </div>
        </div>
    </section>

    <!-- Countries Section -->
    <section id="country" class="countries-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="section-heading display-5">Choose from the top study destinations</h1>
                </div>
                <div class="col-lg-6">
                    <p class="section-description">
                        When it comes to studying abroad, there are several countries offering international students
                        great opportunities for higher education and becoming part of their international community.
                        See which country suits you best.
                    </p>
                </div>
            </div>

            <!-- Countries Slider -->
            <div class="country-slider">
                @foreach ($countries as $country)
                    <!-- Country 1 -->
                    <div class="px-2">
                        <div class="country-card">
                            <div class="img">
                                @if ($country->name == "North Cyprus")
                                    <img src="{{ asset('images/country/north_cyprus.png') }}"
                                    alt="{{ $country->iso2 }}" class="country-img">
                                @else
                                    <img src="https://flagcdn.com/w320/{{ strtolower($country->iso2) }}.png"
                                    alt="{{ $country->iso2 }}" class="country-img">
                                @endif
                            </div>
                            <a href="{{route('country-details', $country->iso2)}}" class="country-btn">{{ $country->name }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Why Choose Us Section -->
    <section id="whychooseus" class="why-choose-section">
        <!-- Visual Section -->
        <div class="visual-section">
            <div class="visual-content">
                <h2 class="visual-title">Your Trusted Education Partner</h2>
                <p class="visual-description">
                    With nearly five years of experience, we've helped numerous students achieve their academic dreams
                    across the globe. Our proven track record speaks for itself.
                </p>
                <button class="btn btn-outline-light btn-lg px-4 py-2">Learn More</button>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <div class="section-header">
                <span class="section-subtitle">Why choose Us</span>
                <h2 class="section-title">Reasons For Trusting Atrac Consultant</h2>
            </div>

            <div class="features-list">
                <!-- Feature 1 -->
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ri-flashlight-line"></i>
                    </div>
                    <div class="feature-content">
                        <h3>State of the Art Technologies</h3>
                        <p>
                            We represent numerous foreign institutes from Cyprus, Canada, UK, USA, and Europe,
                            providing free counselling for admissions, scholarships, and visa .
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ri-history-line"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Experienced Professionals</h3>
                        <p>
                            Working since 2020, we have vast experience helping numerous students from
                            various backgrounds gain admissions to their ideal universities with a proven success record.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ri-wallet-3-line"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Free Counselling</h3>
                        <p>
                            Get expert guidance at no cost — our professional staff is here to support you with free counselling.
                            Your well-being matters to us; let our qualified team help you through every step.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Options Section -->
    <section class="options-section d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 options-content">
                    <h2 class="options-headline">An impressive amount of options await</h2>
                    <h1 class="options-title">Search for your desired study program through <span class="text-primary">Atrac Consultants</span></h1>
                    <a href="#consultation" class="options-btn">
                        Book Free Consultation
                    </a>
                </div>
                <div class="col-lg-4 d-none d-lg-flex justify-content-center">
                    <div class="decorative-icons">
                        <i class="decorative-icon far fa-star"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile decorative icons -->
        <div class="d-lg-none">
            <div class="decorative-icons">
                <i class="decorative-icon far fa-star"></i>
            </div>
        </div>
    </section>

    <section id="stats-section" class="stats-section">
        <div class="container">
            <h2 class="section-title">Our Success Metrics</h2>

            <div class="row g-4">
                <!-- Visa Approval Ratio (flies from left) -->
                <div class="col-md-6 col-lg-3 stat-item">
                    <div class="stat-icon">
                        <i class="ri-pass-valid-line"></i>
                    </div>
                    <div class="stat-value" data-target="98">0</div>
                    <h3 class="stat-label">Visa Approval Ratio</h3>
                </div>

                <!-- Student Visa Ratio (flies from top) -->
                <div class="col-md-6 col-lg-3 stat-item">
                    <div class="stat-icon">
                        <i class="ri-graduation-cap-line"></i>
                    </div>
                    <div class="stat-value" data-target="95">0</div>
                    <h3 class="stat-label">Student Visa Ratio</h3>
                </div>

                <!-- Success Cases (flies from bottom) -->
                <div class="col-md-6 col-lg-3 stat-item">
                    <div class="stat-icon">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>
                    <div class="stat-value" data-target="1200">0</div>
                    <h3 class="stat-label">Success Cases</h3>
                </div>

                <!-- Client Satisfaction (flies from right) -->
                <div class="col-md-6 col-lg-3 stat-item">
                    <div class="stat-icon">
                        <i class="ri-emotion-happy-line"></i>
                    </div>
                    <div class="stat-value" data-target="99">0</div>
                    <h3 class="stat-label">Client Satisfaction</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    {{-- <section id="blog" class="news-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-subtitle">Latest News</h2>
                <h1 class="section-title">Insights From Our Blog</h1>
            </div>

            <div class="row">
                <!-- News Card 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <div class="news-img-container overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Canadian University" class="news-img">
                        </div>
                        <div class="news-body">
                            <p class="news-date">
                                <i class="far fa-calendar-alt"></i> 25 June, 2024
                            </p>
                            <h3 class="news-title">Is There a Right Time to Apply to a Canadian University?</h3>
                            <a href="#" class="news-btn">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- News Card 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <div class="news-img-container overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1523057530100-383d7fbc77a1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Scholarship Opportunities" class="news-img">
                        </div>
                        <div class="news-body">
                            <p class="news-date">
                                <i class="far fa-calendar-alt"></i> 18 June, 2024
                            </p>
                            <h3 class="news-title">Top Scholarship Opportunities for International Students in 2024</h3>
                            <a href="#" class="news-btn">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- News Card 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <div class="news-img-container overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Visa Process" class="news-img">
                        </div>
                        <div class="news-body">
                            <p class="news-date">
                                <i class="far fa-calendar-alt"></i> 10 June, 2024
                            </p>
                            <h3 class="news-title">Understanding the Student Visa Process for the UK</h3>
                            <a href="#" class="news-btn">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="view-all">
                <a href="#" class="view-all-btn">
                    View All Articles <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section> --}}


    <div class="consultation-section pb-5 mt-5" id="consultation">
        <div class="container">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <span class="badge bg-primary-subtle text-primary fs-6 mb-3"
                    style="background-color: rgba(43, 182, 115, 0.1)!important; color: #2BB673!important;">
                    <i class="ri-mail-line me-2"></i> Contact Form
                </span>
                <h2 class="display-5 fw-bold mb-4">Request Your <span class="text-primary"
                        style="color: #2BB673!important;">Free</span> Appointment</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">
                    Complete this form and our education experts will contact you within 24 hours
                </p>
            </div>

            @if (session('success'))
                <div id="alert" class="alert alert-primary alert-custom">
                    {{ session('success') }}
                    <button id="close-btn" class="close">&times;</button>
                </div>
            @endif

            <!-- Form Container -->
            <div class="card border-0 shadow-lg overflow-hidden mx-auto" style="max-width: 1000px;">
                <div class="row g-0">
                    <!-- Visual Column -->
                    <div class="col-md-4 d-none d-md-block position-relative" style="background-color: #2BB673;">
                        <div class="h-100 d-flex flex-column justify-content-center p-5 text-white">
                            <div class="mb-4">
                                <i class="ri-customer-service-2-line display-3"></i>
                            </div>
                            <h3 class="fw-bold mb-3">Why Consult With Us?</h3>
                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex">
                                    <i class="ri-checkbox-circle-fill me-2 mt-1"></i>
                                    <span>Free personalized guidance</span>
                                </li>
                                <li class="mb-3 d-flex">
                                    <i class="ri-checkbox-circle-fill me-2 mt-1"></i>
                                    <span>15+ years of experience</span>
                                </li>
                                <li class="mb-3 d-flex">
                                    <i class="ri-checkbox-circle-fill me-2 mt-1"></i>
                                    <span>1000+ successful students</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Form Column -->
                    <div class="col-md-8">
                        <div class="p-4 p-md-5">
                            <form action="{{route('consultation')}}" method="POST" class="needs-validation" novalidate>
                                @csrf

                                <div class="mb-4">
                                    <label for="name" class="form-label fw-semibold">Full Name <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="ri-user-line text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="John Doe"
                                            required>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">Email <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="ri-mail-line text-muted"></i>
                                            </span>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="your@email.com" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-semibold">Phone <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="ri-phone-line text-muted"></i>
                                            </span>
                                            <input type="tel" class="form-control" id="phone" name="phone"
                                                placeholder="+92 300 1234567" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="qualification" class="form-label fw-semibold">Qualification <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="qualification" name="qualification" required>
                                            <option value="" selected disabled>Select your qualification</option>
                                            <option value="Intermediate">Intermediate</option>
                                            <option value="Bachelors">Bachelors</option>
                                            <option value="Masters">Masters</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="percentage" class="form-label fw-semibold">Percentage/GPA <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="percentage" name="percentage"
                                            max="100" placeholder="e.g. 85" required>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="country" class="form-label fw-semibold">Country of Interest <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="country" name="country" required>
                                            <option value="" selected disabled>Select preferred country</option>
                                            @foreach ($countries as $c)
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="field" class="form-label fw-semibold">Field of Interest <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="field" name="field" required>
                                            <option value="" selected disabled>Select field of study</option>
                                            @foreach ($fields as $f)
                                                <option value="{{$f->field}}">{{$f->field}}</option>
                                            @endforeach
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="message" class="form-label fw-semibold">Your Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="3"
                                        placeholder="Any specific questions or requirements..."></textarea>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                        <i class="ri-calendar-check-line me-2"></i> Book Free Consultation
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('include.reviews')

@endsection

@section('scripts')

    {{-- Country Slider --}}
    <script>
        // Initialize slider
        $(document).ready(function () {
            $('.country-slider').slick({
                dots: false,
                infinite: true,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: true,
                prevArrow: '<button type="button" class="slick-prev"></button>',
                nextArrow: '<button type="button" class="slick-next"></button>',
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    </script>


    {{-- Stats Animation Counter --}}
    <script>
        function animateStats() {
            const statValues = document.querySelectorAll('.stat-value');
            const duration = 1500;

            statValues.forEach(stat => {
                const target = parseInt(stat.getAttribute('data-target'));
                const isPercentage = stat.parentElement.querySelector('.stat-label').textContent.includes('%');
                let current = 0;
                const increment = target / (duration / 16);

                const animate = () => {
                    current = Math.min(current + increment, target);

                    if (isPercentage) {
                        stat.textContent = Math.floor(current) + '%';
                    } else {
                        stat.textContent = Math.floor(current).toLocaleString();
                    }

                    if (current < target) {
                        requestAnimationFrame(animate);
                    }
                };

                animate();
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const statsSection = document.querySelector('#stats-section'); // your section wrapper
            let hasAnimated = false;

            if (!statsSection) return;

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !hasAnimated) {
                        // Step 1: Add in-view class to trigger animations
                        statsSection.querySelectorAll('.stat-item').forEach(item => {
                            item.classList.add('in-view');
                        });

                        // Step 2: Start counting
                        animateStats();

                        hasAnimated = true;
                        observer.unobserve(statsSection);
                    }
                });
            }, {
                threshold: 0.3
            });

            observer.observe(statsSection);
        });
    </script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    var typed = new Typed('#element', {
        strings: [
            "Last Call For <span>Fall Semester</span>",
            "Deadlines are <strong>Near</strong>",
            "Apply <em>Now</em> for Scholarships"
        ],
        typeSpeed: 50,
        backSpeed: 30,
        loop: true,
        smartBackspace: true,
    });
});

</script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            const closeBtn = document.getElementById('close-btn');
            const alertBox = document.getElementById('alert');

            if (closeBtn && alertBox) {
                closeBtn.addEventListener('click', function () {
                    alertBox.style.display = 'none';
                });
            }
        });
    </script>


    {{-- Form Validation --}}
    <script>
        // Enhanced form validation
        document.addEventListener('DOMContentLoaded', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation');

            // Loop over them and prevent submission
            forms.forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();

                        // Add shake animation to invalid fields
                        form.querySelectorAll(':invalid').forEach(el => {
                            el.classList.add('animate__animated', 'animate__headShake');
                            setTimeout(() => {
                                el.classList.remove('animate__animated', 'animate__headShake');
                            }, 1000);
                        });
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>
@endsection