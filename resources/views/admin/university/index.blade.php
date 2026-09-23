@extends('layouts.admin_layout')
@section('title')
Universities
@endsection

@section('content')
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-dark-custom table-hover">
            <thead>
                <tr>
                    <th>Country</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $country)
                    <tr>
                        <td>{{$country->name}}</td>
                        <td><a href="{{ route('admin-university-list', $country->id) }}" class="btn btn-sm btn-secondary">View List</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection