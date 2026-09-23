@extends('layouts.admin_layout')
@section('title')
    University Details
@endsection
@section('styles')
    <style>
        textarea {
            background-color: #363636 !important;
            color: #fff !important;
        }

        input.form-control,
        select.form-control {
            background-color: #363636 !important;
            color: #fff !important;
        }

        input[disabled] {
            background-color: #696969 !important;
            color: #000 !important;
            cursor: not-allowed;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <form data-bs-theme="dark" id="universityUpdate" class="needs-validation" novalidate>
            @csrf
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">University Information</h5>
                </div>
                <div class="card-body">
                    <input type="hidden" name="country_id" value="{{ $university->country_id }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">University Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $university->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="slug" class="form-label">URL Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                value="{{ old('slug', $university->slug) }}">
                        </div>

                        <div class="col-12">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title"
                                value="{{ old('meta_title', $university->meta_title) }}">
                        </div>

                        <div class="col-12">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description"
                                rows="2">{{ old('meta_description', $university->meta_description) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">University Description</label>
                            <textarea class="form-control" id="description" name="description"
                                rows="4">{{ old('description', $university->description) }}</textarea>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                {{-- <div class="col-lg-3 col-12">
                                    <label for="state" class="form-label">University State</label>
                                    <select name="state" id="state" class="form-control" required>
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}" {{ old('state', $university->state_id) == $state->id ? 'selected' : '' }}>
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please Select State.</div>
                                </div> --}}

                                <div class="col-lg-6 col-12">
                                    <label for="city" class="form-label">University City</label>
                                    <input type="text" id="city" name="city" class="form-control" value="{{ old('city', $university->city) }}">
                                    {{-- <select name="city" id="city" class="form-control" required>
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city', $university->city_id) == $city->id ? 'selected' : '' }}>
                                                {{ ucfirst($city->name) }}
                                            </option>
                                        @endforeach
                                    </select> --}}
                                    <div class="invalid-feedback">Please Select City.</div>
                                </div>

                                <div class="col-lg-6 col-12">
                                    <label for="website" class="form-label">University Website</label>
                                    <input type="url" name="website" placeholder="Enter University Website URL"
                                        value="{{ old('website', $university->website) }}" id="website"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Programs -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Programs & Departments</h5>
                    <button type="button" class="btn btn-sm btn-secondary" id="add-program">
                        <i class="ri-add-line"></i> Add Program
                    </button>
                </div>
                <div class="card-body" id="programs">
                    @foreach ($university->programs as $pIndex => $program)
                        <div class="program mb-4 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Program #{{ $pIndex + 1 }}</h6>
                                <button type="button" class="btn btn-sm btn-danger remove-program">
                                    <i class="ri-delete-bin-line"></i> Remove
                                </button>
                            </div>

                            <input type="hidden" name="programs[{{ $pIndex }}][id]" value="{{ $program->id }}">

                            <div class="mb-3">
                                <label class="form-label">Program Name</label>
                                <select class="form-control" name="programs[{{ $pIndex }}][program_level_id]" required>
                                    <option value="">-- Select Program --</option>

                                    @foreach($programs as $prog)
                                        <option value="{{ $prog->id }}" {{ old("programs.$pIndex.program_level_id", $program->program_level_id) == $prog->id ? 'selected' : '' }}>
                                            {{ $prog->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Departments -->
                            <div class="departments bg-dark">
                                @foreach ($program->departments as $dIndex => $department)
                                    <div class="department mb-3 p-3 border rounded">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">Department #{{ $dIndex + 1 }}</h6>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-success me-2 add-course">
                                                    <i class="ri-add-line"></i> Course
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger remove-department">
                                                    <i class="ri-delete-bin-line"></i> Remove
                                                </button>
                                            </div>
                                        </div>

                                        <input type="hidden" name="programs[{{ $pIndex }}][departments][{{ $dIndex }}][id]"
                                            value="{{ $department->id }}">

                                        <div class="mb-3">
                                            <label class="form-label">Department Name</label>
                                            <input type="text" class="form-control"
                                                name="programs[{{ $pIndex }}][departments][{{ $dIndex }}][name]"
                                                value="{{ old("programs.$pIndex.departments.$dIndex.name", $department->name) }}"
                                                required>
                                        </div>

                                        <!-- Courses -->
                                        <div class="courses">
                                            @foreach ($department->courses as $cIndex => $course)
                                                <div class="course mb-2">
                                                    <label class="form-label">Course Name</label>
                                                    <div class="input-group">
                                                        <input type="hidden"
                                                            name="programs[{{ $pIndex }}][departments][{{ $dIndex }}][courses][{{ $cIndex }}][id]"
                                                            value="{{ $course->id }}">
                                                        <input type="text" class="form-control"
                                                            name="programs[{{ $pIndex }}][departments][{{ $dIndex }}][courses][{{ $cIndex }}][name]"
                                                            value="{{ old("programs.$pIndex.departments.$dIndex.courses.$cIndex.name", $course->name) }}">
                                                        <button type="button" class="btn btn-danger remove-course">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-sm btn-primary add-department">
                                <i class="ri-add-line"></i> Add Department
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-grid d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="ri-save-line me-2"></i> Update University
                </button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        let countryPrograms = @json($programs);
        $(document).ready(function () {


            /* ===============================
                PROGRAM OPTIONS (DB DRIVEN)
            =============================== */
            function generateProgramOptions(selectedId = '') {
                let html = '<option value="">-- Select Program --</option>';
                countryPrograms.forEach(p => {
                    html += `<option value="${p.id}" ${p.id == selectedId ? 'selected' : ''}>${p.name}</option>`;
                });
                return html;
            }

            /* ===============================
                REINDEX FUNCTION
            =============================== */
            function reindex() {
                $('#programs .program').each(function (pIndex) {

                    // Program heading
                    $(this).find('h6').first().text(`Program #${pIndex + 1}`);

                    // Program select
                    $(this).find('select.program-select')
                        .attr('name', `programs[${pIndex}][program_level_id]`);

                    // Program ID (edit only)
                    $(this).find('input.program-id')
                        .attr('name', `programs[${pIndex}][id]`);

                    // Departments
                    $(this).find('.department').each(function (dIndex) {

                        $(this).find('h6').first().text(`Department #${dIndex + 1}`);

                        $(this).find('input.department-name')
                            .attr('name', `programs[${pIndex}][departments][${dIndex}][name]`);

                        $(this).find('input.department-id')
                            .attr('name', `programs[${pIndex}][departments][${dIndex}][id]`);

                        // Courses
                        $(this).find('.course').each(function (cIndex) {
                            $(this).find('input.course-name')
                                .attr('name', `programs[${pIndex}][departments][${dIndex}][courses][${cIndex}][name]`);

                            $(this).find('input.course-id')
                                .attr('name', `programs[${pIndex}][departments][${dIndex}][courses][${cIndex}][id]`);
                        });
                    });
                });
            }

            /* ===============================
                ADD PROGRAM
            =============================== */
            $('#add-program').on('click', function () {
                $('#programs').append(`
                <div class="program mb-4 p-3 border rounded">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Program</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-program">
                            <i class="ri-delete-bin-line"></i> Remove
                        </button>
                    </div>

                    <select class="form-control mb-3 program-select" required>
                        ${generateProgramOptions()}
                    </select>

                    <div class="departments bg-dark"></div>

                    <button type="button" class="btn btn-sm btn-primary add-department">
                        <i class="ri-add-line"></i> Add Department
                    </button>
                </div>
            `);
                reindex();
            });

            /* ===============================
                REMOVE PROGRAM
            =============================== */
            $(document).on('click', '.remove-program', function () {
                $(this).closest('.program').remove();
                reindex();
            });

            /* ===============================
                ADD DEPARTMENT
            =============================== */
            $(document).on('click', '.add-department', function () {
                $(this).closest('.program').find('.departments').append(`
                <div class="department mb-3 p-3 border rounded">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Department</h6>
                        <div>
                            <button type="button" class="btn btn-sm btn-success me-2 add-course">
                                <i class="ri-add-line"></i> Course
                            </button>
                            <button type="button" class="btn btn-sm btn-danger remove-department">
                                <i class="ri-delete-bin-line"></i> Remove
                            </button>
                        </div>
                    </div>

                    <input type="hidden" class="department-id">
                    <input type="text" class="form-control mb-3 department-name"
                           placeholder="Department Name" required>

                    <div class="courses"></div>
                </div>
            `);
                reindex();
            });

            /* ===============================
                REMOVE DEPARTMENT
            =============================== */
            $(document).on('click', '.remove-department', function () {
                $(this).closest('.department').remove();
                reindex();
            });

            /* ===============================
                ADD COURSE
            =============================== */
            $(document).on('click', '.add-course', function () {
                $(this).closest('.department').find('.courses').append(`
                <div class="course mb-2">
                    <div class="input-group">
                        <input type="hidden" class="course-id">
                        <input type="text" class="form-control course-name"
                               placeholder="Course Name" required>
                        <button type="button" class="btn btn-danger remove-course">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
            `);
                reindex();
            });

            /* ===============================
                REMOVE COURSE
            =============================== */
            $(document).on('click', '.remove-course', function () {
                $(this).closest('.course').remove();
                reindex();
            });

            /* ===============================
                INITIAL PASS (EDIT MODE)
            =============================== */
            $('.program-select').each(function () {
                let selected = $(this).data('selected');
                $(this).html(generateProgramOptions(selected));
            });

            reindex();

        });

        $('#universityUpdate').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            let formData = new FormData(this);
            let submitBtn = form.find("button[type=submit]");

            submitBtn.prop("disabled", true).html('<i class="ri-loader-4-line ri-spin me-2"></i> Updating...');

            $.ajax({
                url: "{{ route('admin-university-update', $university->id) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === "success") {
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });

                        setTimeout(() => {
                            window.location.href = "{{ route('admin-university-edit', $university->id) }}";
                        }, 1500);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                },
                error: function () {
                    iziToast.error({
                        title: 'Error',
                        message: 'Fill all the red highlighted fields',
                        position: 'topRight'
                    });
                },
                complete: function () {
                    submitBtn.prop("disabled", false).html('<i class="ri-save-line me-2"></i> Update University');
                }
            });
        });

    </script>


@endsection