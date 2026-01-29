@extends('layouts.web_layout')

@push('title')
FAQs
@endpush

@section('styles')
<style>
    /* FAQ Header */
        .faq-header {
            background: linear-gradient(0deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            padding: 80px 0;
            margin-bottom: 60px;
            text-align: center;
        }

        .faq-header h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .faq-header p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Custom Accordion Styles */
        .custom-accordion .accordion-item {
            background-color: white;
            border: none;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .custom-accordion .accordion-item:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .custom-accordion .accordion-button {
            background-color: white;
            color: var(--dark-text);
            font-size: 1.1rem;
            font-weight: 600;
            padding: 20px 25px;
            border: none;
            box-shadow: none;
            position: relative;
            transition: var(--transition);
        }

        .custom-accordion .accordion-button:not(.collapsed) {
            background-color: var(--primary-light);
            color: var(--dark-green);
            box-shadow: none;
        }

        .custom-accordion .accordion-button:focus {
            box-shadow: none;
            border-color: transparent;
        }

        /* Plus/Minus Icons */
        .custom-accordion .accordion-button::after {
            display: none; /* Hide default Bootstrap arrow */
        }

        .custom-accordion .accordion-button .icon-container {
            position: absolute;
            right: 25px;
            transition: var(--transition);
        }

        .custom-accordion .accordion-button .icon-plus {
            display: inline-block;
            color: var(--primary-green);
            font-size: 1.25rem;
        }

        .custom-accordion .accordion-button:not(.collapsed) .icon-plus {
            display: none;
        }

        .custom-accordion .accordion-button .icon-minus {
            display: none;
            color: var(--dark-green);
            font-size: 1.25rem;
        }

        .custom-accordion .accordion-button:not(.collapsed) .icon-minus {
            display: inline-block;
        }

        /* Accordion Body */
        .custom-accordion .accordion-body {
            padding: 25px;
            background-color: white;
            color: var(--text-color);
            border-top: 1px solid var(--primary-light);
        }

        .custom-accordion .accordion-body p {
            margin-bottom: 0;
            line-height: 1.7;
        }

        /* FAQ Container */
        .faq-container {
            max-width: 800px;
            margin: 0 auto 80px;
            padding: 0 20px;
        }

        /* Contact Section */
        .contact-section {
            background-color: white;
            padding: 60px 0;
            margin-top: 60px;
            border-top: 1px solid #eee;
        }

        .contact-section h3 {
            color: var(--dark-green);
            margin-bottom: 20px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .faq-header h1 {
                font-size: 2.5rem;
            }

            .faq-header {
                padding: 60px 0;
                margin-bottom: 40px;
            }

            .custom-accordion .accordion-button {
                font-size: 1rem;
                padding: 15px 20px;
            }

            .custom-accordion .accordion-body {
                padding: 20px;
            }
        }
</style>
@endsection

@section('content')
<!-- FAQ Header -->
    <header class="faq-header">
        <div class="container">
            <h1>Frequently Asked Questions</h1>
            <p>Find quick answers to common questions about our products and services</p>
        </div>
    </header>

    <!-- FAQ Accordion Section -->
    <main class="faq-container">
        <div class="accordion custom-accordion" id="faqAccordion">
            <!-- FAQ Item 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true"
                            aria-controls="collapseOne">
                        What services do you offer?
                        <span class="icon-container">
                            <i class="ri-add-fill icon-plus"></i>
                            <i class="ri-subtract-fill icon-minus"></i>
                        </span>
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show"
                     aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>We offer a comprehensive range of digital services including web development,
                        mobile app development, UI/UX design, digital marketing, and consulting services.
                        Our team specializes in creating custom solutions tailored to your business needs,
                        leveraging the latest technologies and industry best practices.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo">
                        How long does a typical project take?
                        <span class="icon-container">
                            <i class="ri-add-fill icon-plus"></i>
                            <i class="ri-subtract-fill icon-minus"></i>
                        </span>
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse"
                     aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Project timelines vary depending on the scope and complexity. A simple website
                        might take 2-3 weeks, while more complex web applications can take 3-6 months.
                        We provide detailed project timelines during our initial consultation and maintain
                        transparent communication throughout the development process.</p>
                        <p>All projects include regular milestone reviews to ensure we stay on track
                        and meet your expectations.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                            aria-expanded="false" aria-controls="collapseThree">
                        What is your pricing structure?
                        <span class="icon-container">
                            <i class="ri-add-fill icon-plus"></i>
                            <i class="ri-subtract-fill icon-minus"></i>
                        </span>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse"
                     aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>We offer flexible pricing options:</p>
                        <ul>
                            <li><strong>Fixed Price:</strong> For well-defined projects with clear requirements</li>
                            <li><strong>Time & Materials:</strong> For projects with evolving requirements</li>
                            <li><strong>Retainer:</strong> For ongoing maintenance and support</li>
                            <li><strong>Custom Packages:</strong> Tailored solutions for specific business needs</li>
                        </ul>
                        <p>We provide detailed quotes after understanding your specific requirements
                        and project scope. Contact us for a personalized estimate.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                            aria-expanded="false" aria-controls="collapseFour">
                        Do you provide ongoing support and maintenance?
                        <span class="icon-container">
                            <i class="ri-add-fill icon-plus"></i>
                            <i class="ri-subtract-fill icon-minus"></i>
                        </span>
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse"
                     aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Yes, we offer comprehensive support and maintenance packages to ensure your
                        digital solutions continue to perform optimally. Our support services include:</p>
                        <ul>
                            <li>Regular security updates and patches</li>
                            <li>Performance monitoring and optimization</li>
                            <li>Content updates and changes</li>
                            <li>Technical support and troubleshooting</li>
                            <li>Backup management and disaster recovery</li>
                        </ul>
                        <p>We offer monthly and annual support plans tailored to your specific needs.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                            aria-expanded="false" aria-controls="collapseFive">
                        What technologies do you work with?
                        <span class="icon-container">
                            <i class="ri-add-fill icon-plus"></i>
                            <i class="ri-subtract-fill icon-minus"></i>
                        </span>
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse"
                     aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Our team is proficient in a wide range of modern technologies:</p>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Frontend:</strong></p>
                                <ul>
                                    <li>HTML5, CSS3, JavaScript (ES6+)</li>
                                    <li>React, Vue.js, Angular</li>
                                    <li>Bootstrap 5, Tailwind CSS</li>
                                    <li>TypeScript, Webpack, Vite</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Backend:</strong></p>
                                <ul>
                                    <li>Node.js, Python, PHP</li>
                                    <li>Express, Django, Laravel</li>
                                    <li>MySQL, PostgreSQL, MongoDB</li>
                                    <li>REST APIs, GraphQL</li>
                                </ul>
                            </div>
                        </div>
                        <p>We choose technologies based on project requirements, scalability needs,
                        and long-term maintainability.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container text-center">
            <h3>Still have questions?</h3>
            <p class="mb-4">Can't find the answer you're looking for? Our team is here to help.</p>
            <a href="{{ route('contact') }}" class="btn btn-primary" style="padding: 12px 30px; font-weight: 600;">
                <i class="ri-mail-line me-2"></i>Contact Our Team
            </a>
        </div>
    </section>
@endsection