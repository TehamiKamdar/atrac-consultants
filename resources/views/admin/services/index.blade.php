@extends('layouts.admin_main')
@section('main-section')

    @if (session('active'))
        <div class="alert alert-success">
            {{session('active')}}
        </div>
    @endif

    @if (session('inactive'))
        <div class="alert alert-danger">
            {{session('inactive')}}
        </div>
    @endif

        <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add New Service
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{route('services-store')}}" method="post">
                @csrf
                <div class="form-group ">
                    <input type="text" name="service_icon" class="form-control" placeholder="icon-class">
                </div>
                <div class="form-group my-3">
                    <input type="text" name="service_heading" class="form-control" placeholder="service heading">
                </div>
                <div class="form-group">
                    <input placeholder="service details" type="text" name="service_details" class="form-control">
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
            </div>

        </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th>Service Icon</th>
                    <th>Service Heading</th>
                    <th>Service Details</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $s)
                    <tr>
                        <td><i class="{{$s->service_icon}}" style="text-align: center; width:100%; font-size:20px;"></i></td>
                        <td>{{$s->service_heading}}</td>
                        <td>{{$s->service_details}}</td>
                        <td><a href="" class="btn-primary">Update</a></td>
                        <td>
                            @if ($s->status=='inactive')
                            <form action="{{ route('services-active', $s->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Inactive</button>
                            </form>
                            @else
                            <form action="{{ route('services-inactive', $s->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Active</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection