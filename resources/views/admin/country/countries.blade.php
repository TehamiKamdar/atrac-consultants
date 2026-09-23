@extends('layouts.admin_layout')

@section('content')
    <div class="container-fluid">
        @if (session('active'))
            <div class="alert alert-success alert-dismissible fade show" data-bs-theme="dark" role="alert">
                {{ session('active') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('update'))
            <div class="alert alert-success alert-dismissible fade show" data-bs-theme="dark" role="alert">
                {{ session('update') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('inactive'))
            <div class="alert alert-danger alert-dismissible fade show" data-bs-theme="dark" role="alert">
                {{ session('inactive') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @section('title')
        Countries
        @endsection

        <div class="table-responsive">
            <table class="table table-dark-custom table-hover">
                <thead>
                    <tr>
                        <th>Country Name</th>
                        <th>Country Image</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($countries as $c)
                        <tr>
                            <td>{{$c->name}}</td>
                            <td>
                                @if ($c->name == 'North Cyprus')
                                    <img src="{{ asset('admin/images/north_cyprus.png') }}" height="28" width="32"
                                        alt="{{$c->name}} Image">
                                @else
                                    <img src="https://flagsapi.com/{{ $c->iso2 }}/flat/64.png" height="32" alt="{{$c->name}} Image">
                                @endif
                            </td>
                            <td>
                                @if ($c->status == 'inactive')
                                    <form action="{{ route('country-active', $c->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Inactive</button>
                                    </form>
                                @else
                                    <form action="{{ route('country-inactive', $c->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Active</button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if ($c->status == 'active')
                                    <a href="{{ route('admin-country-details-edit', $c->id) }}"
                                        class="btn btn-sm btn-secondary">Edit Details</a>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="modalUpdate" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdate">Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('country-update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <input type="text" id="name_" name="name_" placeholder="Name" class="form-control mt-3">

                        <img id="country_image_preview" src="" alt="Country Image"
                            style="max-width: 100%; margin-top: 10px; display: none;">

                        <input type="file" name="image_" id="" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function () {
        $('.open-modal-update').click(function () {
            var id = $(this).attr('data-id');
            console.log(id);
            $.ajax({
                url: 'countries/get-countries/' + id,
                method: 'GET',
                success: function (response) {
                    $('#modalUpdate').modal('show');
                    $('#id').val(response.id);
                    $('#name_').val(response.country_name || 'Error Fetching Record');
                    $('#country_image_preview').val(response.country_image || 'Error Fetching Image');

                    // Set the image source dynamically
                    if (response.country_image) {
                        $('#country_image_preview').attr('src', '../../../images/country/' + response.country_image).show();
                    } else {
                        $('#country_image_preview').hide();
                    }
                },
                error: function () {
                    console.log('Error Fetching Data');
                }
            })
        })
    })
</script>