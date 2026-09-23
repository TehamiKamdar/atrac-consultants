@extends('layouts.admin_layout')

@section('styles')
    <style>
        textarea {
            background-color: #363636 !important;
            color: #fff !important;
        }

        input.form-control {
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
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-end align-items-center mb-4">
        @section('title')
            {{ $detail->name }} Details
        @endsection
        <a href="{{ route('admin-country-details') }}" class="btn btn-secondary">
            <i class="ri-arrow-left-line me-1"></i> Back to Countries
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4" data-bs-theme="dark">
        <div class="card-body">
            <form id="editForm" data-bs-theme="dark" class="needs-validation">
                <!-- Country Selection -->
                <div class="mb-4">
                    <input class="form-control" id="country" name="country_id" value="{{ $detail->name }}" required
                        disabled>
                    <input type="hidden" class="form-control" id="country_id" name="_id"
                        value="{{ $detail->country_id }}">
                </div>

                <!-- About Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-dark-header text-white">
                        <h3 class="fw-bold mb-0 d-flex align-items-center">
                            <i class="ri-information-line me-3" style="color: var(--primary-color);"></i>
                            About {{ $detail->country_name }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title (Title for Page (Should be Unique for
                                SEO))</label>
                            <textarea class="form-control" id="meta_title" name="meta_title" rows="3" placeholder="Title for SEO" required>{{ $detail->meta_title }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description (Short Summary (Should be
                                Unique for SEO))</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3"
                                placeholder="Description for SEO" required>{{ $detail->meta_description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="country_description" class="form-label">Detailed Description</label>
                            <textarea class="form-control ck-editor" id="country_description" name="country_description" rows="5"
                                placeholder="Description for Page" required>{!! $detail->country_description !!}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Cost of Living -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-dark-header text-white">
                        <h3 class="fw-bold mb-0 d-flex align-items-center">
                            <i class="ri-money-dollar-circle-line me-3" style="color: var(--primary-color);"></i>
                            Cost of Living
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea class="form-control ck-editor" id="cost_of_living" name="cost_of_living" rows="8"
                                placeholder="Details About Cost Of Living for {{ $detail->name }}" required>{!! $detail->cost_of_living !!}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Climate & Language -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-dark-header text-white">
                        <h3 class="fw-bold mb-0 d-flex align-items-center">
                            <i class="ri-globe-line me-3" style="color: var(--primary-color);"></i>
                            Climate & Language
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="climate" class="form-label">Climate</label>
                            <textarea class="form-control ck-editor" id="climate" name="climate" rows="5"
                                placeholder="Details About Climate Behaviour for {{ $detail->name }}" required>{!! $detail->climate !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="language" class="form-label">Language</label>
                            <textarea class="form-control ck-editor" id="language" name="language" rows="5"
                                placeholder="Details About Language for {{ $detail->name }}" required>{!! $detail->language !!}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Admission Requirements -->
                <div class="card border-0 shadow-sm mb-4">
                    <div
                        class="card-header bg-dark-header text-white d-flex justify-content-between align-items-center">
                        <h3 class="fw-bold mb-0 d-flex align-items-center">
                            <i class="ri-file-list-3-line me-3" style="color: var(--primary-color);"></i>
                            Admission Requirements
                        </h3>
                        <button type="button" class="btn btn-success add-admission-requirement">+</button>
                    </div>

                    <div class="card-body">
                        <div id="admission-requirements-wrapper">
                            @if (!empty($detail->admission_requirements))
                                @foreach ($detail->admission_requirements as $areq)
                                    <div class="input-group mb-2">
                                        <input type="text" name="admission_requirements[]"
                                            value="{!! $areq !!}" class="form-control"
                                            placeholder="Details about Admission Requirements in {{ $detail->name }}">
                                        <button type="button"
                                            class="btn btn-danger remove-admission-requirement">-</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2">
                                    <input type="text" name="admission_requirements[]" class="form-control"
                                        placeholder="Details about Admission Requirements in {{ $detail->name }}">
                                    <button type="button"
                                        class="btn btn-danger remove-admission-requirement">-</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cost of Studying -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-dark-header text-white">
                        <h3 class="fw-bold mb-0 d-flex align-items-center">
                            <i class="ri-money-dollar-box-line me-3" style="color: var(--primary-color);"></i>
                            Cost of Studying
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea class="form-control ck-editor" id="scholarships" name="scholarships" rows="5"
                                placeholder="Details About Scholarships for {{ $detail->name }}" required>{!! $detail->scholarships !!}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Visa Requirements -->
                <div class="card border-0 shadow-sm mb-4">
                    <div
                        class="card-header bg-dark-header text-white d-flex justify-content-between align-items-center">
                        <h3 class="fw-bold mb-0 d-flex align-items-center">
                            <i class="ri-passport-line me-3" style="color: var(--primary-color);"></i>
                            Visa Requirements
                        </h3>
                        <button type="button" class="btn btn-success add-visa-requirement">+</button>

                    </div>
                    <div class="card-body">
                        <div id="visa-requirements-wrapper">
                            @if (!empty($detail->visa_requirements))
                                @foreach ($detail->visa_requirements as $vreq)
                                    <div class="input-group mb-2">
                                        <input type="text" name="visa_requirements[]"
                                            value="{!! $vreq !!}" class="form-control"
                                            placeholder="Details about Visa Requirements in {{ $detail->name }}">
                                        <button type="button"
                                            class="btn btn-danger remove-visa-requirement">-</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2">
                                    <input type="text" name="visa_requirements[]" class="form-control"
                                        placeholder="Details about Visa Requirements in {{ $detail->name }}">
                                    <button type="button" class="btn btn-danger remove-visa-requirement">-</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Work Opportunities -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-dark-header text-white">
                        <h3 class="fw-bold mb-0 d-flex align-items-center">
                            <i class="ri-briefcase-4-line me-3" style="color: var(--primary-color);"></i>
                            Post-Study Work Opportunities
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea class="form-control ck-editor" id="workOpp" name="workOpp" rows="5"
                                placeholder="Details About Work Opportunities in {{ $detail->name }}" required>{!! $detail->workOpp !!}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="d-flex justify-content-end gap-3">
                    <button type="submit" class="btn btn-primary"
                        style="background-color: var(--primary-color); border-color: var(--primary-focus);">
                        <i class="ri-save-line me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        $('.ck-editor').each(function() {

            if ($(this).data('ck-initialized')) return;

            ClassicEditor
                .create(this, {
                    toolbar: [
                        "undo", "redo",
                        "bold", "italic",
                        "bulletedList",
                        "link"
                    ],
                    link: {
                        decorators: {
                            openInNewTab: {
                                mode: 'manual',
                                label: 'Open in New Tab',
                                attributes: {
                                    target: "_blank",
                                    rel: "noopener noreferrer"
                                }
                            }
                        }
                    }
                })
                .then(() => {
                    $(this).data('ck-initialized', true);
                })
                .catch(console.error);

        });

        $(document).on('click', '.add-admission-requirement', function() {
            $('#admission-requirements-wrapper').append(`
                    <div class="input-group mb-2">
                        <input type="text" name="admission_requirements[]" class="form-control" placeholder="Details about Admission Requirements in {{ $detail->name }}">
                        <button type="button" class="btn btn-danger remove-admission-requirement">-</button>
                    </div>
                `);
        });

        // Remove field
        $(document).on('click', '.remove-admission-requirement', function() {
            $(this).closest('.input-group').remove();
        });

        $(document).on('click', '.add-visa-requirement', function() {
            $('#visa-requirements-wrapper').append(`
                    <div class="input-group mb-2">
                        <input type="text" name="visa_requirements[]" class="form-control" placeholder="Details about Visa Requirements in {{ $detail->name }}">
                        <button type="button" class="btn btn-danger remove-visa-requirement">-</button>
                    </div>
                `);
        });

        // Remove field
        $(document).on('click', '.remove-visa-requirement', function() {
            $(this).closest('.input-group').remove();
        });


        // CSRF token globally set
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: '/details/update',
                method: 'POST',
                data: formData,
                success: function(response) {
                    iziToast.success({
                        title: 'Updated',
                        message: response.success || 'Details Updated!',
                        position: 'topRight'
                    });
                },
                error: function(response) {
                    iziToast.error({
                        title: 'Error',
                        message: response.responseJSON?.error ||
                            'Something went wrong!',
                        position: 'topRight'
                    });
                }
            });
        });
    });
</script>
@endsection
