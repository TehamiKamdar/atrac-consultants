document.addEventListener('DOMContentLoaded', function () {
    // --- Slider ---
    if (typeof $ !== 'undefined' && $('.country-slider').length) {
        $('.country-slider').slick({
            dots: false,
            infinite: true,
            speed: 1000,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1000,
            arrows: true,
            prevArrow: '<button type="button" class="slick-prev"></button>',
            nextArrow: '<button type="button" class="slick-next"></button>',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        arrows: true
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        arrows: true
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        arrows: true
                    }
                }
            ]
        });
    }

    // --- Typed.js ---
    if (typeof Typed !== 'undefined') {
        new Typed('#element', {
            strings: [
                "Limited Seats Available",
                "Scholarships upto<span> 100%</span>",
                "Apply <span>Now</span>"
            ],
            typeSpeed: 50,
            backSpeed: 30,
            loop: true,
            showCursor: false
        });
    }

    // --- Dismissible Alert ---
    const closeBtn = document.getElementById('close-btn');
    const alertBox = document.getElementById('alert');
    if (closeBtn && alertBox) {
        closeBtn.addEventListener('click', function () {
            alertBox.style.display = 'none';
        });
    }

    // --- Stats Animation ---
    function animateStats() {
        const statValues = document.querySelectorAll('.stat-value');
        const duration = 1500;

        statValues.forEach(stat => {
            const target = parseFloat(stat.getAttribute('data-target'));
            const dataType = stat.getAttribute('data-type') || 'number';
            let current = 0;
            const increment = target / (duration / 16);

            const animate = () => {
                current = Math.min(current + increment, target);
                stat.textContent =
                    dataType === 'percentage' ? current.toFixed(1) + '%' : Number(current.toFixed(1)).toLocaleString();
                if (current < target) {
                    requestAnimationFrame(animate);
                }
            };

            animate();
        });
    }

    const statsSection = document.querySelector('#stats-section');
    let hasAnimated = false;
    if (statsSection) {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !hasAnimated) {
                    statsSection.querySelectorAll('.stat-item').forEach(item => item.classList.add('in-view'));
                    animateStats();
                    hasAnimated = true;
                    observer.unobserve(statsSection);
                }
            });
        }, { threshold: 0.3 });

        observer.observe(statsSection);
    }

    
});
