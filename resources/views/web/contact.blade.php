@extends('layouts.web_layout')

@push('title')
Contact
@endpush


@section('scripts')
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

    {{-- <script>
        // Enhanced Rating stars functionality
        document.querySelectorAll('.rating-star').forEach(star => {
            star.addEventListener('click', function () {
                const value = this.getAttribute('data-value');
                document.getElementById('ratingValue').value = value;

                // Update star display
                document.querySelectorAll('.rating-star').forEach((s, index) => {
                    if (index < value) {
                        s.innerHTML = '<i class="fas fa-star"></i>';
                        s.classList.add('active');
                    } else {
                        s.innerHTML = '<i class="far fa-star"></i>';
                        s.classList.remove('active');
                    }
                });
            });

            // Enhanced hover effect
            star.addEventListener('mouseover', function () {
                const value = this.getAttribute('data-value');
                document.querySelectorAll('.rating-star').forEach((s, index) => {
                    s.classList.remove('active');
                    if (index < value) {
                        s.innerHTML = '<i class="fas fa-star"></i>';
                    } else {
                        s.innerHTML = '<i class="far fa-star"></i>';
                    }
                });
            });

            star.addEventListener('mouseout', function () {
                const currentRating = document.getElementById('ratingValue').value;
                document.querySelectorAll('.rating-star').forEach((s, index) => {
                    if (index < currentRating) {
                        s.innerHTML = '<i class="fas fa-star"></i>';
                        s.classList.add('active');
                    } else {
                        s.innerHTML = '<i class="far fa-star"></i>';
                        s.classList.remove('active');
                    }
                });
            });
        });

        document.getElementById('reviewForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const rating = document.getElementById('ratingValue').value;
            const btn = this.querySelector('button[type="submit"]');

            if (rating === '0') {
                alert('Please select a rating');
                return;
            }

            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Submitting...';
            btn.disabled = true;

            // Simulate API call
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-check me-2"></i> Thank You!';
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-check me-2"></i> Submit Review';
                    btn.disabled = false;
                }, 2000);
                this.reset();

                // Reset stars
                document.querySelectorAll('.rating-star').forEach(star => {
                    star.innerHTML = '<i class="far fa-star"></i>';
                    star.classList.remove('active');
                });
                document.getElementById('ratingValue').value = '0';
            }, 1500);
        });
    </script> --}}
@endsection

