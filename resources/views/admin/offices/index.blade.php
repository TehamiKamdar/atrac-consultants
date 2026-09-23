@extends('layouts.admin_layout')

@section('title', 'Offices')

@section('styles')
<style>

        select.form-control option {
            color: #000 !important;
        }
        .form-control[disabled] {
            background-color: #696969 !important;
            color: #000 !important;
            cursor: not-allowed;
        }
</style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createNewOfficeModal">
                    Add New
                </button>
            </div>

            <div style="max-width: 500px;">
                <div class="input-group" data-bs-theme="dark">
                    <input type="text" id="studentSearch" class="form-control form-control-sm py-0 bg-dark" placeholder="Search office...">
                    <button class="btn btn-sm btn-outline-secondary" type="button">
                        <i class="ri-search-line"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-dark-custom table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Map</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($offices as $key => $office)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ ucfirst($office->city->name) }}</td>
                            <td>{{ $office->phone }}</td>
                            <td>{{ $office->address }}</td>
                            <td>
                                <a href="{{ $office->map_location }}" target="_blank" class="btn btn-sm btn-primary">
                                    View on Maps
                                </a>
                            </td>
                            <td>
                                <button title="Edit Details" class="btn btn-sm btn-update edit-btn" data-id="{{ $office->id }}"
                                    data-city="{{ $office->city }}" data-phone="{{ $office->phone }}"
                                    data-address="{{ $office->address }}" data-map="{{ $office->map_location }}"
                                    data-bs-toggle="modal" data-bs-target="#editOfficeModal">
                                    <i class="ri-edit-line"></i>
                                </button>

                                <button title="Delete" class="btn btn-sm btn-danger delete-btn" data-id="{{ $office->id }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteOfficeModal">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>

                                <button title="Status: {{ $office->status ? 'Active' : 'Inactive' }}" class="btn btn-sm {{ $office->status ? 'btn-primary' : 'btn-danger' }} status-btn" data-id="{{ $office->id }}" data-status="{{ $office->status }}">
                                    <i class="ri-{{ $office->status ? 'check' : 'close' }}-line"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Create Modal -->
    <div class="modal fade" id="createNewOfficeModal" data-bs-theme="dark" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New Office</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="officeForm">
                    <div class="modal-body">
                        <select name="country_id" class="form-control form-control-sm mb-3" id="country">
                            <option selected disabled>Select Country..</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <select name="state_id" id="state" class="form-control form-control-sm mb-3" disabled>

                        </select>
                        <select name="city_id" id="city" class="form-control form-control-sm mb-3" disabled>

                        </select>
                        <input type="text" name="phone" class="form-control form-control-sm mb-3"
                            placeholder="Phone: +92 xxx xxxxxxx">
                        <input type="text" name="address" class="form-control form-control-sm mb-3" placeholder="Address">
                        <textarea name="map_location" class="form-control form-control-sm mb-3"
                            placeholder="Map Location (URL)" rows="6"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary add-btn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Edit Modal --}}
    <div class="modal fade" id="editOfficeModal" data-bs-theme="dark" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5">Edit Office</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="editOfficeForm">
                    <div class="modal-body">

                        <input type="hidden" name="id">

                        <input type="text" name="phone" class="form-control form-control-sm mb-3" placeholder="Phone: +92 xxx xxxxxxx">

                        <input type="text" name="address" class="form-control form-control-sm mb-3" placeholder="Address">

                        <textarea name="map_location" class="form-control form-control-sm mb-3"
                            placeholder="Map Location (URL)" rows="6"></textarea>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-sm btn-update update-btn">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- Delete Modal --}}
    <div class="modal fade" id="deleteOfficeModal" data-bs-theme="dark" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5">Delete Office</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>
                        Are you sure you want to delete this office? Changes will also impact the main website.
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" class="btn btn-sm btn-danger confirm-delete-btn">
                        Confirm Delete
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* ----------------------------------------
       Helper: Show Validation Errors
    ---------------------------------------- */
    function showValidationErrors(xhr) {

        if (xhr.status === 422) {

            let errors = xhr.responseJSON.errors;
            let errorMessage = '';

            $.each(errors, function (key, value) {
                errorMessage += value[0] + '<br>';
            });

            iziToast.error({
                title: 'Validation Error',
                message: errorMessage,
                position: 'topRight'
            });

        } else {
            iziToast.error({
                title: 'Error',
                message: 'Something went wrong!',
                position: 'topRight'
            });
        }
    }
    $('#state').html('<option value="">Select country first..</option>');
    $('#city').html('<option value="">Select state first..</option>');

    /* ----------------------------------------
       POPULATING STATES
    ---------------------------------------- */
    $(document).on('change', '#country', function(){
        let countryId = $(this).val();
        console.log(countryId);

        $.ajax({
            url:'/get-states/' + countryId,
            method:'GET',
            beforeSend:function(){
                $('#state').html('<option value="">Loading...</option>');
            },
            success:function(res){
                let options = $('#state').prop('disabled', false).html('<option value="">Select State...</option>')

                res.forEach(function(state){
                    options += `<option value="${state.id}">${state.name}</option>`;
                })

                $("#state").html(options);
            },
            error:function(){
                $('#state').html('<option value="">Error Occured. Try selecting again</option>');
            }
        })
    })
    /* ----------------------------------------
       POPULATING CITIES
    ---------------------------------------- */
    $(document).on('change', '#state', function(){
        let stateId = $(this).val();
        console.log(stateId);

        $.ajax({
            url:'/get-cities/' + stateId,
            method:'GET',
            beforeSend:function(){
                $('#city').html('<option value="">Loading...</option>');
            },
            success:function(res){
                let options = $('#city').prop('disabled', false).html('<option value="">Select City...</option>')

                res.forEach(function(city){
                    options += `<option value="${city.id}">${toTitleCase(city.name)}</option>`;
                })

                $("#city").html(options);
            },
            error:function(){
                $('#city').html('<option value="">Error Occured. Try selecting again</option>');
            }
        })
    })
    /* ----------------------------------------
       CREATE OFFICE
    ---------------------------------------- */
    $(document).on('submit', '#officeForm', function (e) {

        e.preventDefault();

        let form = $(this);
        let button = form.find('.add-btn');

        $.ajax({
            url: '/offices/store',
            method: 'POST',
            data: form.serialize(),

            beforeSend: function () {
                button.prop('disabled', true)
                      .html('<i class="ri-loader-4-line ri-spin"></i> Adding');
            },

            success: function (res) {

                iziToast.success({
                    title: 'Success',
                    message: res.message ?? 'Office Location Added',
                    position: 'topRight'
                });

                setTimeout(() => location.reload(), 1500);
            },

            error: function (xhr) {
                showValidationErrors(xhr);
                button.prop('disabled', false).text('Add');
            }
        });
    });

    /* ----------------------------------------
       OPEN EDIT MODAL (NO AJAX)
    ---------------------------------------- */
    $(document).on('click', '.edit-btn', function () {

        let modal = $('#editOfficeModal');

        modal.find('[name="id"]').val($(this).data('id'));
        modal.find('[name="phone"]').val($(this).data('phone'));
        modal.find('[name="address"]').val($(this).data('address'));
        modal.find('[name="map_location"]').val($(this).data('map'));

    });

    /* ----------------------------------------
       UPDATE OFFICE
    ---------------------------------------- */
    $(document).on('submit', '#editOfficeForm', function (e) {

        e.preventDefault();

        let form = $(this);
        let button = form.find('.update-btn');

        $.ajax({
            url: '/offices/update',
            method: 'POST',
            data: form.serialize(),

            beforeSend: function () {
                button.prop('disabled', true).html('<i class="ri-loader-4-line ri-spin"></i> Updating');
            },

            success: function (res) {

                iziToast.success({
                    title: 'Success',
                    message: res.message ?? 'Office Location Updated',
                    position: 'topRight'
                });

                setTimeout(() => location.reload(), 1500);
            },

            error: function (xhr) {
                showValidationErrors(xhr);
                button.prop('disabled', false).text('Update');
            }
        });
    });

    /* ----------------------------------------
       DELETE PREPARE
    ---------------------------------------- */
    let deleteId = null;

    $(document).on('click', '.delete-btn', function () {
        deleteId = $(this).data('id');
    });

    /* ----------------------------------------
       DELETE CONFIRM
    ---------------------------------------- */
    $(document).on('click', '.confirm-delete-btn', function () {

        let button = $(this);

        if (!deleteId) return;

        $.ajax({
            url: '/offices/destroy',
            method: 'POST',
            data: { id: deleteId },

            beforeSend: function () {
                button.prop('disabled', true)
                      .html('<i class="ri-loader-4-line ri-spin"></i> Deleting');
            },

            success: function (res) {

                iziToast.success({
                    title: 'Success',
                    message: res.message ?? 'Office Location Deleted',
                    position: 'topRight'
                });

                setTimeout(() => location.reload(), 1500);
            },

            error: function (xhr) {
                showValidationErrors(xhr);
                button.prop('disabled', false).text('Confirm Delete');
            }
        });

    });

    $(document).on('click', '.status-btn', function(){
        let button = $(this);
        let id = button.data('id')
        let status = button.data('status');
        // console.log('Current status is: '+status);
        let statusToUpdate = status ? '0' : '1';
        // console.log('New Status will be: '+statusToUpdate);

        $.ajax({
            url: '/offices/status',
            method: 'POST',
            data:{
                id: id,
                status : status ? '0' : '1'
            },
            beforeSend:function(){
                button.prop('disabled', true).html('<i class="ri-loader-4-line ri-spin"></i>');
            },
            success:function(res){

                iziToast.success({
                    title: 'Success',
                    message: res.message ?? 'Office Status Updated',
                    position: 'topRight'
                });

                setTimeout(() => location.reload(), 1500);
            },
            error:function(xhr){

                showValidationErrors(xhr);
                button.prop('disabled', false).html(`<i class="ri-${status ? 'check' : 'close'}-line"></i>`);
            }
        })
    })
});
</script>
@endsection