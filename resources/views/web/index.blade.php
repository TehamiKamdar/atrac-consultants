@extends('layouts.web_layout')

@push('meta_title', 'Study Abroad Consultants in Karachi | Atrac Consultants')

@push('meta_description', 'Looking for study abroad consultants in Karachi? Atrac Consultants helps students explore international university admissions, study options, scholarships and student visa guidance.')

@push('meta_keywords', 'study abroad consultants Karachi, overseas education consultants Pakistan, study abroad Pakistan, international university admissions, student visa guidance Karachi, scholarships for Pakistani students, study in Canada from Pakistan, study in UK from Pakistan, study in Australia from Pakistan, study in Germany from Pakistan, study in Cyprus from Pakistan, Atrac Consultants')

@push('title')
    Study Abroad Consultants in Karachi | Atrac Consultants
@endpush

@section('content')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                iziToast.success({
                    title: 'Success!',
                    message: '{{ session('success') }}',
                    position: 'topRight',
                    timeout: 5000
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                iziToast.error({
                    title: 'Error!',
                    message: '{{ session('error') }}',
                    position: 'topRight',
                    timeout: 5000
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @foreach ($errors->all() as $error)
                    iziToast.error({
                        title: 'Error!',
                        message: '{{ $error }}',
                        position: 'topRight',
                        timeout: 5000
                    });
                @endforeach
            });
        </script>
    @endif



    {{-- Hero Section --}}

    <section class="hero-section" role="banner">
        <div class="container">
            <div class="hero-content">
                <h2 class="hero-subtitle" id="previewShortHeading">
                    Spring 2027 Intake Open
                </h2>
                <h1 class="hero-title text-white" id="element">Study Abroad Consultants in Karachi</h1>
                <p class="hero-description" id="previewParagraph">
                    Explore international study opportunities with expert guidance on university admissions, scholarships and student visa applications. Book your free consultation with Atrac Consultants.
                </p>
                <a href="#form" class="hero-btn" id="previewButtonText">
                    BOOK FREE CONSULTATION <i class="fas fa-arrow-right"></i>
                </a>
                <div class="country-tags">
                    @foreach ($countries as $country)
                    <a href="{{route('country-details', strtolower($country->slug))}}" style="text-decoration: none;">
                        <span class="country-tag">{{ $country->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>



    <!-- Why Atrac Section -->
    <section id="whatwedo" class="why-atrac-section" role="columnheader">
        <div class="decorative-circle circle-1"></div>
        <div class="decorative-circle circle-2"></div>

        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Study Abroad Consultants in Karachi</h2>

                <p class="section-subtitle">
                    Atrac Consultants is a trusted education consultancy in Karachi,
                    helping students pursue higher education at renowned universities
                    worldwide. We provide guidance on international university admissions,
                    student visa applications, scholarships and study opportunities in
                    popular destinations, including the UK, Canada, Australia, Germany
                    and Cyprus.
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
    <section id="country" class="countries-section" aria-labelledby="countries-heading">
        <div class="container">

            <!-- Section Header -->
            <div class="section-header row align-items-center">

                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 id="countries-heading" class="section-title display-5">
                        Explore Top Study Destinations
                    </h2>
                </div>

                <div class="col-lg-6">
                    <p class="section-description">
                        Explore popular study destinations for international education. Atrac Consultants helps students from Pakistan understand university admission requirements, study opportunities and visa guidance for countries around the world. Choose your preferred destination to learn more.
                    </p>
                </div>

            </div>

            <!-- Countries Slider -->
            <div class="country-slider">

                @foreach ($countries as $country)

                    <div class="px-2">
                        <div class="country-card">

                            <div class="img">

                                @if ($country->name == "North Cyprus")
                                    <img
                                        src="{{ asset('images/country/north_cyprus.png') }}"
                                        alt="Flag of North Cyprus"
                                        class="country-img"
                                        loading="lazy"
                                    >
                                @else
                                    <img
                                        src="https://flagcdn.com/w320/{{ strtolower($country->iso2) }}.png"
                                        alt="Flag of {{ $country->name }}"
                                        class="country-img"
                                        loading="lazy"
                                    >
                                @endif

                            </div>

                            <a
                                href="{{ route('country-details', strtolower($country->slug)) }}"
                                class="country-btn"
                            >
                                {{ $country->name }}
                            </a>

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

                <h2 class="visual-title">
                    Your Trusted Study Abroad Partner in Karachi
                </h2>

                <p class="visual-description">
                    Since 2020, Atrac Consultants has been helping students
                    explore international education opportunities. Our team
                    provides guidance throughout the university admission
                    process, helping students make informed decisions about
                    their academic future.
                </p>

            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">

            <div class="section-header">
                <span class="section-subtitle">Why Choose Us</span>

                <h2 class="section-title">
                    Why Students Trust Atrac Consultants
                </h2>
            </div>

            <div class="features-list">

                <!-- Feature 1 -->
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa-solid fa-handshake"></i>
                    </div>

                    <div class="feature-content">
                        <h3>International University Partnerships</h3>

                        <p>
                            Explore study opportunities at universities and
                            educational institutions across destinations such
                            as the UK, Canada, USA, Australia, Cyprus and Europe.
                            We guide students through admission requirements
                            and available study options.
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>

                    <div class="feature-content">
                        <h3>Experienced Education Consultants</h3>

                        <p>
                            Our team has been supporting students since 2020
                            with university selection, application preparation
                            and admission guidance, helping them navigate
                            different stages of their international education journey.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ri-lightbulb-fill"></i>
                    </div>

                    <div class="feature-content">
                        <h3>Free Study Abroad Counselling</h3>

                        <p>
                            Get free initial counselling to explore suitable
                            universities, study destinations, admission
                            requirements and scholarship opportunities.
                            Our team helps you understand your options
                            before taking the next step.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <!-- Options Section -->
    <section class="options-section d-flex align-items-center" aria-labelledby="options-title">

        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-8 options-content">

                    <h2 class="options-headline">
                        Explore a Wide Range of Study Opportunities
                    </h2>

                    <h3 class="options-title" id="options-title">
                        Find Your Ideal Study Program with
                        <span class="text-primary">Atrac Consultants</span>
                    </h3>

                    <a href="#form" class="options-btn">
                        Book Your Free Consultation
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

    <section id="stats-section" class="stats-section" role="complementary">
        <div class="container">
            <h2 class="section-title">Our Success Metrics</h2>

            <div class="row g-4">
                <!-- Visa Approval Ratio (flies from left) -->
                <div class="col-4 col-md-6 col-lg-4 stat-item">
                    <div class="stat-icon">
                        <i class="ri-pass-valid-line"></i>
                    </div>
                    <div class="stat-value" data-target="98" data-type="percentage">0%</div>
                    <h3 class="stat-label">Visa Approval Ratio</h3>
                </div>

                <!-- Student Visa Ratio (flies from top) -->
                <div class="col-4 col-md-6 col-lg-4 stat-item">
                    <div class="stat-icon">
                        <i class="ri-graduation-cap-line"></i>
                    </div>
                    <div class="stat-value" data-target="99.5"  data-type="percentage">0%</div>
                    <h3 class="stat-label">Admission Successful Ratio</h3>
                </div>

                <!-- Success Cases (flies from bottom) -->
                <!--<div class="col-md-6 col-lg-3 stat-item">-->
                <!--    <div class="stat-icon">-->
                <!--        <i class="ri-checkbox-circle-line"></i>-->
                <!--    </div>-->
                <!--    <div class="stat-value" data-target="1200">0</div>-->
                <!--    <h3 class="stat-label">Success Cases</h3>-->
                <!--</div>-->

                <!-- Client Satisfaction (flies from right) -->
                <div class="col-4 col-md-6 col-lg-4 stat-item">
                    <div class="stat-icon">
                        <i class="ri-emotion-happy-line"></i>
                    </div>
                    <div class="stat-value" data-target="100" data-type="percentage">0%</div>
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


    <div class="consultation-section pb-5 mt-5" id="form" role="form">
        <div class="container">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <span class="badge bg-primary-subtle text-primary fs-6 mb-3"
                    style="background-color: rgba(43, 182, 115, 0.1)!important; color: #2BB673!important;">
                    <i class="ri-mail-line me-2"></i> Contact Form
                </span>
                <h2 class="display-5 fw-bold mb-4">Request Your <span class="text-primary"
                        style="color: #2BB673!important;">Free</span> Appointment</h2>
                <p class="lead text-muted mx-auto" style="max-width: 720px;">
                    Complete this form and our education experts will contact you within 24 hours
                </p>
            </div>



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
                                    <span>5+ years of experience</span>
                                </li>
                                <li class="mb-3 d-flex">
                                    <i class="ri-checkbox-circle-fill me-2 mt-1"></i>
                                    <span>200+ successful students</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Form Column -->
                    <div class="col-md-8">
                        <div class="p-4 p-md-5">
                            @include('include.form', ['layout' => 'wide'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="faq-section py-5 mt-5" id="faq" role="article">
        <div class="container">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <span class="badge bg-primary-subtle text-primary fs-6 mb-3"
                    style="background-color: rgba(43, 182, 115, 0.1)!important; color: #2BB673!important;">
                    <i class="ri-question-line me-2"></i> FAQs
                </span>
                <h2 class="display-5 fw-bold mb-4">Frequently <span class="text-primary" style="color: #2BB673!important;">Asked</span> Questions</h2>
                <p class="lead text-muted mx-auto" style="max-width: 720px;">
                    Find quick answers to common questions about our products and services
                </p>
            </div>
            <!-- Form Container -->
            <div class="card border-0 shadow-lg overflow-hidden mx-auto" style="max-width: 1000px;">
                <div class="card-body">

                    @forelse ($faqs as $key => $faq)
                        <div class="accordion custom-accordion" id="faqAccordion">
                            <!-- FAQ Item 1 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $key+1 }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $key+1 }}" aria-expanded="true"
                                            aria-controls="collapse{{ $key+1 }}">
                                        {{ $faq->question }}
                                        <span class="icon-container">
                                            <i class="ri-add-fill icon-plus"></i>
                                            <i class="ri-subtract-fill icon-minus"></i>
                                        </span>
                                    </button>
                                </h2>
                                <div id="collapse{{ $key+1 }}" class="accordion-collapse collapse show"
                                    aria-labelledby="heading{{ $key+1 }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>{!! $faq->answer !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingEmpty">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseEmpty" aria-expanded="true"
                                        aria-controls="collapseEmpty">
                                    No FAQs are available at this time
                                    <span class="icon-container">
                                        <i class="ri-add-fill icon-plus"></i>
                                        <i class="ri-subtract-fill icon-minus"></i>
                                    </span>
                                </button>
                            </h2>
                            <div id="collapseEmpty" class="accordion-collapse collapse show"
                                aria-labelledby="headingEmpty" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Our team is researching to provide you with the best details possible. Stay tuned.</p>
                                </div>
                            </div>
                        </div>
                    @endforelse

                    @if (count($faqs)>0)
                        <div class="mt-4 d-flex justify-content-center">
                            <a href="{{ route('faqs') }}" class="btn btn-primary"><i class="ri-restart-line me-2"></i>Load More</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('include.reviews')

@endsection

@section('scripts')

{{-- Country Slider --}}
<script src="{{ asset('website/index.js') }}"></script>
<script src="{{ asset('website/forms.js') }}"></script>

@endsection