@extends('layouts.student_layout')

@section('title')
    Profile
@endsection

@section('content')
    <section class="section active" id="profile">
        <div class="card p-head">
            <div class="avatar">
                {{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->last_name, 0, 1)) }}
            </div>
            <div class="meta">
                <h2>{{ $student->first_name . ' ' . $student->last_name }}</h2>
                <div class="muted">{{ $student->email }}</div>
                <div class="bar"><i style="width:85%"></i></div>
                <div class="muted" style="margin-top:6px;font-size:11px">Profile 85% complete</div>
            </div>
            <svg class="ill" viewBox="0 0 120 100" style="width:110px;height:92px">
                <use href="#ill-profile" />
            </svg>
        </div>
        <div class="card">
            <form id="profileForm">
                <div class="form-grid">
                    <div class="field">
                        <label>First Name</label>
                        <input class="profile-field" data-original="{{ $student->first_name }}" id="first_name"
                            value="{{ $student->first_name }}">
                    </div>
                    <div class="field">
                        <label>Last Name</label>
                        <input class="profile-field" data-original="{{ $student->last_name }}" id="last_name"
                            value="{{ $student->last_name }}">
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <input class="profile-field" data-original="{{ $student->email }}" id="email" type="email"
                            value="{{ $student->email }}">
                        <div id="email-error" class="invalid-feedback">
                            Email Already Exists.
                        </div>
                    </div>
                    <div class="field">
                        <label>Father's Name</label>
                        <input class="profile-field" data-original="{{ $student->father_name }}" id="father_name"
                            value="{{ $student->father_name }}">
                    </div>
                    <div class="field">
                        <label>Mother's Name</label>
                        <input class="profile-field" data-original="{{ $student->mother_name }}" id="mother_name"
                            value="{{ $student->mother_name }}">
                    </div>
                    <div class="field">
                        <label>City</label>
                        <input class="profile-field" data-original="{{ $student->city }}" id="city"
                            value="{{ $student->city }}">
                    </div>
                    <div class="field">
                        <label>Phone</label>
                        <input class="profile-field" data-original="{{ $student->phone }}" id="phoneNumber"
                            value="{{ $student->phone }}">
                        <div id="phone-error" class="invalid-feedback"></div>
                    </div>
                    <div class="field">
                        <label>Date of Birth</label>
                        <input class="profile-field" data-original="{{ $student->dob }}" id="dob" type="date"
                            value="{{ $student->dob }}">
                    </div>
                    <div class="field">
                        <label>NIC Number</label>
                        <input class="profile-field" data-original="{{ $student->cnic }}" id="cnic"
                            value="{{ $student->cnic }}">
                        <div class="invalid-feedback" id="cnic-error">
                            CNIC Number Already Exists.
                        </div>
                    </div>
                    <div class="field">
                        <label>Passport Number</label>
                        <input class="profile-field" data-original="{{ $student->passport_number }}" id="passport"
                            value="{{ $student->passport_number }}">
                        <div id="passport-error" class="invalid-feedback"></div>
                    </div>
                    <div class="field">
                        <label>Passport Valid From</label>
                        <input class="profile-field" data-original="{{ $student->passport_valid_from }}"
                            id="passport_valid_from" type="date" value="{{ $student->passport_valid_from }}">
                    </div>
                    <div class="field">
                        <label>Passport Valid Thru</label>
                        <input class="profile-field" data-original="{{ $student->passport_valid_thru }}"
                            id="passport_valid_thru" type="date" value="{{ $student->passport_valid_thru }}">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn primary">Save changes</button>
                    <small>*Edited field will be highlighted green</small>
                    <span class="save-msg" id="saveMsg">Saved
                    </span>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/student-validation.js') }}"></script>
    <script>
        $(document).ready(function() {
            initStudentValidation({{ $student->id }})

            $(document).on('input change', '.profile-field', function () {

                let originalValue = $(this).attr('data-original');
                let currentValue = $(this).val();

                if (currentValue !== originalValue) {
                    $(this).addClass('is-changed');
                } else {
                    $(this).removeClass('is-changed');
                }

            });

            $('#profileForm').on('submit', function (e) {
                e.preventDefault();

                let form = $(this);
                let button = form.find('button[type="submit"]');

                button.prop('disabled', true).text('Saving...');

                // Remove old validation
                $('.profile-field').removeClass('is-invalid');
                $('.invalid-feedback').hide();

                let data = {
                    _token: '{{ csrf_token() }}',

                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val(),
                    email: $('#email').val(),
                    father_name: $('#father_name').val(),
                    mother_name: $('#mother_name').val(),
                    city: $('#city').val(),
                    phone: $('#phoneNumber').val(),
                    dob: $('#dob').val(),
                    cnic: $('#cnic').val(),
                    passport: $('#passport').val(),
                    passport_valid_from: $('#passport_valid_from').val(),
                    passport_valid_thru: $('#passport_valid_thru').val()
                };

                $.ajax({
                    url: '{{ route("student.profile.update") }}',
                    type: 'POST',
                    data: data,

                    success: function (response) {

                        // Highlight only changed fields
                        $('.profile-field').each(function () {

                            let original = $(this).attr('data-original') || '';
                            let current = $(this).val() || '';

                            if (original != current) {
                                $(this).addClass('is-changed');
                            }

                            // Update original value
                            $(this).attr('data-original', current);
                        });

                        $('#saveMsg').addClass('show');

                        setTimeout(function () {
                            $('#saveMsg').removeClass('show');
                        }, 3000);

                        button.prop('disabled', false).text('Save changes');
                    },

                    error: function (xhr) {

                        button.prop('disabled', false).text('Save changes');

                        if (xhr.status === 422) {

                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function (field, messages) {

                                let inputId = field;

                                // phone ka actual ID phoneNumber hai
                                if (field === 'phone') {
                                    inputId = 'phoneNumber';
                                }

                                // passport ka actual ID passport hai
                                if (field === 'passport') {
                                    inputId = 'passport';
                                }

                                $('#' + inputId).addClass('is-invalid');

                                $('#' + field + '-error')
                                    .text(messages[0])
                                    .show();
                            });

                        } else {
                            alert('Something went wrong. Please try again.');
                        }
                    }
                });
            });
        })

    </script>
@endsection