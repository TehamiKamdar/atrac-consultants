@extends('layouts.admin_main')

@section('main-section')
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consults as $con)
                    <tr class="">
                        <td>{{$con->id}}</td>
                        <td>{{$con->name}}</td>
                        <td>{{$con->phone}}</td>
                        <td>{{$con->email}}</td>
                        <td><a href="{{route('admin-consult-details', $con->id)}}" class="btn btn-primary">Details</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

@endsection
