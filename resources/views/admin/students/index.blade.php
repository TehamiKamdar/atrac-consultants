@extends('layouts.admin_layout')

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
        td{
            vertical-align: middle;
        }
        .programs-column {
            max-width: 280px;
            white-space: pre-wrap;
        }
    </style>
@endsection

@section('title')
    Students
@endsection

@section('content')
    <div class="container-fluid py-4">

        <!-- Header with Search Box -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a class="btn btn-sm btn-primary" href="https://atracconsultants.com/student/form/ajax">
                    Add New
                </a>
            </div>
            <!-- Search Box on Right -->
            <div style="max-width: 500px;">
                <div class="input-group" data-bs-theme="dark">
                    <input type="text" id="studentSearch" class="form-control form-control-sm bg-dark"
                        placeholder="Search students..." data-bs-theme="dark">
                    <button class="btn btn-sm btn-outline-secondary" type="button">
                        <i class="ri-search-line"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Cards Container -->
        <div class="table">
            <table class="table table-dark-custom table-primary table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="studentsTable">
                    @include('admin.students.partials.table', ['students' => $students])
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="applicationsModal" tabindex="-1" data-bs-theme="dark">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Student Applications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- hidden field to keep student id -->

                    <!-- form (credentials / application details) -->
                    <form id="applicationForm">
                        <input type="hidden" id="student_id">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label for="">Gmail ID:</label>
                                <input type="email" id="gmailId" class="form-control">
                            </div>
                            <div class="col-md-5 position-relative">
                                <label for="">Password</label>
                                <input type="password" id="gmailPassword" class="form-control">
                                <i id="toggleGmailPassword" class="ri-eye-line"
                                    style="position:absolute; right:25px; top:33px; cursor:pointer;"></i>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-success w-100 saveGmailPass">Save</button>
                            </div>

                        </div>
                        <hr>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label>University</label>
                                <select id="universitySelect" class="form-control">
                                    <option value="">Select University</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Programs</label>
                                <input type="text" placeholder="Select University" readonly id="programs"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>User ID</label>
                                <input type="text" id="uniUserId" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>Password</label>
                                <input type="text" id="uniPassword" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>URL</label>
                                <input type="url" id="uniUrl" class="form-control">
                            </div>

                            <div class="col-md-1">
                                <label>Status</label>
                                <select id="status" class="form-control">
                                    <option value="applied">Applied</option>
                                    <option value="under-evaluation">Under Evaluation</option>
                                    <option value="offer-received">Offer Received</option>
                                    <option value="acceptance-applied">Acceptance Applied</option>
                                    <option value="acceptance-received">Acceptance Received</option>
                                    <option value="pre-enrollment-applied">Pre-Enrollment Applied</option>
                                    <option value="pre-enrollment-applied">Pre-Enrollment Applied</option>
                                    <option value="visa-file-preparation">Visa File Preparation</option>
                                    <option value="scholarship-application-done">Scholarship Application Done</option>
                                </select>
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-success w-100">
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- table to show saved data -->
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>University</th>
                                    <th>Programs</th>
                                    <th>User ID</th>
                                    <th>Password</th>
                                    <th>Url</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="applicationsTableBody">
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Loading....
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            /* ===============================
               SEARCH / FILTER STUDENTS
            =============================== */
            $('#studentSearch').on('input', function () {
                let query = $(this).val().toLowerCase();

                $.ajax({
                    url: "{{ route('admin-students-search') }}",
                    data: { q: query },
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function (html) {
                        $('#studentsTable').html(html);
                    },
                    error: function (err) {
                        console.error(err);
                    }
                });
            });


            /* ===============================
               DOWNLOAD PROFILE
            =============================== */
            $(document).on('click', '.profileBtn', function () {
                let id = $(this).data('id');
                let url = `https://atracconsultants.com/generate/student/profile/${id}`;
                window.open(url, '_blank');
            });


            /* ===============================
               DOWNLOAD DOCUMENTS
            =============================== */
            $(document).on('click', '.documentBtn', function () {
                let folderName = $(this).data('folder');
                let url = `https://atracconsultants.com/download/student/documents/${folderName}`;
                window.open(url, '_blank');
            });


            /* ===============================
               DELETE STUDENT + ALL RECORDS
            =============================== */
            $(document).on('click', '.deleteBtn', function () {

                let studentId = $(this).data('id');

                $.ajax({
                    url: `https://atracconsultants.com/api/delete/student/document/${studentId}`,
                    type: 'DELETE',
                    xhrFields: {
                        withCredentials: true // if using cookies/session
                    },
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        iziToast.success({
                            title: 'Deleted',
                            message: res.message ?? 'Student deleted successfully',
                            position: 'topRight'
                        });
                        // 2 second (2000 ms) baad page reload
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    },
                    error: function (xhr) {
                        iziToast.error({
                            title: 'Error',
                            message: xhr.responseJSON?.message ?? 'Deletion failed!',
                            position: 'topRight'
                        });
                    }
                });
            });


            /* ===============================
               CREDENTIALS MODAL
            =============================== */
            const modalEl = $('#applicationsModal');
            const modal = new bootstrap.Modal(modalEl[0]);

            $('#toggleGmailPassword').on('click', function () {
                let input = $('#gmailPassword');
                let type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);

                $(this).toggleClass('ri-eye-line ri-eye-off-line');
            });

            $('#gmailId').val('');
            $('#gmailPassword').val('');


            /* ===============================
               OPEN CREDENTIALS MODAL
            =============================== */
            $(document).on('click', '.credentialsBtn', function () {

                let studentId = $(this).data('id');

                $('#student_id').val(studentId);

                /* --- Load Universities --- */
                $('#universitySelect')
                    .html('<option value="">Loading universities...</option>')
                    .prop('disabled', true);

                $.get(`/students/${studentId}/universities`, function (data) {

                    let options = '<option value="">Select University</option>';

                    if (data.length === 0) {
                        options = '<option value="">No universities found</option>';
                    } else {
                        $.each(data, function (_, uni) {
                            options += `<option value="${uni.id}">${uni.name} - ${uni.country.name}</option>`;
                        });
                    }

                    $('#universitySelect').html(options).prop('disabled', false);
                }).fail(function () {
                    $('#universitySelect').html('<option value="">Error loading universities</option>');
                });

                $('#universitySelect').on('change', function () {

                    let universityId = $(this).val();
                    let programInput = $('#programs');

                    programInput.val('');

                    if (!universityId) {
                        return;
                    }

                    $.get(
                        `/students/${studentId}/university/${universityId}/programs`,
                        function (response) {

                            let programs = response.programs;

                            // Agar JSON string hai to array bana do
                            if (typeof programs === 'string') {
                                try {
                                    programs = JSON.parse(programs);
                                } catch (e) {
                                    console.error('Invalid programs JSON:', programs);
                                    return;
                                }
                            }

                            if (Array.isArray(programs)) {
                                programInput.val(programs.join(', '));
                            }

                        }
                    ).fail(function () {

                        programInput.val('Unable to load programs');

                    });

                });


                /* --- Load Applications --- */
                $.get(`/students/${studentId}/applications`, function (applications) {

                    let tbody = $('#applicationsTableBody');
                    tbody.empty();

                    if (applications.length === 0) {
                        tbody.html('<tr><td colspan="7" class="text-center text-muted">No applications yet</td></tr>');
                    } else {
                        $.each(applications, function (_, app) {
                            tbody.append(`
                            <tr>
                                <td style="width: 250px;">${app.university_name}</td>
                                <td class="programs-column">${app.course_names.join(', ')}</td>
                                <td>${app.uni_user_id ?? ''}</td>
                                <td>${app.uni_user_password ?? ''}</td>
                                <td><a href="${app.uni_url ?? ''}" target="_blank">${app.uni_url ?? '-'}</a></td>
                                <td>
                                    <select class="status-dropdown col-9" data-id="${app.id}">
                                        <option value="applied" ${app.status === 'applied' ? 'selected' : ''}>
                                            Applied
                                        </option>
                                        <option value="under-evaluation" ${app.status === 'under-evaluation' ? 'selected' : ''}>
                                            Under Evaluation
                                        </option>
                                        <option value="offer-received" ${app.status === 'offer-received' ? 'selected' : ''}>
                                            Offer Received
                                        </option>
                                        <option value="acceptance-applied" ${app.status === 'acceptance-applied' ? 'selected' : ''}>
                                            Acceptance Applied
                                        </option>
                                        <option value="acceptance-received" ${app.status === 'acceptance-received' ? 'selected' : ''}>
                                            Acceptance Received
                                        </option>
                                        <option value="pre-enrollment-applied" ${app.status === 'pre-enrollment-applied' ? 'selected' : ''}>
                                            Pre-Enrollment Applied
                                        </option>
                                        <option value="pre-enrollment-applied" ${app.status === 'pre-enrollment-applied' ? 'selected' : ''}>
                                            Pre-Enrollment Applied
                                        </option>
                                        <option value="visa-file-preparation" ${app.status === 'visa-file-preparation' ? 'selected' : ''}>
                                            Visa File Preparation
                                        </option>
                                        <option value="scholarship-application-done" ${app.status === 'scholarship-application-done' ? 'selected' : ''}>
                                            Scholarship Application Done
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <button title="Delete" class="btn btn-sm btn-danger deleteApplicationBtn" data-id="${app.id}" data-bs-target="#deleteApplicationModal" data-bs-toggle="modal"><i class="ri-delete-bin-2-line"></i></button>
                                    <button title="Edit" class="btn btn-sm btn-info editApplicationBtn" data-bs-target="#editApplicationModal" data-bs-toggle="modal" data-id="${app.id}"><i class="ri-pencil-line"></i></button>
                                </td>
                            </tr>
                        `);
                            $('body').append(`
                            <div
                                class="modal fade"
                                id="deleteApplicationModal"
                                data-bs-backdrop="static"
                                tabindex="-1"
                                aria-hidden="true"
                            >
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-dark text-light border-secondary">

                                        <div class="modal-header border-secondary py-2 px-4">
                                            <h5 class="modal-title">Delete Record</h5>

                                            <button
                                                type="button"
                                                class="btn-sm btn-danger py-0 px-1 rounded"
                                                data-bs-dismiss="modal"
                                            >
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </div>

                                        <div class="modal-body py-2 px-4">
                                            <p style="font-size: 14px;">
                                                Are you sure you want to remove this application record?
                                            </p>
                                        </div>

                                        <div class="modal-footer border-secondary">
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                                id="confirmDeleteApplication"
                                            >
                                                <i class="ri-delete-bin-2-line me-2"></i>
                                                Delete
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        `);
                        });
                    }
                }).fail(function () {
                    $('#applicationsTableBody')
                        .html('<tr><td colspan="6" class="text-center text-danger">Error loading applications</td></tr>');
                });


                /* --- Load Gmail Credentials --- */
                $.get(`/students/${studentId}/credentials`, function (data) {
                    $('#gmailId').val(data.secondary_email ?? '');
                    $('#gmailPassword').val(data.secondary_password ?? '');
                });

                modal.show();
            });

            $(document).on('click', '.saveGmailPass', function () {
                let payload = {
                    student_id: $('#student_id').val(),
                    gmail_id: $('#gmailId').val(),
                    gmail_password: $('#gmailPassword').val()
                }

                $.ajax({
                    url: '/students/emailpass/store',
                    method: 'POST',
                    data: JSON.stringify(payload),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    beforeSend: function(){
                        $('.saveGmailPass').text('Saving..').prop("disabled", true);
                    },
                    success: function (data) {

                        iziToast.success({
                            title: 'Success',
                            message: data.message,
                            position: 'topRight'
                        });
                        $('.saveGmailPass').text('Save').prop("disabled", false);

                    },
                    error: function () {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight'
                        });
                        $('.saveGmailPass').text('Save').prop("disabled", false);
                    }
                });
            })


            /* ===============================
               SUBMIT APPLICATION FORM
            =============================== */
            $('#applicationForm').on('submit', function (e) {
                e.preventDefault();

                let payload = {
                    student_application_id: $('#studentApplicationId').val(),
                    student_id: $('#student_id').val(),
                    university_id: $('#universitySelect').val(),
                    uni_user_id: $('#uniUserId').val(),
                    uni_user_password: $('#uniPassword').val(),
                    uni_url: $('#uniUrl').val(),
                    status: $('#status').val(),
                };

                if (!payload.student_id || !payload.university_id) {
                    alert('Student and University are required');
                    return;
                }

                $.ajax({
                    url: '/students/applications/store',
                    method: 'POST',
                    data: JSON.stringify(payload),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function (data) {

                        iziToast.success({
                            title: 'Success',
                            message: data.message,
                            position: 'topRight'
                        });

                        let tbody = $('#applicationsTableBody');

                        if (tbody.find('td[colspan="7"]').length) {
                            tbody.empty();
                        }

                        tbody.append(`
                        <tr>
                            <td style="width: 250px;">${$('#universitySelect option:selected').text()}</td>
                            <td class="programs-column">${$('#programs').val()}</td>
                            <td>${$('#uniUserId').val()}</td>
                            <td>${$('#uniPassword').val()}</td>
                            <td><a href="${$('#uniUrl').val()}" target="_blank">${$('#uniUrl').val() ?? '-'}</a></td>
                            <td>
                                <select class="status-dropdown col-9" data-id="${data.id ?? ''}" disabled>
                                    <option value="applied" ${$('#status').val() === 'applied' ? 'selected' : ''}>
                                        Applied
                                    </option>

                                    <option value="under-evaluation" ${$('#status').val() === 'under-evaluation' ? 'selected' : ''}>
                                        Under Evaluation
                                    </option>

                                    <option value="offer-received" ${$('#status').val() === 'offer-received' ? 'selected' : ''}>
                                        Offer Received
                                    </option>

                                    <option value="acceptance-applied" ${$('#status').val() === 'acceptance-applied' ? 'selected' : ''}>
                                        Acceptance Applied
                                    </option>

                                    <option value="acceptance-received" ${$('#status').val() === 'acceptance-received' ? 'selected' : ''}>
                                        Acceptance Received
                                    </option>

                                    <option value="pre-enrollment-applied" ${$('#status').val() === 'pre-enrollment-applied' ? 'selected' : ''}>
                                        Pre-Enrollment Applied
                                    </option>

                                    <option value="visa-file-preparation" ${$('#status').val() === 'visa-file-preparation' ? 'selected' : ''}>
                                        Visa File Preparation
                                    </option>

                                    <option value="scholarship-application-done" ${$('#status').val() === 'scholarship-application-done' ? 'selected' : ''}>
                                        Scholarship Application Done
                                    </option>
                                </select>
                            </td>
                            <td></td>
                        </tr>
                    `);

                        $('#programs, #uniUserId, #uniPassword, #uniUrl').val('');
                        $('#status').val('applied');
                    },
                    error: function (xhr) {

                        let message = 'Something went wrong!';

                        console.log(xhr);

                        if (xhr.responseJSON?.message) {
                            message = xhr.responseJSON.message;
                        }

                        iziToast.error({
                            title: 'Error',
                            message: message,
                            position: 'topRight'
                        });

                    }
                });
            });

            $(document).on('change', '.status-dropdown', function () {

                let applicationId = $(this).data('id');
                let status = $(this).val();
                let dropdown = $(this);

                $.ajax({
                    url: `/students/applications/${applicationId}/status`,
                    type: 'PUT',
                    data: {
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {

                        console.log(response.message);

                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });

                    },
                    error: function (xhr) {

                        console.log(xhr.responseJSON);

                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight'
                        });

                    }
                });

            });

            let deleteApplicationId = null;

            $(document).on('click', '.deleteApplicationBtn', function () {
                deleteApplicationId = $(this).data('id');
                console.log(`Application ID to be deleted is: ${deleteApplicationId}`)
            });

            $(document).on('click', '#confirmDeleteApplication', function () {
                console.log(`Deleting Application ID: ${deleteApplicationId}`)

                if (!deleteApplicationId) {
                    console.log(`Application ID is: ${deleteApplicationId}`)
                    return;
                }

                $.ajax({
                    url: `/students/applications/${deleteApplicationId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },

                    success: function (response) {

                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });

                        // Modal close
                        $('#deleteApplicationModal').modal('hide');

                        // ID reset
                        deleteApplicationId = null;
                    },

                    error: function (xhr) {

                        iziToast.error({
                            title: 'Error',
                            message: xhr.responseJSON?.message ?? 'Unable to delete application.',
                            position: 'topRight'
                        });

                    }
                });

            });

            $(document).on('click', '.editApplicationBtn', function(){
                let applicationId = $(this).data("id");
                $.ajax({
                    url: '/students/application-details/' + applicationId,
                    method: 'GET',
                    success: function(response){
                        $('#editApplicationId').val(response.data.id);
                        $('#editUserId').val(response.data.uni_user_id);
                        $('#editPassword').val(response.data.uni_user_password);
                        $('#editUrl').val(response.data.uni_url);
                    },
                    error: function(xhr){
                        console.log(xhr.responseJSON);
                    },
                })
            })

            $(document).on('click', '#saveApplicationChanges', function(){
                let applicationId = $('#editApplicationId').val()
                let userId = $('#editUserId').val()
                let password = $('#editPassword').val()
                let url = $('#editUrl').val()
                $.ajax({
                    url: '/students/application-details/update',
                    method:'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data:{
                        id: applicationId,
                        uni_user_id: userId,
                        uni_user_password: password,
                        uni_url: url,
                    },
                    beforeSend: function(){
                        $('#saveApplicationChanges').text('Saving..').prop('disabled', true);
                    },
                    success: function(response){
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });
                        $('#saveApplicationChanges').text('Save Changes').prop('disabled', false);
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('overflow', '');
                        $('#editApplicationModal').hide()
                    },
                    error: function(xhr){
                        console.log(xhr.responseJSON)
                        iziToast.error({
                            title: 'Error',
                            message: xhr.responseJSON,
                            position: 'topRight'
                        });
                        $('#saveApplicationChanges').text('Save Changes').prop('disabled', false);
                    },
                })
            })

        });
    </script>

@endsection