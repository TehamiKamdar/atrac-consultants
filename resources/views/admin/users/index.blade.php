@extends('layouts.admin_layout')

@section('title', 'Staff List')

@section('styles')
<style>

        select.form-control option {
            color: #000 !important;
        }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createNewUserModal">
                Add New
            </button>
        </div>

        <div style="max-width: 500px;">
            <div class="input-group" data-bs-theme="dark">
                <input type="text" id="studentSearch" class="form-control form-control-sm py-0 bg-dark" placeholder="Search user...">
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Office</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->city }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    <!-- Create Modal -->
    <div class="modal fade" id="createNewUserModal" data-bs-theme="dark" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="userForm">
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control form-control-sm mb-3" placeholder="Name">
                        <input type="email" name="email" class="form-control form-control-sm mb-3" placeholder="Email">
                        <input type="text" name="password" class="form-control form-control-sm mb-3" placeholder="Password">
                        <input type="text" name="username" class="form-control form-control-sm mb-3" placeholder="Username">
                        <select name="office" class="form-control form-control-sm">
                            <option value="">Select Office</option>
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}">{{ $office->city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary add-btn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

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

    /* ----------------------------------------
       CREATE USER
    ---------------------------------------- */
    $(document).on('submit', '#userForm', function(e){
        e.preventDefault();

        let form = $(this);
        let button = form.find('.add-btn');

        $.ajax({
            url:'/users/create',
            method:'POST',
            data:form.serialize(),

            beforeSend:function(){
                button.prop('disabled', true).html('<i class="ri-loader-4-line ri-spin"></i> Adding')
            },
            success:function(res){

                iziToast.success({
                    title: 'Success',
                    message: res.message ?? 'Office Location Added',
                    position: 'topRight'
                });

                setTimeout(() => location.reload(), 1500);
            },
            error:function(xhr){
                showValidationErrors(xhr);
                button.prop('disabled', false).text('Add');
            }
        })
    })
})
</script>
@endsection