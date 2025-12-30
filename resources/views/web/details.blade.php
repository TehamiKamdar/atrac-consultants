@extends('layouts.web_layout')
@push('title')
    {{$details->meta_title}}
@endpush

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        body {
            font-family: 'Bambino-Regular', Arial, Helvetica, sans-serif;
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
            font-family: 'Bambino-Regular', sans-serif;
            color: #495057;
        }

        .list-group-item {
            padding-left: 0;
            border-left: 0;
            font-family: 'Bambino-Light', sans-serif !important;
            border-right: 0;
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
    <div class="country-details-section py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Left Column - Content -->
                <div class="col-lg-8">
                    <!-- Table of Contents -->
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-list-check-2 text-primary me-3" style="color: #2BB673;"></i>
                                Table of Contents
                            </h2>
                            <div class="list-group list-group-flush">
                                <a href="#desc"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    About {{$countryName}}
                                </a>
                                <a href="#environment"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Life in {{$countryName}} (Climate & Language)
                                </a>
                                <a href="#requirement"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Admission & English Proficiency Requirements
                                </a>
                                <a href="#cost-of-studying"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Cost of Studying for International Students
                                </a>
                                <a href="#visa-requirement"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Student visa requirements
                                </a>
                                <a href="#work-opportunity"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Part-Time & Post-Study Work Opportunities
                                </a>
                                <a href="#book-a-meeting"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Book a Meeting with expert
                                </a>
                                <a href="#university"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Explore the range of universities in {{ $countryName }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div class="card border-0 shadow-sm mb-5" id="desc">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-information-line text-primary me-3" style="color: #2BB673;"></i>
                                About {{$countryName}}
                            </h2>
                            <div class="content-text">
                                {{$details->meta_description}}
                                <br>
                                <br>
                                {{$details->country_description}}
                            </div>
                        </div>
                    </div>

                    <!-- Cost of Living -->
                    <div class="card border-0 shadow-sm mb-5" id="scholarship">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-money-dollar-circle-line text-primary me-3" style="color: #2BB673;"></i>
                                Cost of Living
                            </h2>
                            <div class="content-text">
                                {{$details->cost_of_living}}
                            </div>
                        </div>
                    </div>

                    <!-- Climate & Language -->
                    <div class="card border-0 shadow-sm mb-5" id="environment">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-globe-line text-primary me-3" style="color: #2BB673;"></i>
                                Climate & Language of {{$countryName}}
                            </h2>
                            <div class="content-text">
                                {{$details->climate}}
                            </div>
                            <div class="content-text mt-3">
                                {{$details->language}}
                            </div>
                        </div>
                    </div>

                    <!-- Admission Requirements -->
                    <div class="card border-0 shadow-sm mb-5" id="requirement">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-file-list-3-line text-primary me-3" style="color: #2BB673;"></i>
                                Admission requirements in {{$countryName}}
                            </h2>
                            <ul class="list-group list-group-flush">
                                @if (!empty($details->admission_requirements))
                                    @foreach ($details->admission_requirements as $areq)
                                        <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                            <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                            <span>{{ $areq }}</span>
                                        </li>
                                    @endforeach
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
                                            We are gathering our insights on the admission requirements based in <span
                                                id="country-name">{{$countryName}}! Stay Tuned.</span>
                                        </div>
                                    </div>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Cost of Studying -->
                    <div class="card border-0 shadow-sm mb-5" id="cost-of-studying">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-money-dollar-box-line text-primary me-3" style="color: #2BB673;"></i>
                                Cost of studying in {{$countryName}} for international students
                            </h2>
                            <div class="content-text">
                                {{$details->scholarships}}
                            </div>
                        </div>
                    </div>

                    <!-- Visa Requirements -->
                    <div class="card border-0 shadow-sm mb-5" id="visa-requirement">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-passport-line text-primary me-3" style="color: #2BB673;"></i>
                                Student visa requirements in {{$countryName}}
                            </h2>
                            <ul class="list-group list-group-flush">
                                @if (!empty($details->visa_requirements))
                                    @foreach ($details->visa_requirements as $vreq)
                                        <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                            <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                            <span>{{ $vreq }}</span>
                                        </li>
                                    @endforeach
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
                                            We are gathering our insights on the visa requirements based in <span
                                                id="country-name">{{$countryName}}! Stay Tuned.</span>
                                        </div>
                                    </div>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Work Opportunities -->
                    <div class="card border-0 shadow-sm mb-5" id="work-opportunity">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-briefcase-4-line text-primary me-3" style="color: #2BB673;"></i>
                                Post-Study Work Opportunities
                            </h2>
                            <div class="content-text">
                                {{$details->workOpp}}
                            </div>
                        </div>
                    </div>

                    <!-- Book Meeting -->
                    <div class="card border-0 shadow-sm mb-5" id="book-a-meeting">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="ri-calendar-check-line text-primary me-3" style="color: #2BB673;"></i>
                                Book a Meeting with expert
                            </h2>
                            <div class="content-text">
                                <p class="mt-3">
                                    Whether you choose to study in {{ $countryName }}, our team will guide you from
                                    selecting the right university to securing scholarships and visas, making your journey
                                    smooth and stress-free.
                                </p>

                                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                    data-bs-target="#applyNowModal">
                                    Apply Now
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
                                <i class="ri-calendar-check-line text-primary me-3" style="color: #2BB673;"></i>
                                Explore Study Opportunities in {{ $countryName }}
                            </h2>
                            <div class="content-text">
                                <p class="mt-3">
                                    Discover the best universities and educational programs in {{ $countryName }}.
                                    Our comprehensive guide will help you find the perfect institution that matches
                                    your academic goals and career aspirations.
                                </p>

                                <p>
                                    Learn about admission requirements, tuition fees, scholarships, and student life
                                    to make an informed decision about your international education journey.
                                </p>

                                <div class="d-flex gap-3 mt-4">
                                    <a href="{{ route('university.list', $details->slug) }}" class="btn btn-primary">
                                        <i class="ri-building-2-line me-2"></i> Explore Universities of {{ $countryName }}
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