@extends('layouts.web_layout')

@push('title')
    Contact
@endpush

@section('styles')
<style>
    .office-card {
        border: 1px solid rgba(43, 182, 115, 0.15);
        border-radius: 12px;
        transition: var(--transition);
        height: 100%;
    }

    .office-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow);
        border-color: rgba(43, 182, 115, 0.3);
    }

    .office-header {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 1.25rem 1.5rem;
    }

    .office-icon {
        background: rgba(255, 255, 255, 0.2);
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
    }

    .info-item {
        margin-bottom: 1.25rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    .info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .info-icon {
        color: var(--primary-green);
        font-size: 1.1rem;
        margin-right: 10px;
        width: 24px;
        text-align: center;
    }

    .floating-label{
        margin-bottom: 1rem !important;
    }

    .map-btn {
        background: var(--primary-light);
        color: var(--primary-green);
        border: 1px solid rgba(43, 182, 115, 0.3);
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        font-weight: 500;
    }

    .map-btn:hover {
        background: var(--primary-green);
        color: white;
        transform: translateY(-2px);
    }

    .contact-link {
        color: var(--primary-green);
        text-decoration: none;
        transition: var(--transition);
    }

    .contact-link:hover {
        color: var(--dark-green);
        text-decoration: underline;
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

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        border-color: var(--primary-green);
        color: white;
        font-weight: 500;
        padding: 10px 24px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(43, 182, 115, 0.25);
    }
</style>
@endsection

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

    {{--
    <script>
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
    <div class="container py-5">

        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold mb-3">Our Locations</h1>
            <p class="lead text-muted">We'd love to welcome you!</p>
        </div>

        <div class="row g-4">
            <!-- Office 1: Karachi -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="office-card card">
                    <div class="office-header">
                        <div class="d-flex align-items-center">
                            <div class="office-icon">
                                <i class="ri-building-3-line fs-5"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">Karachi</h4>
                                <small class="opacity-90">Head Office</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="info-item">
                            <div class="d-flex">
                                <i class="ri-map-pin-2-line info-icon"></i>
                                <div>
                                    <h6 class="fw-regular mb-2">Address</h6>
                                    <p class="text-muted mb-0 small">
                                        Office #101, Silver Trade Center<br>
                                        Block 13 A, Gulshan-e-Iqbal<br>
                                        Karachi, Pakistan
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="d-flex">
                                <i class="ri-phone-line info-icon"></i>
                                <div>
                                    <h6 class="fw-regular mb-2">Contact</h6>
                                    <div class="small">
                                        <p class="mb-1">
                                            <i class="ri-phone-fill text-muted me-1"></i>
                                            <a href="tel:+923353737904" class="contact-link">+92 335 3737904</a>
                                        </p>
                                        <p class="mb-0">
                                            <i class="ri-mail-fill text-muted me-1"></i>
                                            <a href="mailto:apply@atracconsultants.com"
                                                class="contact-link">apply@atracconsultants.com</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="d-flex">
                                <i class="ri-time-line info-icon"></i>
                                <div>
                                    <h6 class="fw-regular mb-2">Hours</h6>
                                    <p class="text-muted mb-0 small">
                                        Monday-Saturday: 11AM - 8PM<br>
                                        Sunday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-2">
                            <a href="https://www.google.com/maps/place/Atrac+Consultants/@24.9033943,67.0735336,17z/data=!4m10!1m2!2m1!1sOffice+101+Silver+Trade+Center+Gulshan-e-Iqbal+Karachi!3m6!1s0x3eb33f7dc212e66b:0x9765b0d5311c30dd!8m2!3d24.9033377!4d67.0761097!15sCjZPZmZpY2UgMTAxIFNpbHZlciBUcmFkZSBDZW50ZXIgR3Vsc2hhbi1lLUlxYmFsIEthcmFjaGmSARZlZHVjYXRpb25hbF9jb25zdWx0YW504AEA!16s%2Fg%2F11mhpl3cjz?entry=ttu&g_ep=EgoyMDI2MDEyMS4wIKXMDSoKLDEwMDc5MjA3MUgBUAM%3D"
                                target="_blank" class="map-btn">
                                <i class="ri-map-pin-line"></i> View on Map
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Office 2: Islamabad -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="office-card card">
                    <div class="office-header">
                        <div class="d-flex align-items-center">
                            <div class="office-icon">
                                <i class="ri-government-line fs-5"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">Islamabad</h4>
                                <small class="opacity-90">Regional Office</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="info-item">
                            <div class="d-flex">
                                <i class="ri-map-pin-2-line info-icon"></i>
                                <div>
                                    <h6 class="fw-regular mb-2">Address</h6>
                                    <p class="text-muted mb-0 small">
                                        Office 4B, Fourth Floor, Idris Arcade<br>
                                        Svc Road Jinnah Boulevard West<br>
                                        DHA Phase 2, Islamabad
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="d-flex">
                                <i class="ri-phone-line info-icon"></i>
                                <div>
                                    <h6 class="fw-regular mb-2">Contact</h6>
                                    <div class="small">
                                        <p class="mb-1">
                                            <i class="ri-phone-fill text-muted me-1"></i>
                                            <a href="tel:+923265209992" class="contact-link">+92 326 5209992</a>
                                        </p>
                                        <p class="mb-0">
                                            <i class="ri-mail-fill text-muted me-1"></i>
                                            <a href="apply@atracconsultants.com"
                                                class="contact-link">apply@atracconsultants.com</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="d-flex">
                                <i class="ri-time-line info-icon"></i>
                                <div>
                                    <h6 class="fw-regular mb-2">Hours</h6>
                                    <p class="text-muted mb-0 small">
                                        Monday-Saturday: 11AM - 8PM<br>
                                        Sunday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-2">
                            <a href="https://www.google.com/maps/place/Atrac+Consultants+-+Islamabad/@33.5338878,73.0911186,14z/data=!4m10!1m2!2m1!1sOffice+4B+Idris+Arcade+DHA+Phase+2+Islamabad!3m6!1s0x38dfedcdb1eb54a1:0x6950c5282ffe670a!8m2!3d33.5338878!4d73.1292274!15sCixPZmZpY2UgNEIgSWRyaXMgQXJjYWRlIERIQSBQaGFzZSAyIElzbGFtYWJhZJIBFmVkdWNhdGlvbmFsX2NvbnN1bHRhbnTgAQA!16s%2Fg%2F11xlyy9px5?entry=ttu&g_ep=EgoyMDI2MDEyMS4wIKXMDSoKLDEwMDc5MjA3MUgBUAM%3D"
                                target="_blank" class="map-btn">
                                <i class="ri-map-pin-line"></i> View on Map
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Office 3: Lahore (New Office) -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="office-card card">
                    <div class="office-header">
                        <div class="d-flex align-items-center">
                            <div class="office-icon">
                                <i class="ri-store-2-line fs-5"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">Lahore</h4>
                                <small class="opacity-90">Regional Office</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="info-item">
                            <div class="d-flex">
                                <i class="ri-map-pin-2-line info-icon"></i>
                                <div>
                                    <h6 class="fw-regular mb-2">Address</h6>
                                    <p class="text-muted mb-0 small">
                                        First Floor, Ali Tower, Office 105 &, 106<br>
                                        Gulberg III, MM Alam Rd, Lahore<br>
                                        Punjab, Pakistan
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="d-flex">
                                <i class="ri-phone-line info-icon"></i>
                                <div>
                                    <h6 class="fw-regular mb-2">Contact</h6>
                                    <div class="small">
                                        <p class="mb-1">
                                            <i class="ri-phone-fill text-muted me-1"></i>
                                            <a href="tel:+923285209992" class="contact-link">+92 328 5209992</a>
                                        </p>
                                        <p class="mb-0">
                                            <i class="ri-mail-fill text-muted me-1"></i>
                                            <a href="mailto:apply@atracconsultants.com"
                                                class="contact-link">apply@atracconsultants.com</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="d-flex">
                                <i class="ri-time-line info-icon"></i>
                                <div>
                                    <h6 class="fw-regular mb-2">Hours</h6>
                                    <p class="text-muted mb-0 small">
                                        Monday-Saturday: 11AM - 8PM<br>
                                        Sunday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-2">
                            <a href="https://www.google.com/maps/place/Atrac+Consultants+-+Lahore/@31.5115198,74.3511659,17z/data=!3m1!4b1!4m6!3m5!1s0x391905dd26af6b71:0xbdcb3d3a25f7fe74!8m2!3d31.5115198!4d74.3511659!16s%2Fg%2F11yxsghsw5?entry=ttu&g_ep=EgoyMDI2MDEyMS4wIKXMDSoKLDEwMDc5MjA3MUgBUAM%3D" target="_blank"
                                class="map-btn">
                                <i class="ri-map-pin-line"></i> View on Map
                            </a>
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

                <div class="card shadow-lg">
                    <div class="office-header py-3">
                        <h3 class="mb-0"><i class="fas fa-paper-plane me-2"></i> Send Us a Message</h3>
                    </div>
                    <div class="card-body p-4 p-xl-5">
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="floating-label">
                                <label for="name" class="fw-regular">Your Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="John Doe"
                                    required>
                            </div>

                            <div class="floating-label">
                                <label for="email" class="fw-regular">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="name@example.com" required>
                            </div>

                            <div class="floating-label">
                                <label for="email" class="fw-regular">Phone</label>
                                <div class="input-group">
                                    <!-- Prefix dropdown 25% -->
                                    <select id="phonePrefix" name="phone_prefix" class="form-select"
                                        style="flex: 0 0 25%; max-width: 25%;" required>
                                        @foreach ($sim_codes as $sim)
                                            <option value="0{{$sim->code}}">0{{$sim->code}}</option>
                                        @endforeach
                                    </select>

                                    <!-- Main number input 75% -->
                                    <input type="text" name="phone_number" id="phoneNumber" class="form-control"
                                        style="flex: 0 0 75%; max-width: 75%;" placeholder="1234567" maxlength="7" required>
                                </div>
                            </div>

                            <div class="floating-label">
                                <label for="subject" class="fw-regular">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject"
                                    placeholder="How can we help?" required>
                            </div>

                            <div class="floating-label">
                                <label for="subject" class="fw-regular">City</label>
                                <select name="city" class="form-select" id="">
                                    <option value="" selected disabled>Select City</option>
                                    <option value="karachi">Karachi</option>
                                    <option value="islamabad">Islamabad</option>
                                    <option value="lahore">Lahore</option>
                                </select>
                            </div>

                            <div class="floating-label">
                                <label for="message" class="fw-regular">Your Message</label>
                                <textarea class="form-control" id="message" rows="4" name="message"
                                    placeholder="Your message here..." required></textarea>
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
                    <div class="office-header py-3">
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
                                <label for="reviewName" class="fw-regular">Your Name</label>
                                <input type="text" class="form-control" id="reviewName" placeholder="John Doe" required>
                            </div>

                            <div class="floating-label">
                                <label for="reviewText" class="fw-regular">Your Review</label>
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