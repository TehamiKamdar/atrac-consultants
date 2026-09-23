@extends('layouts.admin_layout')

@section('title', "Create New Blog")
@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <style>
        /* Your dark theme overrides must come AFTER default Choices.css */
        .choices {
            background-color: #ffffff0d !important;
            color: #f5f5f5 !important;
            border: 1px solid #ffffff1a !important;
            border-radius: 0.75rem;
        }

        .choices__inner {
            background-color: #ffffff0d !important;
            border: 1px solid #ffffff1a !important;
            border-radius: 0.75rem;
        }

        .choices__list--multiple .choices__item {
            background-color: #444 !important;
            color: #f5f5f5 !important;
            border-radius: 4px !important;
            margin-right: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .choices__list--dropdown {
            background-color: #2a2a2a !important;
            border: 1px solid #444 !important;
            color: #f5f5f5 !important;
        }

        .choices__list--dropdown .choices__item--selectable {
            color: #f5f5f5 !important;
        }

        .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background-color: #555 !important;
            color: #fff !important;
        }

        .choices__input {
            background-color: #2a2a2a !important;
            color: #f5f5f5 !important;
            border: none !important;
        }

        textarea.form-control,
        input.form-control,
        select.form-control {
            background-color: #ffffff0d !important;
            color: #fff !important;
        }

        select.form-control option {
            color: #000 !important;
        }

        .form-control[disabled] {
            background-color: #696969 !important;
            color: #000 !important;
            cursor: not-allowed;
        }

        input[disabled] {
            background-color: #696969 !important;
            color: #000 !important;
            cursor: not-allowed;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid" data-bs-theme="dark">
        <div class="row justify-content-center">

            <form action="{{ route('admin-blogs-store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card bg-dark border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom">
                        <small class="text-muted">Add blog content, SEO details & publish settings</small>
                    </div>

                    <div class="card-body">

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Blog Title</label>
                            <input type="text" name="title" id="title" class="form-control bg-secondary text-light border-0" placeholder="Enter blog title" required>
                        </div>

                        <!-- Content -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea name="content" id="content" class="form-control bg-secondary text-light" rows="10" required></textarea>
                        </div>

                        <!-- Featured Image -->
                        <div class="mb-3">
                            <label for="featured_image" class="form-label">Featured Image</label>
                            <input type="file" name="featured_image" id="featured_image" class="form-control bg-secondary text-light border-0" accept="image/*" required>
                            <img id="featuredPreview" src="#" class="img-fluid mt-2 rounded d-none" style="max-height: 200px;">
                        </div>

                        <!-- Categories -->
                        <div class="mb-3">
                            <label for="categories" class="form-label">Categories</label>
                            <select name="categories[]" id="categories" class="form-select bg-secondary text-light border-0" multiple required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Keywords / Tags -->
                        <div class="mb-3">
                            <label class="form-label">Keywords / Tags</label>
                            <input type="text" name="keywords" class="form-control" placeholder="study abroad, uk visa, education consultant">
                            <small class="text-muted">Use comma(,) for each seperate keywords</small>
                        </div>

                        <!-- Meta Title -->
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control bg-secondary text-light border-0" placeholder="SEO Meta Title">
                        </div>

                        <!-- Meta Description -->
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" class="form-control bg-secondary text-light" rows="3" placeholder="SEO Meta Description"></textarea>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control bg-secondary text-light border-0" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-top d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary px-4">Save Blog</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        const categoriesSelect = document.getElementById('categories');
        const choices = new Choices(categoriesSelect, {
            removeItemButton: true,    // show x to remove selection
            maxItemCount: 10,
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false,
        });
    </script>
@endsection