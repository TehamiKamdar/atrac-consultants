@extends('layouts.admin_layout')

@section('title', 'Intakes')

@section('styles')
<style>

        input.form-control,
        select.form-control {
            background-color: #363636 !important;
            color: #fff !important;
        }

        select.status-dropdown {
            background-color: #212529 !important;
            color: #fff !important;
            border: none;
            border-bottom: 1px solid #fff
        }
</style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <button class="btn btn-sm btn-primary" id="new-intake" data-bs-toggle="modal" data-bs-target="#createNewIntakeModal">
                    Add New
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-dark-custom table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($intakes as $intake)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucfirst($intake->name) }}</td>
                            <td>

                                <button title="Status: {{ $intake->is_active ? 'Active' : 'Inactive' }}. Press to {{ $intake->is_active ? 'not display it in forms' : 'display it in forms' }}" class="btn btn-sm {{ $intake->is_active ? 'btn-primary' : 'btn-danger' }} status-btn" data-id="{{ $intake->id }}" data-status="{{ $intake->is_active }}">
                                    {{ $intake->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="createNewIntakeModal" data-bs-theme="dark" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New Intake</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="intakeForm" data-bs-theme="dark">
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control form-control-sm mb-3" placeholder="Spring 29'">
                        
                        <select name="is_active" class="form-select status-dropdown">
                            <option selected disabled>Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
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
        });


        $(document).on('click', '.status-btn', function(){
            let button = $(this);
            let id = button.data('id')
            let status = button.data('status');
            // console.log('Current status is: '+status);
            let statusToUpdate = status ? '0' : '1';
            // console.log('New Status will be: '+statusToUpdate);

            $.ajax({
                url: '/admin/intakes/status',
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
                        message: res.message ?? 'Intake Status Updated',
                        position: 'topRight'
                    });

                    setTimeout(() => location.reload(), 1500);
                },
                error:function(xhr){

                    iziToast.error({
                        title: 'Error',
                        message: xhr.responseJSON,
                        position: 'topRight'
                    });

                    button.prop('disabled', false).html(`${status ? 'Active' : 'Inactive'}`);
                }
            })
        })

        $(document).on('submit', '#intakeForm', function (e) {

            e.preventDefault();

            let form = $(this);
            let button = form.find('.add-btn');

            $.ajax({
                url: '/admin/intakes/store',
                method: 'POST',
                data: form.serialize(),

                beforeSend: function () {
                    button.prop('disabled', true)
                        .html('<i class="ri-loader-4-line ri-spin"></i> Adding');
                },

                success: function (res) {

                    iziToast.success({
                        title: 'Success',
                        message: res.message ?? 'New Intake Added',
                        position: 'topRight'
                    });

                    setTimeout(() => location.reload(), 1500);
                },

                error: function (xhr) {
                    iziToast.error({
                        title: 'Error',
                        message: xhr.responseJSON,
                        position: 'topRight'
                    });
                    
                    button.prop('disabled', false).text('Add');
                }
            });
        });

    })
</script>
@endsection