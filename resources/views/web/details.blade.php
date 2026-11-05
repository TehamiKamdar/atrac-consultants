@extends('layouts.web_layout')
@push('title', $details->meta_title)
@push('meta_title', $details->meta_title)
@push('meta_description', $details->meta_description)
@push('og_title', $details->meta_title)
@push('og_description', $details->meta_description)

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        body {
            font-family: 'Bambino-Regular', Arial, Helvetica, sans-serif;
        }

        .country-hero {
            position: relative;
            min-height: 450px;
            display: flex;
            align-items: center;
            padding: 70px 8%;
            overflow: hidden;
            background-color: var(--primary-green);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .country-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                45deg,
                rgba(43, 182, 115, 0.82) 0%,
                rgba(10, 20, 25, 0.75) 25%,
                rgba(10, 20, 25, 0.5) 50%,
                rgba(10, 20, 25, 0.25) 100%
            );
        }

        .country-hero-content {
            position: relative;
            z-index: 2;
            max-width: 750px;
            color: #fff;
        }

        .country-hero-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .country-hero-breadcrumb a {
            color: #fff;
            text-decoration: none;
        }

        .country-hero-breadcrumb a:hover {
            color: rgb(43, 182, 115);
        }

        .country-hero-tag {
            display: inline-block;
            padding: 8px 16px;
            margin-bottom: 18px;
            border: 1px solid rgba(43, 182, 115, 0.6);
            border-radius: 30px;
            color: #fff;
            background: rgba(43, 182, 115, 0.15);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .country-hero h1 {
            font-size: clamp(32px, 4vw, 52px);
            line-height: 1.2;
            font-weight: 800;
            margin-bottom: 20px;
            color: #fff;
        }

        .country-hero p {
            max-width: 650px;
            font-size: 16px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.88);
            margin-bottom: 28px;
        }

        .country-hero-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .country-hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 24px;
            border-radius: 6px;
            background: #2BB673;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .country-hero-btn:hover {
            background: #21965e;
            color: #fff;
            transform: translateY(-2px);
        }

        .country-hero-link {
            color: #fff;
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 5px;
        }

        .country-hero-link:hover {
            color: #2BB673;
        }

        @media (max-width: 767px) {
            .country-hero {
                min-height: 420px;
                padding: 45px 25px;
                border-radius: 10px;
                background-position: center;
            }

            .country-hero-overlay {
                background: rgba(10, 20, 25, 0.78);
            }

            .country-hero h1 {
                font-size: 32px;
            }

            .country-hero p {
                font-size: 14px;
            }

            .country-hero-actions {
                align-items: flex-start;
                flex-direction: column;
                gap: 18px;
            }
        }

        .country-details-section {
            background-color: #f8fafc;
        }

        h2 {
            font-family: 'Bambino-Bold', sans-serif;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .content-text {
            font-size: 1.05rem;
            line-height: 1.7;
            font-family: 'Bambino-Light', sans-serif;
            color: #495057;
        }

        .list-group-item:hover {
            color: #2BB673 !important;
            background-color: rgba(43, 182, 115, 0.05);
        }

        .text-primary {
            color: #2BB673 !important;
        }

        .bg-primary {
            background-color: #2BB673 !important;
        }

        .btn-primary {
            background-color: #2BB673;
            border-color: #2BB673;
        }

        .btn-primary:hover {
            background-color: #239d60;
            border-color: #239d60;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #2BB673;
            box-shadow: 0 0 0 0.25rem rgba(43, 182, 115, 0.25);
        }

        .input-group-text {
            transition: all 0.3s ease;
        }

        .form-control:focus+.input-group-text {
            color: #2BB673 !important;
        }

        .universities-slider {
            padding: 2rem 0;
        }

        .swiper-container {
            position: relative;
            padding: 1rem;
            overflow: hidden;
        }

        .swiper-slide {
            height: auto;
        }

        .university-logo {
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-outline-primary {
            --bs-btn-color: #2BB673;
            --bs-btn-border-color: #2BB673;
            --bs-btn-hover-bg: #2BB673;
            --bs-btn-hover-border-color: #2BB673;
            --bs-btn-active-bg: #2BB673;
            --bs-btn-active-border-color: #2BB673;
            white-space: normal;
        }

        .swiper-container {}

        .swiper-button-next,
        .swiper-button-prev {
            position: absolute;
            /* This is required */
            top: 50%;
            transform: translateY(-50%);
            color: #2BB673;
            background-color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .swiper-button-prev {
            left: 10px;
        }

        .swiper-button-next {
            right: 10px;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 1.2rem;
        }

        .insights-container {
            position: relative;
            width: 100%;
            max-width: 1100px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .insights-message {
            position: relative;
            z-index: 2;
            color: var(--primary-green);
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            font-size: 1.4rem;
            font-family: 'Bambino-Bold', sans-serif;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Animated shapes */
        .shape {
            position: absolute;
            background-color: hsl(100, 98%, 65%);
            opacity: 0.3;
            border-radius: 50%;
        }

        .shape-1 {
            width: 150px;
            height: 150px;
            top: -50px;
            left: -50px;
            animation: float 15s ease-in-out infinite;
        }

        .shape-2 {
            width: 100px;
            height: 100px;
            bottom: 20px;
            right: 50px;
            animation: float 12s ease-in-out infinite reverse;
        }

        .shape-3 {
            width: 80px;
            height: 80px;
            top: 30%;
            right: -20px;
            animation: float 18s ease-in-out infinite;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        }

        .shape-4 {
            width: 120px;
            height: 120px;
            bottom: -30px;
            left: 30%;
            animation: float 14s ease-in-out infinite reverse;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            25% {
                transform: translate(20px, 20px) rotate(5deg);
            }

            50% {
                transform: translate(0, 30px) rotate(0deg);
            }

            75% {
                transform: translate(-20px, 20px) rotate(-5deg);
            }
        }

        /* Blob animation */
        .blob {
            position: absolute;
            width: 250px;
            height: 250px;
            background-color: #D0F0C0;
            opacity: 0.2;
            border-radius: 50%;
            filter: blur(30px);
            animation: blob-animate 20s linear infinite;
            z-index: 1;
        }

        .blob-1 {
            top: 20%;
            left: 10%;
        }

        .blob-2 {
            bottom: 10%;
            right: 15%;
            animation-delay: 5s;
        }

        @keyframes blob-animate {
            0% {
                transform: scale(1) translate(0, 0);
            }

            33% {
                transform: scale(1.1) translate(50px, 30px);
            }

            66% {
                transform: scale(0.9) translate(-30px, 50px);
            }

            100% {
                transform: scale(1) translate(0, 0);
            }
        }
    </style>
@endsection

@section('content')

    <section class="country-hero" style="background-image: url('{{ asset($details->image) }}')">
        <div class="country-hero-overlay"></div>

        <div class="country-hero-content">
            <div class="country-hero-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <i class="ri-arrow-right-s-line"></i>
                <span>{{ $countryName }}</span>
            </div>

            <span class="country-hero-tag">
                Explore Study Opportunities
            </span>

            <h1>
                {{ $details->hero_title ?? "Study in $countryName for International Students" }}
            </h1>

            <p>
                {{ $details->hero_description ?? "Explore universities, admission requirements, tuition fees, scholarships and student visa opportunities in $countryName. Get expert guidance from Atrac Consultants to plan your study abroad journey."}}
            </p>

            <div class="country-hero-actions">
                <a href="#university" class="country-hero-btn">
                    Explore Universities
                    <i class="ri-arrow-right-line"></i>
                </a>

                <a href="#book-a-meeting" class="country-hero-link">
                    Book Free Consultation
                </a>
            </div>
        </div>
    </section>


    <div class="country-details-section py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Left Column - Content -->
                <div class="col-lg-8">
                    <!-- Table of Contents -->
                    <div class="card border-0 shadow-sm mb-5 d-none d-lg-block">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-list-check-2 text-primary me-3" style="color: #2BB673;"></i>
                                Table of Contents
                            </h2>
                            <div class="list-group list-group-flush">
                                <a href="#desc"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    About Studying in {{$countryName}}
                                </a>
                                <a href="#cost-of-living"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Student Life, Climate and Languages in {{$countryName}}
                                </a>
                                <a href="#requirement"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Admission Requirements and English Language Tests
                                </a>
                                <a href="#cost-of-studying"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Tuition Fees and Cost of Living in {{$countryName}}
                                </a>
                                <a href="#visa-requirement"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    {{ $countryName }} Student Visa Requirements
                                </a>
                                <a href="#work-opportunity"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Part-Time Jobs and Post-Graduation Work Opportunities
                                </a>
                                <a href="#book-a-meeting"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Book a Free Study Abroad Consultation
                                </a>
                                <a href="#university"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Universities in {{ $countryName }} for International Students
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div class="card border-0 shadow-sm mb-5" id="desc">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-information-line text-primary me-3" style="color: #2BB673;"></i>
                                About Studying in {{$countryName}}
                            </h2>
                            <div class="content-text">
                                {!!$details->country_description!!}
                            </div>
                        </div>
                    </div>

                    <!-- Cost of Living -->
                    <div class="card border-0 shadow-sm mb-5" id="cost-of-living">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-money-dollar-circle-line text-primary me-3" style="color: #2BB673;"></i>
                                Cost of Living in {{ $countryName }} for International Students
                            </h2>

                            <div class="content-text">
                                {!! $details->cost_of_living !!}
                            </div>
                        </div>
                    </div>

                    <!-- Climate & Language -->
                    <div class="card border-0 shadow-sm mb-5" id="environment">
                        <div class="card-body p-4 p-md-5">

                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-globe-line text-primary me-3" style="color: #2BB673;"></i>
                                Student Life, Climate and Languages in {{ $countryName }}
                            </h2>

                            <div class="content-text">
                                {!! $details->climate !!}
                            </div>

                            <div class="content-text mt-3">
                                {!! $details->language !!}
                            </div>

                        </div>
                    </div>

                    <!-- Admission Requirements -->
                    <div class="card border-0 shadow-sm mb-5" id="requirement">
                        <div class="card-body p-4 p-md-5">

                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-file-list-3-line text-primary me-3" style="color: #2BB673;"></i>
                                Admission Requirements in {{ $countryName }}
                            </h2>

                            @if (!empty($details->admission_requirements) && count($details->admission_requirements))
                                <ul class="list-group list-group-flush">
                                    @foreach ($details->admission_requirements as $areq)
                                        <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                            <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                            <span>{{ $areq }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>
                                    Admission requirements vary depending on the university, academic program and applicant's previous qualifications. Contact Atrac Consultants for guidance about studying in {{ $countryName }}.
                                </p>
                            @endif

                        </div>
                    </div>

                    <!-- Cost of Studying -->
                    <div class="card border-0 shadow-sm mb-5" id="cost-of-studying">
                        <div class="card-body p-4 p-md-5">

                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-graduation-cap-line text-primary me-3" style="color: #2BB673;"></i>
                                Tuition Fees and Cost of Living in {{ $countryName }}
                            </h2>

                            <div class="content-text">
                                {!! $details->scholarships !!}
                            </div>

                        </div>
                    </div>

                    <!-- Visa Requirements -->
                    <div class="card border-0 shadow-sm mb-5" id="visa-requirement">
                        <div class="card-body p-4 p-md-5">

                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-passport-line text-primary me-3" style="color: #2BB673;"></i>
                                Student Visa Requirements for {{ $countryName }}
                            </h2>

                            @if (!empty($details->visa_requirements) && count($details->visa_requirements))
                                <ul class="list-group list-group-flush">
                                    @foreach ($details->visa_requirements as $vreq)
                                        <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                            <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                            <span>{{ $vreq }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>
                                    Student visa requirements vary depending on the country,
                                    applicant's nationality and chosen institution. Contact
                                    Atrac Consultants for guidance on studying in {{ $countryName }}.
                                </p>
                            @endif

                        </div>
                    </div>

                    <!-- Work Opportunities -->
                    <div class="card border-0 shadow-sm mb-5" id="work-opportunity">
                        <div class="card-body p-4 p-md-5">

                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-briefcase-4-line text-primary me-3" style="color: #2BB673;"></i>
                                Part-Time Jobs and Post-Study Work Opportunities in {{ $countryName }}
                            </h2>

                            <div class="content-text">
                                {!! $details->workOpp !!}
                            </div>

                        </div>
                    </div>

                    <!-- Book Meeting -->
                    <div class="card border-0 shadow-sm mb-5" id="book-a-meeting">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-calendar-check-line text-primary me-3" style="color: #2BB673;"></i>
                                Get Expert Study Abroad Guidance for {{ $countryName }}
                            </h2>
                            <div class="content-text">
                                <p class="mt-3">
                                    Planning to study in {{ $countryName }}? Atrac Consultants can guide you through university selection, admission applications, scholarship opportunities and student visa guidance. Get in touch with our team to discuss your study plans.
                                </p>

                                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                    data-bs-target="#applyNowModal">
                                    Book Your Free Consultation 
                                </button>
                                <div class="modal fade" id="applyNowModal" tabindex="-1"
                                    aria-labelledby="applyNowModalLabel" aria-hidden="true">
                                    <div class="modal-xl modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white" id="applyNowModalLabel">Apply Now</h5>
                                                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @include('include.form', ['layout' => 'modal'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Universities -->
                    <div class="card border-0 shadow-sm mb-5" id="university">
                        <div class="card-body p-4 p-md-5">

                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-building-2-line text-primary me-3" style="color: #2BB673;"></i>
                                Top Universities in {{ $countryName }} for International Students
                            </h2>

                            <div class="content-text">

                                <p class="mt-3">
                                    Explore universities in {{ $countryName }} offering
                                    a range of academic programs for international students.
                                    Compare institutions, explore available courses and find
                                    options that align with your academic background and career goals.
                                </p>

                                <p>
                                    Review university admission criteria, tuition fees and
                                    available scholarships before choosing your preferred institution.
                                </p>

                                <div class="d-flex gap-3 mt-4">
                                    <a href="{{ route('university.list', $details->slug) }}"
                                        class="btn btn-primary">
                                        <i class="ri-building-2-line me-2"></i>
                                        Explore Universities in {{ $countryName }}
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Form -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-lg sticky-top" style="top: 120px; z-index:50;">
                        <div class="card-header bg-primary text-white py-3">
                            <h3 class="mb-0 text-center fw-bold d-flex align-items-center justify-content-center"
                                style="font-family:'Bambino-Regular',sans-serif;">
                                <i class="ri-calendar-check-line me-2"></i>
                                Book Free Consultation
                            </h3>
                        </div>
                        <div class="card-body p-4">
                            @include('include.form', ['layout' => 'narrow'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="universities-slider mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="fw-bold mb-4">Universities in {{$countryName}}</h2>
                    @if ($universities->count() > 0)
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($universities as $uni)
                                    @php
                                    $name = strtolower($uni->country_name);
                                    @endphp
                                    <div class="swiper-slide">
                                        <div class="card shadow-sm border-0 h-100">
                                            <div class="card-body text-center p-4">
                                                <div class="university-logo mb-4">
                                                    @if (!empty($uni->image))
                                                        <img src="{{ $uni->image }}" alt="{{$uni->name}}"
                                                        class="img-fluid mx-auto" style="max-height: 80px; width: auto;">
                                                    @else
                                                        <img src="{{ asset('website/favicon.svg')}}" alt="{{$uni->name}}"
                                                        class="img-fluid mx-auto" style="max-height: 80px; width: auto;">
                                                    @endif
                                                </div>
                                                <a href="{{route('university.details', [$name, $uni->slug])}}"
                                                    class="btn btn-outline-primary btn-sm px-4 py-2 mt-3">
                                                    {{$uni->name}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Navigation buttons -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    @else
                        <div class="insights-container">
                            <!-- Animated background shapes -->
                            <div class="shape shape-1"></div>
                            <div class="shape shape-2"></div>
                            <div class="shape shape-3"></div>
                            <div class="shape shape-4"></div>

                            <!-- Blob effects -->
                            <div class="blob blob-1"></div>
                            <div class="blob blob-2"></div>

                            <!-- Message content -->
                            <div class="insights-message">
                                We are gathering our insights on the universities based in <span
                                    id="country-name">{{$countryName}}! Stay Tuned.</span>
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@section('scripts')
    <script src="{{ asset('website/forms.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.swiper-container', {
                slidesPerView: 2,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    576: {
                        slidesPerView: 3,
                    },
                    768: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 5,
                    },
                    // ✅ Lock at 5 slides for anything above 992
                    1200: {
                        slidesPerView: 5,
                    },
                    1400: {
                        slidesPerView: 5,
                    }
                }
            });
        });
    </script>
@endsection