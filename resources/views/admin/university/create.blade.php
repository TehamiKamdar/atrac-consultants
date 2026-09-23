@extends('layouts.admin_layout')

@section('title')
University Details
@endsection

@section('styles')
    <style>

        textarea.form-control,
        input.form-control,
        select.form-control {
            background-color: #ffffff0d !important;
            color: #fff !important;
        }
        select.form-control option{
            color: #000 !important;
        }

        .form-control[disabled] {
            background-color: #696969 !important;
            color: #000 !important;
            cursor: not-allowed;
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
        <form data-bs-theme="dark" id="universityStore" method="POST" class="needs-validation" novalidate
            enctype="multipart/form-data">
            @csrf

            <div data-bs-theme="dark" class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">University Information</h5>
                </div>
                <div class="card-body">
                    <!-- Hidden Country ID -->
                    <input type="hidden" name="country_id" value="{{ $id }}" id="country_id">

                    <!-- University Basic Info -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">University Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter university name" required>
                            <div class="invalid-feedback">Please provide a university name.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="slug" class="form-label">URL Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                placeholder="Will be auto-generated for SEO Purpose" readonly>
                            <div class="invalid-feedback">Please provide a university name.</div>
                        </div>

                        <div class="col-12">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title"
                                placeholder="For SEO purposes" required>
                            <div class="invalid-feedback">Please provide Title for University.</div>
                        </div>

                        <div class="col-12">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="2"
                                placeholder="Brief description for SEO Purpose" required></textarea>
                            <div class="invalid-feedback">Please provide Description for University.</div>
                        </div>


                        <div class="col-12">
                            <label for="description" class="form-label">University Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                placeholder="University Description" required></textarea>
                            <div class="invalid-feedback">Please provide Description for University.</div>
                        </div>


                        <div class="col-12">
                            <div class="row">
                                {{-- <div class="col-lg-3 col-12">
                                    <label for="state" class="form-label">University State</label>
                                    <select name="state" id="state" class="form-control" required>
                                        <option value="">Select State</option>
                                    </select>
                                    <div class="invalid-feedback">Please Select State.</div>
                                </div> --}}

                                <div class="col-lg-6 col-12">
                                    <label for="city" class="form-label">University City</label>
                                    <input type="text" name="city" id="city" class="form-control" placeholder="Toronto, Bologna" required>
                                    <div class="invalid-feedback">Please Enter City.</div>
                                </div>
                                {{-- <div class="col-lg-3 col-12">
                                    <label for="city" class="form-label">University City</label>
                                    <select name="city" id="city" class="form-control" disabled required>
                                        <option value="">Select City</option>
                                    </select>
                                    <div class="invalid-feedback">Please Select City.</div>
                                </div> --}}
                                <div class="col-lg-6 col-12">
                                    <label for="website" class="form-label">University Valid URL (Website)</label>
                                    <input type="url" name="website" id="website" class="form-control" required placeholder="https://utoronto.ca">
                                    <div class="invalid-feedback">Valid URL should be like (https://atracconsultants.com).
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="image" class="form-label">University Logo</label>
                            <input type="file" class="form-control" id="image" name="image"
                                accept="image/png, image/jpeg, image/jpg, image/webp">
                        </div>

                        {{-- <div class="col-12">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                placeholder="Comma separated keywords">
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Programs Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Programs & Departments</h5>
                    <button type="button" class="btn btn-sm btn-secondary" id="add-program">
                        <i class="ri-add-line"></i> Add Program
                    </button>
                </div>
                <div class="card-body">
                    <div id="programs">
                        <!-- Initial Program -->
                        <div class="program mb-4 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Program #1</h6>
                                <button type="button" class="btn btn-sm btn-danger remove-program">
                                    <i class="ri-delete-bin-line"></i> Remove
                                </button>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Program Name</label>
                                <select name="programs[0][program_level_id]" id="" class="form-control" required>
                                    <option value="" selected disable>Select Program</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Departments -->
                            <div class="departments bg-dark">
                                <div class="department mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">Department #1</h6>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-success me-2 add-course">
                                                <i class="ri-add-line"></i> Course
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger remove-department">
                                                <i class="ri-delete-bin-line"></i> Remove
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Department Name</label>
                                        <input type="text" class="form-control" name="programs[0][departments][0][name]"
                                            placeholder="e.g. Computer Science" required>
                                        <div class="invalid-feedback">Department Name is mandatory.</div>
                                    </div>

                                    <!-- Courses -->
                                    <div class="courses">
                                        <div class="course mb-2">
                                            <label class="form-label">Course Name</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    name="programs[0][departments][0][courses][0][name]"
                                                    placeholder="e.g. Introduction to Programming" required>
                                                <button type="button" class="btn btn-danger remove-course">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                                <div class="invalid-feedback">Course Name is mandatory.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-sm btn-primary add-department">
                                <i class="ri-add-line"></i> Add Department
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="ri-save-line me-2"></i> Save University
                </button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        document.getElementById('name').addEventListener('input', function () {
            let slug = this.value
                .trim()
                .toLowerCase()
                .replace(/\s+/g, '-')       // replace spaces with hyphens
                .replace(/[^a-z0-9\-]/g, '') // remove special characters
                .replace(/\-+/g, '-');       // collapse multiple hyphens
            document.getElementById('slug').value = slug;
        });

        $(function () {

            let countryId = "{{ $id }}"; // URL se aaya hua

            // 🔹 Prepare dynamic programs JSON from Blade
            let countryPrograms = @json($programs);

            // 🔹 Function to generate program <option>s dynamically
            function generateProgramOptions(selectedId = "") {
                let html = '<option value="">Select Program</option>';
                countryPrograms.forEach(function (p) {
                    html += `<option value="${p.id}" ${p.id == selectedId ? 'selected' : ''}>${p.name}</option>`;
                });
                return html;
            }

            // // 🔹 Load states on page load
            // $.get("/get-states/" + countryId, function (data) {
            //     $("#state").empty().append('<option value="">Select State</option>');
            //     $.each(data, function (i, state) {
            //         $("#state").append('<option value="' + state.id + '">' + state.name + '</option>');
            //     });
            // });

            // // 🔹 On state change, load cities
            // $("#state").on("change", function () {
            //     $('#city').removeAttr('disabled', true);
            //     let stateId = $(this).val();
            //     if (stateId) {
            //         $.get("/get-cities/" + stateId, function (data) {
            //             $("#city").empty().append('<option value="">Select City</option>');
            //             $.each(data, function (i, city) {
            //                 $("#city").append('<option value="' + city.id + '">' + toTitleCase(city.name) + '</option>');
            //             });
            //         });
            //     } else {
            //         $("#city").empty().append('<option value="">Select City</option>');
            //     }
            // });

            // Add Program
            $("#add-program").on("click", function () {
                const $tpl = $("#programs .program:first").clone();

                // keep exactly 1 department, 1 course; clear values
                $tpl.find(".departments .department:not(:first)").remove();
                $tpl.find(".department .courses .course:not(:first)").remove();
                $tpl.find("input, textarea").val("");
                $tpl.find("select").prop("selectedIndex", 0);

                // ✅ Replace static program select with dynamic options
                $tpl.find("select[name*='[program_level_id]']").html(generateProgramOptions());

                $("#programs").append($tpl);
                reindex();
            });

             $("#programs .program:first").find("select[name*='[program_level_id]']").html(generateProgramOptions());

            // Remove Program
            $(document).on("click", ".remove-program", function () {
                if ($("#programs .program").length > 1) {
                    $(this).closest(".program").remove();
                    reindex();
                }
            });

            // Add Department
            $(document).on("click", ".add-department", function () {
                const $prog = $(this).closest(".program");
                const $tpl = $prog.find(".departments .department:first").clone();

                // reset to single empty course
                $tpl.find(".courses .course:not(:first)").remove();
                $tpl.find("input").val("");

                $prog.find(".departments").append($tpl);
                reindex();
            });

            // Remove Department
            $(document).on("click", ".remove-department", function () {
                const $prog = $(this).closest(".program");
                if ($prog.find(".department").length > 1) {
                    $(this).closest(".department").remove();
                    reindex();
                }
            });

            // Add Course
            $(document).on("click", ".add-course", function () {
                const $dept = $(this).closest(".department");
                const $tpl = $dept.find(".courses .course:first").clone();
                $tpl.find("input").val("");
                $dept.find(".courses").append($tpl);
                reindex();
            });

            // Remove Course
            $(document).on("click", ".remove-course", function () {
                const $dept = $(this).closest(".department");
                if ($dept.find(".course").length > 1) {
                    $(this).closest(".course").remove();
                    reindex();
                }
            });

            // ---- Reindex names + headings ----
            function reindex() {
                $("#programs .program").each(function (p) {
                    // heading: Program #x
                    $(this).children(".d-flex").find("h6").text("Program #" + (p + 1));

                    // program name input
                    $(this).find("input[name^='programs'][name$='[program_level_id]']")
                        .attr("name", `programs[${p}][program_level_id]`);

                    // departments
                    $(this).find(".department").each(function (d) {
                        // heading: Department #y
                        $(this).children(".d-flex").find("h6").text("Department #" + (d + 1));

                        // department name
                        $(this).find("input[name^='programs'][name$='[name]']")
                            .attr("name", `programs[${p}][departments][${d}][name]`);

                        // courses
                        $(this).find(".course").each(function (c) {
                            $(this).find("input[name^='programs']")
                                .attr("name", `programs[${p}][departments][${d}][courses][${c}][name]`);
                        });
                    });
                });
            }

            // initial pass (for the first preset block)
            reindex();

        });

        $(document).ready(function () {
            $('#universityStore').on('submit', function (e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);
                let submitBtn = form.find("button[type=submit]");

                // Disable button & show loader
                submitBtn.prop("disabled", true)
                    .html('<i class="ri-loader-4-line ri-spin me-2"></i> Saving...');

                $.ajax({
                    url: "{{ route('admin-university-store') }}",
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

                            // Reset form
                            form.trigger("reset");

                            // Optional redirect after success
                            setTimeout(() => {
                                window.location.href = "{{ route('admin-university-list', $id) }}";
                            }, 1500);

                        } else {
                            // Unexpected warning (server returned non-error but not success)
                            iziToast.warning({
                                title: 'Warning',
                                message: response.message ?? "Unexpected response!",
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
                        // Re-enable button
                        submitBtn.prop("disabled", false)
                            .html('<i class="ri-save-line me-2"></i> Save University');
                    }
                });
            });
        });

    </script>
@endsection