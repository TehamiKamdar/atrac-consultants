@extends('layouts.admin_layout')
@section('content')


    {{-- <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add New Details
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" name="service_icon" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="service_heading" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="service_details" class="form-control">
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> --}}
    <div class="container-fluid py-4">
        <div class="table-responsive">
            <table class="table table-dark-custom table-hover table-primary">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $d)
                        <tr>
                            <td>{{\Illuminate\Support\Str::words($d->name, 50)}}</td>
                            <td>
                                <a class="btn btn-sm btn-update" href="{{ route('admin-country-details-edit', $d->country_id) }}" class="btn btn-sm btn-update">
                                    Update
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection