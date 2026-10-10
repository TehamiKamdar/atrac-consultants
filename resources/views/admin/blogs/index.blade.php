@extends('layouts.admin_layout')

@section('title', 'Blogs List')

@section('styles')
<style>
        .alert-sm{
            padding: 0.15rem 0.5rem;
            padding-right: 2rem;
            font-size: 0.875rem;
        }
        .alert-dismissible .btn-close {
            padding: 0.3rem;
        }
</style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex gap-3">
            <div>
                <a href="{{ route('admin-blogs-create') }}" class="btn btn-sm btn-primary">Create New Blog</a>
            </div>
            @include('include.alert')
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-dark-custom table-primary table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Published Date</th>
                        <th>Views</th>
                        <th>Visit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $blog)
                        <tr>
                            <td>{{ $blog->id }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->slug }}</td>
                            <td>{{ $blog->created_at->format('Y-m-d') }}</td>
                            <td>{{ $blog->views }}</td>
                            <td>
                                @if ($blog->is_published)
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-sm btn-info">View</a>
                                    <button type="button" class="btn btn-sm btn-primary copy-blog-link" data-url="{{ route('blog.show', $blog->slug) }}">
                                        <i class="ri-link"></i> Copy Link
                                    </button>
                                    {{-- <span class="btn btn-sm btn-info">View</span> --}}
                                @else
                                    <form action="{{ route('admin-blogs-publish', $blog->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Publish</button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin-blogs-edit', $blog->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin-blogs-destroy', $blog->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this blog?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('click', async function (event) {
        const button = event.target.closest('.copy-blog-link');

        if (!button) return;

        const url = new URL(button.dataset.url);

        try {
            await navigator.clipboard.writeText(url.toString());

            const originalText = button.innerHTML;
            button.innerHTML = '<i class="ri-check-line"></i> Copied!';

            setTimeout(() => {
                button.innerHTML = originalText;
            }, 2000);
        } catch (error) {
            prompt('Copy this tracking link:', url.toString());
        }
    });
</script>
@endsection