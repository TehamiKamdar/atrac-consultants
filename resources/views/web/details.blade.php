@extends('layouts.web_layout')
@push('title')
    Details - {{$name}}
@endpush

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        .country-details-section {
            background-color: #f8fafc;
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
            color: #495057;
        }

        .list-group-item {
            padding-left: 0;
            border-left: 0;
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
        .swiper-container{
        }

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
                                <a href="#work-opportunity"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Part-Time & Post-Study Work Opportunities
                                </a>
                                <a href="#cost-of-studying"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Cost of Studying for International Students
                                </a>
                                <a href="#requirement"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Admission & English Proficiency Requirements
                                </a>
                                <a href="#environment"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Life in {{$name}} (Climate & Language)
                                </a>
                                <a href="#visa-requirement"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Student visa requirements
                                </a>
                                <a href="#book-a-meeting"
                                    class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center">
                                    <i class="ri-arrow-right-s-line text-primary me-2" style="color: #2BB673;"></i>
                                    Book a Meeting with expert
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
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>CV</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>Passport</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>Health insurance for overseas students</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>All educational documents</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>Experience letter (in case of gap)</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>English language test, such as, IELTS/PTE (if any)</span>
                                </li>
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
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>A valid passport</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>Polio certificate</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>Visa application fee</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>Passport-sized pictures</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>Proof of enrolment (your electronic confirmation of enrolment eCOE)</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>A Genuine Temporary Entrant (GTE) statement</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>Details of health insurance policy (OSHC)</span>
                                </li>
                                <li class="list-group-item border-0 ps-0 d-flex align-items-start">
                                    <i class="ri-check-line text-primary mt-1 me-2" style="color: #2BB673;"></i>
                                    <span>Financial proof that you can afford living expenses, tuition fees, return airfare,
                                        expenses for dependents</span>
                                </li>
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
                                <p>Are you interested in studying abroad but not sure where to start? Our team of experts is
                                    here to help! By filling out our simple meeting request form, you can schedule a
                                    one-on-one consultation to discuss your study abroad options, fees, scholarships, and
                                    more. We offer guidance for over 60 countries, so whether you're interested in
                                    {{$countryName}}, Asia, the Americas, or anywhere in between, we've got you covered.
                                </p>
                                <p class="mt-3">Our consultation service is completely free, and our team is dedicated to
                                    helping you achieve your study abroad goals. We understand that the process can be
                                    overwhelming, but we're here to provide personalized advice and support every step of
                                    the way. Don't miss out on the opportunity to explore the world and broaden your
                                    horizons through international education.</p>
                                <p class="mt-3">Book your meeting today and let us help you make your study abroad dreams a
                                    reality.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Form -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-lg sticky-top" style="top: 120px; z-index:50;">
                        <div class="card-header bg-primary text-white py-3">
                            <h3 class="mb-0 text-center fw-bold d-flex align-items-center justify-content-center">
                                <i class="ri-calendar-check-line me-2"></i>
                                Book Free Consultation
                            </h3>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{route('consultation')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="ri-user-line"></i>
                                        </span>
                                        <input type="text" class="form-control" name="name" placeholder="John Doe" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="ri-mail-line"></i>
                                        </span>
                                        <input type="email" class="form-control" name="email" placeholder="your@email.com"
                                            required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="ri-phone-line"></i>
                                        </span>
                                        <input type="tel" class="form-control" name="phone" placeholder="+92 300 1234567"
                                            required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Country of Interest</label>
                                    <input type="text" class="form-control" value="{{$countryName}}" disabled>
                                    <input type="hidden" name="country" value="{{$details->country_id}}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Field of Interest <span class="text-danger">*</span></label>
                                    <select class="form-select" name="field" required>
                                        <option value="" selected disabled>Select field</option>
                                        @foreach ($fields as $f)
                                            <option value="{{$f->field}}">{{$f->field}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Qualification <span class="text-danger">*</span></label>
                                    <select class="form-select" name="qualification" required>
                                        <option value="" selected disabled>Select qualification</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Bachelors">Bachelors</option>
                                        <option value="Masters">Masters</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Percentage/GPA <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="ri-percent-line"></i>
                                        </span>
                                        <input type="number" class="form-control" name="percentage" max="100"
                                            placeholder="e.g. 85" required>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                        <i class="ri-send-plane-line me-2"></i> Book Now
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="universities-slider mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="fw-bold mb-4">Universities in {{$countryName}}</h2>
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($universities as $uni)
                                <div class="swiper-slide">
                                    <div class="card shadow-sm border-0 h-100">
                                        <div class="card-body text-center p-4">
                                            <div class="university-logo mb-4">
                                                <img src="{{$uni->logo}}" alt="{{$uni->university_name}}"
                                                    class="img-fluid mx-auto" style="max-height: 80px; width: auto;">
                                            </div>
                                            <a href="{{route('university.details', $uni->slug)}}"
                                                class="btn btn-outline-primary btn-sm px-4 py-2 mt-3">
                                                {{$uni->university_name}}
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
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
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