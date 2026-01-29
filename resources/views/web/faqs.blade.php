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
        h1{
            font-family: 'Bambino-Bold', sans-serif;
        }
        h2,
        h3 {
            font-family: 'Bambino-Regular', sans-serif;
        }

        p {
            font-family: 'Bambino-Light', sans-serif;
        }

        ul span {
            font-family: 'Bambino-Light', sans-serif;
        }

        .btn {
            font-family: 'Bambino-Light', sans-serif;
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
            max-width: 1000px;
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
            @forelse ($faqs as $key => $faq)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $key + 1 }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $key + 1 }}" aria-expanded="true"
                                aria-controls="collapse{{ $key + 1 }}">
                            {{ $faq->question }}
                            <span class="icon-container">
                                <i class="ri-add-fill icon-plus"></i>
                                <i class="ri-subtract-fill icon-minus"></i>
                            </span>
                        </button>
                    </h2>
                    <div id="collapse{{ $key + 1 }}" class="accordion-collapse collapse show"
                         aria-labelledby="heading{{ $key + 1 }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>{{ $faq->answer }}</p>
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