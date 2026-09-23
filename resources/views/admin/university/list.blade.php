@extends('layouts.admin_layout')
@section('title')
University List for {{ $countryName }}
@endsection

@section('styles')
    <style>
        .university-card {
            background: var(--dark-card);
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
            transition: var(--transition);
            border: none;
            padding: 1.5rem;
            height: 100%;
        }

        .university-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .university-logo-container {
            width: 100%;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: var(--primary-light);
            border-radius: 8px;
        }

        .university-logo {
            max-height: 80px;
            max-width: 100%;
            object-fit: contain;
        }

        .university-name {
            font-weight: 700;
            color: var(--dark-green);
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
            height: 3rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .university-meta {
            color: var(--dark-gray);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .university-meta i {
            margin-right: 0.5rem;
            color: var(--primary-green);
        }

        .established-badge {
            background-color: var(--primary-light);
            color: var(--dark-green);
            font-weight: 500;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <a href="{{ route('admin-university-create', $id) }}" class="mb-4 btn btn-primary btn-sm">Add University</a>
        @if ($universities->count() > 0)
            <div class="row">
                @foreach ($universities as $uni)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="university-card h-100">
                            <div class="university-logo-container">
                                <img src="https://placehold.co/300x60/transparent/FFF?font=poppins&text={{ $uni->name }}" alt="{{ $uni->name }} logo"
                                    class="university-logo">
                            </div>
                            {{-- <span class="established-badge">
                                <i class="ri-calendar-line"></i> Est. 1636
                            </span> --}}
                            <div class="university-meta">
                                <div class="mb-2">
                                    <i class="ri-map-pin-line"></i> {{ ucfirst($uni->city) }}
                                </div>
                                <div>
                                    <i class="ri-global-line"></i>
                                    <a href="{{ $uni->website }}" target="_blank">{{ $uni->website }}</a>
                                </div>
                            </div>
                            <a href="{{route('admin-university-edit', $uni->id)}}" class="btn btn-info">
                                View Details <i class="ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h4 class="text-center">No University List Found, Try Adding Some</h4>
        @endif
    </div>
@endsection