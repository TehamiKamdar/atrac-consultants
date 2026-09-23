@extends('layouts.admin_layout')

@section('title', "Contact")

@section('content')

<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-dark-custom table-hover table-primary">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Subject</th>
                    <th>City</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $key => $c)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->email }}</td>
                        <td>{{ $c->phone }}</td>
                        <td>{{ $c->subject }}</td>
                        <td>{{ $c->city }}</td>
                        <td>{{ $c->message }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection