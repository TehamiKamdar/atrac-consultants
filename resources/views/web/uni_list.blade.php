@extends('layouts.web_layout')

@push('title')
    Universities | {{ $countryName }}
@endpush

@section('styles')
    <style>
        .search-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--nav-shadow);
            padding: 1rem;
            margin-bottom: 2rem;
            font-family: 'Bambino-Regular', sans-serif;
        }

        .search-input {
            border: 2px solid var(--primary-light);
            border-radius: 8px;
            padding: 0.75rem;
            transition: var(--transition);
            font-family: 'Bambino-Regular', sans-serif;
        }

        .search-input:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.25rem rgba(43, 182, 115, 0.25);
        }

        .university-card {
            background: white;
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            margin-bottom: 1rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            border-left: 4px solid var(--university-accent);
            font-family: 'Bambino-Regular', sans-serif;
        }

        .university-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-hover-shadow);
            border-left-color: var(--primary-green);
        }

        .university-logo-container {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-right: 1.5rem;
            overflow: hidden;
        }

        .university-logo {
            width: 70%;
            height: 70%;
            object-fit: contain;
        }

        .university-info {
            flex-grow: 1;
        }

        .university-name {
            color: var(--dark-text);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-family: 'Bambino-Bold', sans-serif;
            font-size: 1.4rem;
        }

        .university-url {
            color: var(--primary-green);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 0.5rem;
            word-break: break-all;
            font-family: 'Bambino-Light', sans-serif;
        }

        .university-url:hover {
            text-decoration: underline;
        }

        .university-location {
            color: var(--gray);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Bambino-Regular', sans-serif;
        }

        .view-btn {
            background-color: var(--primary-green);
            color: white;
            border-radius: 6px;
            padding: 0.75rem 1.5rem;
            border: none;
            transition: var(--transition);
            font-weight: 500;
            white-space: nowrap;
            margin-left: auto;
            text-decoration: none;
            font-family: 'Bambino-Regular', sans-serif;
            letter-spacing: 0.5px;
        }

        .view-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: var(--gray);
            font-family: 'Bambino-Regular', sans-serif;
        }

        @media (max-width: 768px) {
            .university-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 1.25rem;
            }

            .university-logo-container {
                margin-right: 0;
                margin-bottom: 1rem;
                width: 60px;
                height: 60px;
            }

            .view-btn {
                margin-left: 0;
                margin-top: 1rem;
                width: 100%;
            }

            .university-name {
                font-size: 1.1rem;
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
    <main class="container-fluid py-4">
        <!-- Search Section -->
        <div class="search-container">
            <div class="row align-items-center">
                <div class="col-md-12 mb-3 mb-md-0">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="ri-search-line"></i>
                        </span>
                        <input type="text" class="form-control search-input border-start-0"
                            placeholder="Search universities...">
                    </div>
                </div>
            </div>
        </div>

        <!-- University List -->
        <div id="university-list">
            @if ($universities->count() > 0)
                @foreach ($universities as $uni)
                    <div class="university-card">
                        <div class="university-logo-container">
                            @if (!empty($uni->image))
                                <img src="{{ $uni->image }}" alt="{{$uni->name}}" class="img-fluid mx-auto"
                                    style="max-height: 100px; width: auto;">
                            @else
                                <img src="{{ asset('website/favicon.svg')}}" alt="{{$uni->name}}" class="img-fluid mx-auto"
                                    style="max-height: 100px; width: auto;">
                            @endif
                        </div>
                        <div class="university-info">
                            <h4 class="university-name">{{ $uni->name }}</h4>
                            <a href="{{ $uni->website }}" class="university-url" target="_blank">{{ $uni->website }}</a>
                            <p class="university-location">
                                <i class="ri-map-pin-line"></i> {{ ucfirst($uni->cityName) }}, {{ ucfirst($uni->stateName) }}
                            </p>
                        </div>
                        <a href="{{ route('university.details', [$uni->countryslug, $uni->slug]) }}" class="view-btn">
                            View University <i class="ri-arrow-right-line ms-2"></i>
                        </a>
                    </div>
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
                        We are gathering our insights on the universities based in <span id="country-name">{{$countryName}}!
                            Stay Tuned.</span>
                    </div>
                </div>

            @endif
        </div>

        <!-- No Results State (hidden by default) -->
        <div class="no-results d-none" id="no-results">
            <i class="ri-search-off-line display-4 mb-3"></i>
            <h4>No universities found</h4>
            <p class="mb-0">Try adjusting your search or filters</p>
        </div>
    </main>
@endsection