@section('styles')
    <style>
        :root {
            --primary-color: #2BB673;
            --primary-dark: #1e9d5f;
            --primary-light: #e8f5ee;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --gray-color: #6c757d;
            --light-gray: #e9ecef;
        }
        body{
            font-family: 'Bambino-Regular', Arial, Helvetica, sans-serif;
        }

        .bg-primary-custom {
            background-color: var(--primary-color) !important;
        }

        .text-primary-custom {
            color: var(--primary-color) !important;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            font-weight: 500;
            padding: 10px 24px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(43, 182, 115, 0.25);
        }

        .btn-outline-primary-custom {
            color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 500;
        }

        .btn-outline-primary-custom:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .rating-star {
            color: #ddd;
            font-size: 1.75rem;
            cursor: pointer;
            transition: all 0.2s;
            margin-right: 5px;
        }

        .rating-star:hover,
        .rating-star.active {
            color: #ffc107;
            transform: scale(1.1);
        }


        .card:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        .card-header h3, .card-header h2{
            font-family: 'Bambino-Bold', sans-serif;
        }

        .review-card {
            border-left: 4px solid var(--primary-color);
            background-color: white;
            margin-bottom: 1.5rem;
        }

        .review-card .card-body {
            padding: 1.5rem;
        }

        .contact-icon {
            width: 56px;
            height: 56px;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            color: var(--primary-color);
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background-color: var(--primary-color);
            border-radius: 2px;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid var(--light-gray);
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(43, 182, 115, 0.25);
        }

        .contact-info-item {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .contact-info-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .floating-label {
            position: relative;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-color);
            border-radius: 0.6rem;
        }

        .floating-label label {
            position: absolute;
            top: -10px;
            left: 12px;
            background-color: white;
            padding: 0 5px;
            font-size: 0.85rem;
            color: var(--gray-color);
            z-index: 1;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
        }

        .divider:before,
        .divider:after {
            content: "";
            flex: 1;
            border-bottom: 1px solid var(--light-gray);
        }

        .divider-text {
            padding: 0 1rem;
            color: var(--gray-color);
            font-size: 0.9rem;
        }
        .office-header {
            background-color: #2bb673;
            color: #fff;
        }

        .office-card {
            height: 100%;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .office-info h3{
            font-family: 'Bambino-Regular', sans-serif;
        }

        .office-info p{
            font-family: 'Bambino-Light', sans-serif;
        }

        .icon-box {
    color: #2bb673; /* Matching your green theme */
    margin-right: 8px; /* Space between icon and text */
    font-size: 1.1em; /* Slightly larger than default */
    vertical-align: middle; /* Aligns properly with the heading text */
    width: 1.25em; /* Consistent width */
    text-align: center; /* Center the icon */
}

    </style>
@endsection

@section('content')
    <div class="container py-5">

        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold mb-3">Our Locations</h1>
            <p class="lead text-muted">We'd love to welcome you!</p>
        </div>

        <div class="row g-4">
            <!-- Office 1 -->
            <div class="col-lg-6 col-12">
                <div class="office-card card">
                    <div class="office-header card-header bambino-bold">
                        <h2 class="mb-0">Head Office —— Karachi</h2>
                    </div>
                    <div class="card-body">
                        <div class="office-info mb-3">
                            <h3><i class="icon-box fa-solid fa-location-dot"></i>Address</h3>
                            <p class="mb-0">
                                Office #101, Silver Trade Center<br>
                                Block 13 A, Gulshan-e-Iqbal<br>
                                Karachi, Pakistan
                            </p>
                        </div>
                        <div class="office-info mb-3">
                            <h3><i class="icon-box fa-solid fa-phone"></i>Contact</h3>
                            <p class="mb-0">Phone: +92 335 3737904 <br>Email: atracconsultants@gmail.com</p>
                        </div>
                        <div class="office-info">
                            <h3><i class="icon-box fa-solid fa-clock"></i>Hours</h3>
                            <p class="mb-0">Monday-Saturday: 11AM - 8PM<br>Sunday: Closed</p>
                        </div>
                        <div class="map-container mt-3">
                            <div class="ratio ratio-16x9">
                                <iframe class="border-0 shadow-sm rounded" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.84296197496!2d67.07353477468025!3d24.90333767790128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33f7dc212e66b%3A0x9765b0d5311c30dd!2sAtrac%20Consultants!5e0!3m2!1sen!2s!4v1753632783955!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Office 2 -->
            <div class="col-lg-6 col-12">
                <div class="office-card card">
                    <div class="office-header card-header bambino-bold">
                        <h2 class="mb-0">Regional Office —— Islamabad</h2>
                    </div>
                    <div class="card-body">
                        <div class="office-info mb-3">
                            <h3><i class="icon-box fa-solid fa-location-dot"></i>Address</h3>
                            <p class="mb-0">
                                Office 4B, Fourth Floor, Idris Arcade, Svc Road Jinnah Boulevard West<br>
                                G.T Road, Near Gate 1, DHA Phase 2<br>
                                Islamabad, Pakistan
                            </p>
                        </div>
                        <div class="office-info mb-3">
                            <h3><i class="icon-box fa-solid fa-phone"></i>Contact</h3>
                            <p class="mb-0">Phone: +92 325 5209992<br>Email: atracconsultant@gmail.com</p>
                        </div>
                        <div class="office-info">
                            <h3><i class="icon-box fa-solid fa-clock"></i>Hours</h3>
                            <p class="mb-0">Monday-Saturday: 11AM - 8PM<br>Sunday: Closed</p>
                        </div>
                        <div class="map-container mt-3">
                            <div class="ratio ratio-16x9">
                                <iframe class="border-0 shadow-sm rounded" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3325.749892230193!2d73.12665247505836!3d33.533887773356575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfedcdb1eb54a1%3A0x6950c5282ffe670a!2sAtrac%20Consultants%20-%20Islamabad!5e0!3m2!1sen!2s!4v1753633313678!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <h1 class="display-5 fw-bold mb-3">Get In Touch</h1>
            <p class="lead text-muted">We'd love to hear from you! Contact us or share your experience.</p>
        </div>

        <div class="row g-4">
            <!-- Contact Form Section -->
            <div class="col-lg-6">
                @if (session('success'))
                    <div id="alert" class="alert alert-primary alert-custom">
                        {{ session('success') }}
                        <button id="close-btn" class="close">&times;</button>
                    </div>
                @endif
                <div class="card shadow-lg">
                    <div class="card-header bg-primary-custom text-white py-3">
                        <h3 class="mb-0"><i class="fas fa-paper-plane me-2"></i> Send Us a Message</h3>
                    </div>
                    <div class="card-body p-4 p-xl-5">
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="floating-label">
                                <label for="name" class="fw-semibold">Your Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
                            </div>

                            <div class="floating-label">
                                <label for="email" class="fw-semibold">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                            </div>

                            <div class="floating-label">
                                <label for="subject" class="fw-semibold">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="How can we help?" required>
                            </div>

                            <div class="floating-label">
                                <label for="message" class="fw-semibold">Your Message</label>
                                <textarea class="form-control" id="message" rows="4" name="message" placeholder="Your message here..."
                                    required></textarea>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-paper-plane me-2"></i> Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Review Section -->
            <div class="col-lg-6">
                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-primary-custom text-white py-3">
                        <h3 class="mb-0"><i class="fas fa-star me-2"></i> Share Your Experience</h3>
                    </div>
                    <div class="card-body p-4 p-xl-5">
                        <form id="reviewForm" action="">
                            <div class="mb-4">
                                <label class="form-label d-block mb-3">Your Rating</label>
                                <div class="rating">
                                    <span class="rating-star" data-value="1"><i class="far fa-star"></i></span>
                                    <span class="rating-star" data-value="2"><i class="far fa-star"></i></span>
                                    <span class="rating-star" data-value="3"><i class="far fa-star"></i></span>
                                    <span class="rating-star" data-value="4"><i class="far fa-star"></i></span>
                                    <span class="rating-star" data-value="5"><i class="far fa-star"></i></span>
                                    <input type="hidden" id="ratingValue" name="rating" value="0">
                                </div>
                            </div>

                            <div class="floating-label">
                                <label for="reviewName" class="fw-semibold">Your Name</label>
                                <input type="text" class="form-control" id="reviewName" placeholder="John Doe" required>
                            </div>

                            <div class="floating-label">
                                <label for="reviewText" class="fw-semibold">Your Review</label>
                                <textarea class="form-control" id="reviewText" rows="4"
                                    placeholder="Share your experience..." required></textarea>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-check me-2"></i> Submit Review
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @include('include.reviews')
        </div>
    </div>
@endsection