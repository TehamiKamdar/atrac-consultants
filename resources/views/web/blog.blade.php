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
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('https://source.unsplash.com/random/1200x600/?nature,green') no-repeat center center !important;
            background-size: cover !important;
            color: white !important;
            padding: 150px 0 !important;
            margin-bottom: 50px !important;
            text-align: center !important;
            position: relative !important;
        }

        .hero-title {
            font-size: 3.5rem !important;
            font-weight: 700 !important;
            margin-bottom: 20px !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3) !important;
        }

        .hero-subtitle {
            font-size: 1.5rem !important;
            font-weight: 400 !important;
            max-width: 800px !important;
            margin: 0 auto 30px !important;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3) !important;
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
            height: 250px !important;
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
    <header class="hero-section">
        <div class="container">
            <h1 class="hero-title">Welcome to GreenBlog</h1>
            <p class="hero-subtitle">Discover insightful articles on sustainability, eco-living, and green technology</p>
            <a href="#" class="btn btn-primary btn-lg">Start Reading</a>
        </div>
    </header>

<main class="container">
        <!-- Featured Post -->
        <div class="row">
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
        </div>

        <!-- Blog Posts -->
        <div class="row">
            <!-- Post 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card blog-card">
                    <img src="https://source.unsplash.com/random/600x400/?garden" class="card-img-top blog-img" alt="Blog Post Image">
                    <div class="card-body">
                        <h3 class="blog-title"><a href="#">Organic Gardening for Beginners</a></h3>
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i> June 10, 2023</span>
                            <span class="ms-2"><i class="far fa-user"></i> By Michael Green</span>
                        </div>
                        <p class="blog-excerpt">Learn how to start your own organic garden with these simple tips and tricks that will help you grow healthy, pesticide-free vegetables...</p>
                        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Post 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card blog-card">
                    <img src="https://source.unsplash.com/random/600x400/?recycling" class="card-img-top blog-img" alt="Blog Post Image">
                    <div class="card-body">
                        <h3 class="blog-title"><a href="#">The Complete Guide to Home Recycling</a></h3>
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i> June 5, 2023</span>
                            <span class="ms-2"><i class="far fa-user"></i> By Emma Wilson</span>
                        </div>
                        <p class="blog-excerpt">Everything you need to know about setting up an efficient recycling system at home to reduce your environmental footprint and contribute to a circular economy...</p>
                        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Post 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card blog-card">
                    <img src="https://source.unsplash.com/random/600x400/?electric-car" class="card-img-top blog-img" alt="Blog Post Image">
                    <div class="card-body">
                        <h3 class="blog-title"><a href="#">Electric Vehicles: Myths vs Facts</a></h3>
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i> May 28, 2023</span>
                            <span class="ms-2"><i class="far fa-user"></i> By David Chen</span>
                        </div>
                        <p class="blog-excerpt">We debunk the most common misconceptions about electric vehicles and provide factual information to help you make an informed decision about your next car purchase...</p>
                        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
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