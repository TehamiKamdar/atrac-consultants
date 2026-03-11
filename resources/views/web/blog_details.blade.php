@extends('layouts.web_layout')

@push('title')
{{ $details->title }}
@endpush

@section('styles')
<style>
        /* CSS Reset - Minimal */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* CSS Variables - Your Exact Theme */
        :root {
            --primary-green: #2BB673;
            --primary-dark: #1e9d5f;
            --primary-light: #e8f5ee;
            --dark-green: #1E8449;
            --dark-text: #333333;
            --light-bg: #f8f8f8;
            --nav-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            --light-text: #f8f9fa;
            --dark-gray: #5e5e5e;
            --dark-bg: #1a1a1a;
            --hero-overlay: rgba(0, 0, 0, 0.6);
            --dark-color: #212529;
            --light-gray: #f8f9fa;
            --text-color: #495057;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
            --gray: #6c757d;

            /* CLS Optimization */
            --heading-line-height: 1.2;
            --body-line-height: 1.6;
            --image-aspect-ratio: 16/9;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Bambino-Regular', sans-serif;
        }

        a,p {
            font-family: 'Bambino-Light', sans-serif;
        }

        ul span {
            font-family: 'Bambino-Light', sans-serif;
        }

        button, .btn {
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

        .custom-accordion .accordion-header {
            margin: 0px !important;
            line-height: 1.7;
        }

        /* Container Width Optimization */
        .container {
            max-width: 1280px;
            padding: 0 24px;
            margin: 0 auto;
        }

        /* Navigation - Lightweight */
        .navbar {
            background: white;
            box-shadow: var(--nav-shadow);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            height: 80px; /* Fixed height for CLS */
        }

        .navbar-brand {

            font-weight: 700;
            font-size: 1.75rem;
            color: var(--primary-green) !important;
            text-decoration: none;
            line-height: 1;
        }

        .navbar-brand i {
            color: var(--primary-green);
            margin-right: 8px;
        }

        .navbar-nav {
            display: flex;
            gap: 8px;
        }

        .nav-link {

            font-weight: 500;
            color: var(--dark-text) !important;
            padding: 8px 16px !important;
            text-decoration: none;
            transition: var(--transition);
            border-radius: 40px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-green) !important;
            background: var(--primary-light);
        }

        .btn-consult {
            background: var(--primary-green);
            color: white !important;
            border-radius: 40px;
            padding: 8px 20px !important;
            font-weight: 600;
        }

        .btn-consult:hover {
            background: var(--primary-dark);
            color: white !important;
        }

        /* Hero Section - Minimal */
        .hero-blog {
            padding: 40px 0 20px;
            background: linear-gradient(to bottom, var(--primary-light) 0%, white 100%);
        }

        .category-badge {
            display: inline-block;

            font-weight: 600;
            font-size: 0.875rem;
            padding: 6px 16px;
            background: var(--primary-green);
            color: white;
            border-radius: 40px;
            margin-bottom: 20px;
            letter-spacing: 0.3px;
        }

        .blog-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 24px;
            max-width: 900px;
        }

        .blog-meta {
            display: flex;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            margin: 24px 0;
            padding: 16px 0;
            border-top: 1px solid rgba(0,0,0,0.05);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--gray);
            font-size: 0.95rem;
        }

        .meta-item i {
            color: var(--primary-green);
            font-size: 1.1rem;
        }

        .author-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .author-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-green);
            aspect-ratio: 1/1;
        }

        .author-name {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 4px;
        }

        .author-title {
            font-size: 0.875rem;
            color: var(--gray);
        }

        /* Featured Image - Fixed Aspect Ratio for CLS */
        .featured-image-wrapper {
            margin: 32px 0 40px;
            border-radius: 0px;
            overflow: hidden;
            aspect-ratio: 16/9;
            background: #f0f0f0; /* Placeholder background */
        }

        .featured-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0px;
        }

        /* Content Layout */
        .content-wrapper {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 48px;
            margin: 40px 0;
        }

        @media (max-width: 991px) {
            .content-wrapper {
                grid-template-columns: 1fr;
                gap: 32px;
            }
        }

        /* Blog Content */
        .blog-content {
            font-size: 1.1rem;
        }

        .blog-content h2 {
            font-size: 2.2rem;
            margin: 40px 0 20px;
            color: var(--dark-text);
        }

        .blog-content h3 {
            font-size: 1.6rem;
            margin: 32px 0 16px;
            color: var(--dark-text);
        }

        .blog-content p {
            margin-bottom: 24px;
            color: var(--text-color);
        }

        .blog-content ul,
        .blog-content ol {
            margin-bottom: 24px;
            padding-left: 24px;
        }

        .blog-content li {
            margin-bottom: 12px;
        }

        .blog-content li::marker {
            color: var(--primary-green);
        }

        /* Highlight Box */
        .highlight-box {
            background: var(--primary-light);
            border-left: 4px solid var(--primary-green);
            padding: 24px;
            border-radius: 12px;
            margin: 32px 0;
        }

        .highlight-box h4 {
            margin-bottom: 12px;
            color: var(--dark-green);
        }

        /* Country Card */
        .country-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            margin: 16px 0;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .country-flag {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .country-info h5 {
            margin-bottom: 4px;
            font-weight: 600;
        }

        .country-info p {
            margin: 0;
            font-size: 0.9rem;
            color: var(--gray);
        }

        .visa-badge {
            background: var(--primary-green);
            color: white;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: auto;
        }

        /* Stats Card */
        .stats-card {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 32px;
            border-radius: 20px;
            margin: 40px 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;

            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Sidebar */
        .sidebar {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .widget {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .widget-title {

            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--primary-light);
            color: var(--dark-text);
        }

        .widget-title i {
            color: var(--primary-green);
            margin-right: 8px;
        }

        /* Consultation Form */
        .consult-form input,
        .consult-form select,
        .consult-form textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 16px;

            font-size: 0.95rem;
        }

        .consult-form input:focus,
        .consult-form select:focus,
        .consult-form textarea:focus {
            border-color: var(--primary-green);
            outline: none;
            box-shadow: 0 0 0 3px rgba(43, 182, 115, 0.1);
        }

        .btn-submit {
            background: var(--primary-green);
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 40px;
            font-weight: 600;
            width: 100%;

            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Country List */
        .category-list {
            list-style: none;
            padding: 0;
        }

        .category-list li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .category-list li:last-child {
            border-bottom: none;
        }

        .category-list a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            transition: var(--transition);
        }

        .category-list a:hover {
            color: var(--primary-green);
            padding-left: 5px;
        }

        .category-count {
            background: var(--primary-light);
            color: var(--primary-green);
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Popular Posts */
        .popular-post {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            text-decoration: none;
        }

        .popular-post:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .post-thumb {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
            aspect-ratio: 1/1;
        }

        .post-info h6 {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--dark-text);
        }

        .post-info small {
            font-size: 0.75rem;
            color: var(--gray);
        }

        /* Tags */
        .tags-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tag {
            background: var(--light-gray);
            color: var(--text-color);
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 0.85rem;
            text-decoration: none;
            transition: var(--transition);
        }

        .tag:hover {
            background: var(--primary-green);
            color: white;
        }

        /* Author Box */
        .author-box {
            background: var(--primary-light);
            border-radius: 16px;
            padding: 32px;
            margin: 40px 0;
        }

        .author-box-content {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .author-box-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-green);
        }

        .author-box-info h4 {
            margin-bottom: 8px;
        }

        .author-box-info p {
            margin-bottom: 16px;
            color: var(--gray);
        }

        .author-social {
            display: flex;
            gap: 12px;
        }

        .author-social a {
            color: var(--gray);
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .author-social a:hover {
            color: var(--primary-green);
        }

        /* Related Posts */
        .related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin: 40px 0;
        }

        @media (max-width: 768px) {
            .related-grid {
                grid-template-columns: 1fr;
            }
        }

        .related-card {
            text-decoration: none;
            color: inherit;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .related-card:hover {
            transform: translateY(-5px);
        }

        .related-card img {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
        }

        .related-content {
            padding: 16px;
            background: white;
        }

        .related-content h5 {
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .related-content small {
            color: var(--gray);
            font-size: 0.8rem;
        }

        /* WhatsApp Float Button - Convert */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #25d366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.3);
            transition: var(--transition);
            z-index: 99;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            color: white;
        }

        /* CLS Optimizations */
        img, video, iframe {
            max-width: 100%;
            height: auto;
        }

        .aspect-ratio-box {
            aspect-ratio: 16/9;
            background: #f0f0f0;
        }

        /* Print Styles */
        @media print {
            .navbar, .sidebar, .footer, .whatsapp-float, .consult-form {
                display: none;
            }
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
<a href="https://wa.me/1234567890?text=Hi%20I%20need%20study%20abroad%20consultation" class="whatsapp-float" target="_blank">
    <i class="ri-whatsapp-line"></i>
</a>
<!-- Hero Section -->
<section class="hero-blog">
    <div class="container">
        <div class="category-badge">
            <i class="ri-flight-takeoff-line"></i>
            @foreach ($details->categories as $category)
                {{ strtoupper($category->name) }} ·
            @endforeach
        </div>

        <h1 class="blog-title">
            {{ $details->title }}
        </h1>

        <div class="blog-meta">
            <div class="author-wrapper">
                <img src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                     alt="{{ $details->user->name === 'Admin' ? 'Dr. Uzair Yameen' : $details->user->name }}"
                     class="author-avatar"
                     loading="eager">
                <div>
                    <div class="author-name">{{ $details->user->name === 'Admin' ? 'Dr. Uzair Yameen' : $details->user->name }}</div>
                    <div class="author-title">Senior Visa Consultant · 5+ Years</div>
                </div>
            </div>

            <div class="meta-item">
                <i class="ri-calendar-line"></i>
                <span>{{ \Carbon\Carbon::parse($details->published_at)->format('F d, Y') }}</span>
            </div>
            @php
                $wordCount = str_word_count(strip_tags($details->content));
                $minutes = ceil($wordCount / 250);
            @endphp
            <div class="meta-item">
                <i class="ri-time-line"></i>
                <span>{{ $minutes }} min read</span>
            </div>

            <div class="meta-item">
                <i class="ri-eye-line"></i>
                <span>2.5k views</span>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="container">
    <!-- Featured Image - Fixed Aspect Ratio -->
    <div class="featured-image-wrapper">
        <img src="http://localhost:8000{{ $details->featured_image }}" alt="{{ $details->slug }}-image" class="featured-image" loading="lazy" fetchpriority="high">
    </div>

    <!-- Content Grid -->
    <div class="content-wrapper">
        <!-- Main Blog Content -->
        <article class="blog-content">
            {!! $details->content !!}

            <!-- Author Box -->
            {{-- <div class="author-box">
                <div class="author-box-content">
                    <img src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                         alt="Dr. Rajesh Kumar"
                         class="author-box-avatar"
                         loading="lazy">
                    <div class="author-box-info">
                        <h4>Dr. Rajesh Kumar</h4>
                        <p>PhD in International Education | Senior Visa Consultant with 12+ years experience. Helped 15,000+ students get their visas approved. Featured in Times of India, The Hindu for expert views on study abroad.</p>
                        <div class="author-social">
                            <a href="#"><i class="ri-linkedin-fill"></i></a>
                            <a href="#"><i class="ri-twitter-x-fill"></i></a>
                            <a href="#"><i class="ri-mail-fill"></i></a>
                            <a href="#"><i class="ri-whatsapp-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- Comment Form -->
            <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: var(--card-shadow); " class="custom-accordion">
                <h4 style="margin-bottom: 40px;">FAQs related to {{ $details->title }}</h4>
                @forelse ($details->faqs as $key => $faq)
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
                                <p>{!! $faq->answer !!}</p>
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

            <!-- Comment Form -->
            <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: var(--card-shadow); margin-top: 40px;">
                <h4 style="margin-bottom: 20px;">Have a Question? Ask Our Expert</h4>
                <form id="blogForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Your Name *">
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Your Email *">
                        </div>
                        <div class="col-12">
                            <textarea class="form-control" name="question" rows="4" placeholder="Your Question *"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-submit">Submit Question →</button>
                        </div>
                    </div>
                </form>
            </div>
        </article>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Quick Consultation Widget -->
            <div class="widget">
                <h4 class="widget-title">
                    <i class="ri-customer-service-line"></i> Free Consultation
                </h4>
                @include('include.form', ['layout' => 'narrow'])
                <p style="font-size: 0.8rem; color: var(--gray); margin-top: 12px; text-align: center;">
                    <i class="ri-lock-line"></i> 100% Privacy Guaranteed
                </p>
            </div>

            <!-- Top Countries by Visa Rate -->
            {{-- <div class="widget">
                <h4 class="widget-title">
                    <i class="ri-flight-takeoff-line"></i> Top Visa Rate Countries
                </h4>
                <ul class="category-list">
                    <li>
                        <a href="#">Germany</a>
                        <span class="category-count">92%</span>
                    </li>
                    <li>
                        <a href="#">Ireland</a>
                        <span class="category-count">90%</span>
                    </li>
                    <li>
                        <a href="#">Canada (SDS)</a>
                        <span class="category-count">88%</span>
                    </li>
                    <li>
                        <a href="#">Australia</a>
                        <span class="category-count">87%</span>
                    </li>
                    <li>
                        <a href="#">New Zealand</a>
                        <span class="category-count">86%</span>
                    </li>
                    <li>
                        <a href="#">UK</a>
                        <span class="category-count">82%</span>
                    </li>
                </ul>
            </div> --}}

            <!-- Download Guide -->
            {{-- <div class="widget" style="background: var(--primary-light);">
                <h4 class="widget-title" style="border-bottom-color: var(--primary-green);">
                    <i class="ri-file-pdf-line"></i> Free Visa Guide
                </h4>
                <p style="margin-bottom: 16px;">Download our comprehensive visa guide with SOP samples and document checklist.</p>
                <a href="#" class="btn-submit" style="text-align: center; display: block; text-decoration: none;">Download PDF →</a>
            </div> --}}

            <!-- Tags -->
            <div class="widget">
                <h4 class="widget-title">
                    <i class="ri-price-tag-line"></i> Popular Tags
                </h4>
                <div class="tags-cloud">
                    @foreach ($details->tags as $tag)
                        <a href="#" class="tag">{{ ucwords($tag->name) }}</a>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>

    <!-- Related Articles -->
    <h3 style="margin: 60px 0 30px;">📚 More Articles You'll Love</h3>

    @if (count($relatedPosts) > 0)
        <div class="related-grid">
            @foreach ($relatedPosts as $related)
            <a href="#" class="related-card">
                <img src="http://localhost:8000{{ $related->thumbnail }}" alt="SOP Guide" loading="lazy">
                <div class="related-content">
                    <h5>{{ $related->title }}</h5>
                    <small>{{ \Carbon\Carbon::parse($related->published_at)->format('F d, Y') }}</small>
                </div>
            </a>
            @endforeach
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
                Our team is actively working in this area! Stay Tuned.</span>
            </div>
        </div>

    @endif
</section>
@endsection

@section('scripts')
<script>
$(function(){

    $(document).on('submit', '#blogForm', function(e){
        e.preventDefault();

        let form = $(this);
        let button = form.find('.btn-submit');

        $.ajax({
            url: '/post/question',
            method: 'POST',
            headers:{
                'X-CSRF-TOKEN' : '{{ csrf_token() }}'
            },
            data : form.serialize() + '&post_id={{ $details->id }}',
            beforeSend:function(){
                button.prop('disabled', true)
                      .html('<i class="ri-loader-4-line ri-spin"></i> Submitting Question');
            },

            success:function(res){
                iziToast.success({
                    title: 'Success',
                    message: res.message,
                    position: 'topRight',
                    timeout: 3000
                });

                form.trigger('reset');

                button.prop('disabled', false)
                      .html('Submit Question →');
            },

            error:function(xhr){

                button.prop('disabled', false)
                      .html('Submit Question →');

                if(xhr.responseJSON && xhr.responseJSON.errors){

                    $.each(xhr.responseJSON.errors, function(key, value){
                        iziToast.error({
                            title: 'Error',
                            message: value[0],
                            position: 'topRight'
                        });
                    });

                } else {

                    iziToast.error({
                        title: 'Error',
                        message: 'Your Question contains inappropriate words',
                        position: 'topRight'
                    });

                }
            }
        });

    });

});
</script>
@endsection