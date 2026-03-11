@extends('layouts.web_layout')

@section('styles')
<style>

    :root {
            --primary-color: #2BB673;
            --secondary-color: #1E8449;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        body{
            font-family: 'Bambino-Regular', Arial, Helvetica, sans-serif;
        }
    /* Hero Section */
        .blog-header {
            background: linear-gradient(0deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            padding: 80px 0;
            margin-bottom: 60px;
            text-align: center;
        }

        .blog-header h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .blog-header p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 800px;
            margin: 0 auto;
        }

        .btn-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            padding: 10px 25px !important;
            font-weight: 600 !important;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color) !important;
            border-color: var(--secondary-color) !important;
        }

        /* Blog Post Card */
        .blog-card {
            border: none !important;
            border-radius: 8px !important;
            overflow: hidden !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05) !important;
            margin-bottom: 30px !important;
            transition: transform 0.3s ease !important;
        }

        .blog-card:hover {
            transform: translateY(-5px) !important;
        }

        .blog-img {
            height: 100% !important;
            object-fit: cover !important;
            width: 100% !important;
        }

        .card-body {
            padding: 25px !important;
        }

        .blog-title {
            font-size: 1.8rem !important;
            margin-bottom: 15px !important;
            color: var(--dark-color) !important;
        }

        .blog-title a {
            color: inherit !important;
            text-decoration: none !important;
        }

        .blog-title a:hover {
            color: var(--primary-color) !important;
        }

        .blog-meta {
            color: #6c757d !important;
            margin-bottom: 15px !important;
            font-size: 0.9rem !important;
        }

        .blog-meta i {
            margin-right: 5px !important;
            color: var(--primary-color) !important;
        }

        .blog-excerpt {
            margin-bottom: 20px !important;
            color: #495057 !important;
        }

        .read-more {
            color: var(--primary-color) !important;
            font-weight: 600 !important;
            text-decoration: none !important;
        }

        .read-more:hover {
            color: var(--secondary-color)!important;
            text-decoration: underline!important;
        }

        /* Featured Post */
        .featured-post {
            border-left: 4px solid var(--primary-color)!important;
            background-color: var(--light-color)!important;
            padding: 20px!important;
            margin-bottom: 30px!important;
        }

        /* Pagination */
        .page-item.active .page-link {
            background-color: var(--primary-color)!important;
            border-color: var(--primary-color)!important;
        }

        .page-link {
            color: var(--primary-color) !important;
        }

</style>
@endsection

@section('content')
<!-- Hero Section -->
    <header class="blog-header">
        <div class="container">
            <h1>Study Abroad Insights & Guides</h1>
            <p>Explore expert articles on university admissions, student visas, scholarships, and everything you need to kickstart your international education journey.</p>
        </div>
    </header>

<main class="container">
        <!-- Featured Post -->
        {{-- <div class="row">
            <div class="col-lg-12">
                <div class="featured-post">
                    <h2>Featured Post</h2>
                    <h3><a href="#">The Future of Sustainable Energy in Urban Areas</a></h3>
                    <div class="blog-meta">
                        <span><i class="far fa-calendar-alt"></i> June 15, 2023</span>
                        <span class="ms-3"><i class="far fa-user"></i> By Sarah Johnson</span>
                        <span class="ms-3"><i class="far fa-folder"></i> Sustainability</span>
                    </div>
                    <p class="blog-excerpt">Exploring how cities around the world are transitioning to renewable energy sources and the impact this will have on urban living in the coming decades...</p>
                    <a href="#" class="read-more">Continue Reading <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div> --}}

        <!-- Blog Posts -->
        <div class="row">
            <!-- Post 1 -->
            @foreach ($blogs as $blog)
                <div class="col-md-6 col-lg-4">
                    <div class="card blog-card">
                        <img src="http://localhost:8000{{ $blog->thumbnail }}" class="card-img-top blog-img" alt="Blog Post Image">
                        <div class="card-body">
                            <h3 class="blog-title"><a href="{{ $blog->url }}">{{ $blog->title }}</a></h3>
                            <div class="blog-meta">
                                <span><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($blog->published_at)->format('F d, Y') }}</span>
                                <span class="ms-2"><i class="far fa-user"></i> By {{ $blog->user->name }}</span>
                            </div>
                            <p class="blog-excerpt">{{ $blog->excerpt }}</p>
                            <a href="{{ $blog->url }}" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <nav aria-label="Blog pagination" class="my-5">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </main>
@endsection