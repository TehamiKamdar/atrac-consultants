@extends('layouts.admin_layout')

@section('title', 'Blogs List')

@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin-blogs-create') }}" class="btn btn-sm btn-primary">Create New Blog</a>
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
                    <tr>
                        <td>1</td>
                        <td>Countries tha offers 100% Scholarships in Study</td>
                        <td>countries-that-offers-100%-scholarships-in-study</td>
                        <td>21 Mar 2026</td>
                        <td>200</td>
                        <td><a href="" class="btn btn-sm btn-update"><i class="ri-external-link-line"></i></a></td>
                        <td><a href="" class="btn btn-sm btn-info me-2"><i class="ri-pencil-line"></i></a><a href="" class="btn btn-sm btn-danger"><i class="ri-delete-bin-2-line"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection