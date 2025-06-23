<!-- Swiper JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
<style>
    :root {
        --primary: #2BB673;
        --primary-light: #e8f5ee;
        --dark: #212529;
        --gray: #6c757d;
        --light-gray: #f8f9fa;
    }

    body {
        font-family: 'Segoe UI', system-ui, sans-serif;
        background-color: #f5f7fa;
    }

    .review-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.03);
        transition: transform 0.3s ease;
    }

    .review-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .review-rating {
        color: #ffc107;
        margin-bottom: 1rem;
    }

    .review-text {
        color: var(--dark);
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .review-author {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .review-date {
        color: var(--gray);
        font-size: 0.85rem;
    }

    .swiper-pagination-bullet-active {
        background: var(--primary) !important;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: var(--primary) !important;
        background: rgba(43, 182, 115, 0.1);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 1.25rem !important;
        font-weight: bold;
    }

    .section-title {
        position: relative;
        padding-bottom: 12px;
        margin-bottom: 2.5rem;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--primary);
    }
</style>
</head>

<body>
    <div class="container py-5 my-4">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Customer Reviews</h2>
            <p class="text-muted">What our customers say about us</p>
        </div>

        <!-- Swiper Container -->
        <div class="swiper reviewSwiper">
            <div class="swiper-wrapper" id="reviews-container">
                <!-- Reviews will be loaded here -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary"></div>
                    <p class="mt-3">Loading reviews...</p>
                </div>
            </div>

            <!-- Navigation buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        // Initialize Swiper
        const swiper = new Swiper('.reviewSwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        });

        // Fetch reviews from JSON
        async function fetchReviews() {
            try {
                const response = await fetch('{{ asset('reviews/dataset_Google-Maps-Reviews-Scraper_2025-06-19_12-35-21-203.json') }}');
                if (!response.ok) throw new Error('Failed to fetch reviews');
                return await response.json();
            } catch (error) {
                console.error('Error:', error);
                return null;
            }
        }

        // Display reviews
        async function displayReviews() {
            const container = document.getElementById('reviews-container');
            const data = await fetchReviews();

            if (!data) {
                container.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="ri-error-warning-line text-danger" style="font-size: 2rem;"></i>
                        <p class="mt-3">Failed to load reviews. Please try again later.</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = data.map(review => `
                <div class="swiper-slide">
                    <div class="review-card">
                        <div class="review-rating">
                            ${renderStars(review.stars)}
                        </div>
                        <p class="review-text">${review.text ? review.text : "Great Services"}</p>
                        <div>
                            <p class="review-author">${review.name}</p>
                            <p class="review-date">${new Date(review.publishedAtDate).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            })}</p>
                        </div>
                    </div>
                </div>
            `).join('');

            // Update Swiper after loading new slides
            swiper.update();
        }

        // Render star rating
        function renderStars(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += i <= rating
                    ? '<i class="ri-star-fill"></i>'
                    : i - 0.5 <= rating
                        ? '<i class="ri-star-half-line"></i>'
                        : '<i class="ri-star-line"></i>';
                stars += ' '; // Add space between stars
            }
            return stars;
        }

        // Load reviews when page loads
        document.addEventListener('DOMContentLoaded', displayReviews);
    </script>