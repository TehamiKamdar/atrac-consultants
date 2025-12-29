@extends('layouts.web_layout')
@push('title')
About Us
@endpush
@section('styles')
<style>
    :root {
        --primary-color: #2BB673;
        --secondary-color: #1E8449;
    }

    body{
        font-family: 'Bambino-Regular', Arial, Helvetica, sans-serif;
    }
    .card-title{
        font-family: 'Bambino-Bold', sans-serif;
    }

    .about-section {
        background-color: #f8fafc;
    }

    .about-section p {
        font-family: 'Bambino-Light', sans-serif;
        background-color: #f8fafc;
    }

    .text-primary {
        font-family: 'Bambino-Regular', sans-serif;
        color: var(--primary-color) !important;
    }

    .bg-primary {
        background-color: var(--primary-color) !important;
    }

    .value-icon {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .icon-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(43, 182, 115, 0.1);
        border-radius: 50%;
    }

    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: translateY(-5px);
    }

    .leader-avatar {
        width: 200px;
        height: 200px;
        background-color: rgba(43, 182, 115, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .leader-icon {
        font-size: 5rem;
        color: var(--primary-color);
    }

    .leader-message {
        font-size: 1.1rem;
        line-height: 1.7;
    }
    .h4{
            font-family: 'Bambino-Bold', sans-serif;
    }

    @media (max-width: 768px) {
        .leader-avatar {
            width: 150px;
            height: 150px;
            margin-bottom: 1.5rem;
        }

        .leader-icon {
            font-size: 4rem;
        }
    }
</style>

@endsection
@section('content')
<!-- About Atrac Consultants -->
<section class="about-section py-5 bg-light">
    <div class="container">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-3 text-primary">About Atrac Consultants</h1>
            <div class="mx-auto" style="max-width: 800px;">
                <p class="lead mb-4">
                    Atrac Consultants is a premier education and immigration consultancy with a proven track record since our founding. We serve as the vital bridge connecting ambitious students with world-class educational opportunities abroad.
                </p>
                <p class="lead mb-4">
                    Our vision is to redefine excellence in education consultancy through innovative solutions and personalized guidance. With deep expertise in admissions processes, visa requirements, and global education trends, we empower students to navigate the complexities of international education.
                </p>
                <p class="lead">
                    Considering studying abroad? Let us transform your aspirations into reality through our comprehensive services. At Atrac Consultants, we combine expertise with passion to make your international education dreams come true.
                </p>
            </div>
        </div>

        <!-- Value Proposition Section -->
        <div class="value-props py-5">
            <div class="text-center mb-5">
                <h2 class="h4 display-5 fw-bold mb-3">Why Choose Atrac Consultants</h2>
                <p class="lead text-muted">Our commitment to excellence sets us apart</p>
            </div>

            <div class="row g-4">
                <!-- Mission Card -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper mb-3">
                                <i class="ri-star-line value-icon"></i>
                            </div>
                            <h3 class="h4 fw-bold mb-3">Our Mission</h3>
                            <p class="mb-0">
                                To break down barriers in global education by providing equal opportunities for students regardless of background, nationality, or circumstance.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Vision Card -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper mb-3">
                                <i class="ri-eye-line value-icon"></i>
                            </div>
                            <h3 class="h4 fw-bold mb-3">Our Vision</h3>
                            <p class="mb-0">
                                To create a world where geographical boundaries don't limit educational opportunities and talent can flourish anywhere.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Approach Card -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper mb-3">
                                <i class="ri-hand-heart-line value-icon"></i>
                            </div>
                            <h3 class="h4 fw-bold mb-3">Our Approach</h3>
                            <p class="mb-0">
                                We maintain the highest ethical standards, providing honest advice tailored to each student's unique goals and circumstances.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Values Card -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper mb-3">
                                <i class="ri-shield-check-line value-icon"></i>
                            </div>
                            <h3 class="h4 fw-bold mb-3">Our Values</h3>
                            <p class="mb-0">
                                Integrity, excellence, and student success guide every decision we make and every service we provide.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="leadership-section mt-5">
    <!-- Leader's Card -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="row g-0">
            <div class="col-md-4 d-flex align-items-center justify-content-center p-4">
                <div class="leader-avatar">
                    <i class="ri-user-3-line leader-icon"></i>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-body p-4 p-md-5">
                    <h2 class="card-title fw-bold mb-3">Voice of Leader</h2>
                    <h3 class="h4 text-primary mb-4">Founder & CEO</h3>
                    <div class="leader-message">
                        <p class="mb-3">
                            Our success stems from deep understanding of global education trends and immigration processes. We've simplified what was once complex, making international education accessible to all.
                        </p>
                        <p class="mb-3">
                            At Atrac Consultants, we've built a system that actively promotes foreign education opportunities while maintaining the highest standards of service and ethical practice.
                        </p>
                        <p class="mb-0 fw-bold" style="font-family: 'Bambino-Bold', sans-serif; font-size: 22px;">
                            I invite you to explore how we can help you achieve your international education goals.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
</section>

@endsection