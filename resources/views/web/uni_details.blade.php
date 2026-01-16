@extends('layouts.web_layout')
@push('title')
    {{ $university->meta_title }}
@endpush
<style>
    body {
        font-family: 'Bambino-Regular', Arial, Helvetica, sans-serif !important;
    }

    .university-header h1 {
        font-family: 'Bambino-Bold', sans-serif;
    }

    .university-description {
        font-family: 'Bambino-Regular', sans-serif;
    }

    .accordion-button {
        background-color: rgba(43, 182, 115, 0.1);
        font-family: 'Bambino-Regular', sans-serif;
        color: #2BB673;
    }

    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(43, 182, 115, 0.25);
        font-family: 'Bambino-Regular', sans-serif;
        border-color: #2BB673;
    }

    .nav-tabs .nav-link {
        color: #495057;
        font-family: 'Bambino-Regular', sans-serif;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: #2BB673;
    }

    .nav-tabs .nav-link.active {
        color: #2BB673;
        border-bottom: 3px solid #2BB673;
        font-family: 'Bambino-Bold', sans-serif;
        font-weight: 500;
    }

    .list-group-item a {
        text-decoration: none;
        color: #2BB673;
    }

    .list-group-item a:hover {
        text-decoration: underline;
        color: #208152;
    }
</style>
@section('content')
    <div class="university-details container-fluid py-4">
        <div class="row g-4">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <!-- University Header -->
                <div class="university-header bg-white p-4 rounded-3 shadow-sm mb-4">
                    <h1 class="display-5 fw-bold text-primary mb-3">
                        <i class="ri-building-2-line me-2"></i>About {{$university->name}}
                    </h1>
                    <div class="university-description fs-5 text-muted">
                        {!! $university->meta_description !!}
                        <br>
                        <br>
                        {!! $university->description !!}
                    </div>
                </div>

                <div class="d-flex align-items-center text-muted mb-3">
                    <i class="ri-question-line me-2"></i>
                    <small style="font-family: 'Bambino-Thin', sans-serif; letter-spacing: 0.5;">Select a program to view
                        available courses</small>
                </div>

                @php
                    $programTabs = [
                        'associate' => ['id' => 'associate', 'label' => "Associate Degree", 'icon' => 'ri-graduation-cap-line'],
                        'bachelors' => ['id' => 'bachelors', 'label' => "Bachelor's", 'icon' => 'ri-book-2-line'],
                        'masters' => ['id' => 'master', 'label' => "Master's", 'icon' => 'ri-medal-line'],
                        'phd' => ['id' => 'phd', 'label' => "PhD", 'icon' => 'ri-user-star-line'],
                    ];

                @endphp

                <div class="programs-tabs bg-white rounded-3 shadow-sm">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs nav-justified" id="programsTab" role="tablist">
                        @foreach ($programTabs as $level => $tab)
                            @if (!empty($programsByLevel[$level]) && $programsByLevel[$level]->isNotEmpty())
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link {{ $loop->first ? 'active' : '' }} d-flex align-items-center justify-content-center"
                                        id="{{ $tab['id'] }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $tab['id'] }}"
                                        type="button" role="tab">
                                        <i class="{{ $tab['icon'] }} me-2"></i> {{ $tab['label'] }}
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content p-4" id="programsTabContent">
                        @foreach ($programTabs as $level => $tab)
                            @if (!empty($programsByLevel[$level]) && $programsByLevel[$level]->isNotEmpty())
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tab['id'] }}"
                                    role="tabpanel">
                                    <div class="accordion" id="{{ $tab['id'] }}Accordion">
                                        @foreach ($programsByLevel[$level] as $program)
                                            @foreach ($program->departments as $deptIndex => $department)
                                                <div class="accordion-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
                                                    <h2 class="accordion-header bg-light">
                                                        <button
                                                            class="accordion-button d-flex align-items-center {{ $deptIndex !== 0 ? 'collapsed' : '' }}"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#{{ $tab['id'] }}Collapse{{ $loop->parent->index }}{{ $deptIndex }}">
                                                            <i class="ri-community-line me-3 text-primary"></i>
                                                            <span class="fw-bold">Department Of {{ $department->name }}</span>
                                                        </button>
                                                    </h2>
                                                    <div id="{{ $tab['id'] }}Collapse{{ $loop->parent->index }}{{ $deptIndex }}"
                                                        class="accordion-collapse collapse {{ $deptIndex === 0 ? 'show' : '' }}"
                                                        data-bs-parent="#{{ $tab['id'] }}Accordion">
                                                        <div class="accordion-body p-0">
                                                            <ul class="list-group list-group-flush">
                                                                @foreach ($department->courses as $course)
                                                                    <li class="list-group-item d-flex align-items-center py-3">
                                                                        <i class="ri-bookmark-line text-muted me-3"></i>
                                                                        {{ $course->name }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Sidebar Area -->
            <div class="col-lg-4">
                <!-- Quick Facts Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header text-white" style="background-color: #2BB673;">
                        <h3 class="mb-0 d-flex align-items-center" style="font-family: 'Bambino-Bold', sans-serif">
                            <i class="ri-information-line fs-4 me-2"></i> Quick Links
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="ri-map-pin-line fs-5 text-primary me-3"></i>
                                <div>
                                    <strong>Location:</strong>
                                    <span class="d-block">{{ ucfirst($city) . ', ' . ucfirst($state) }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="ri-global-line fs-5 text-primary me-3"></i>
                                <div>
                                    <strong>Website:</strong>
                                    <a href="{{ $university->website ?? '#' }}" target="_blank"
                                        class="d-block">{{ $university->website ?? 'N/A' }}</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header text-white" style="background-color: #2BB673;">
                        <h3 class="mb-0 d-flex align-items-center" style="font-family: 'Bambino-Bold', sans-serif">
                            <i class="ri-contacts-line me-2 fs-4"></i> Contact
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="ri-mail-line fs-5 text-primary me-3"></i>
                                <div>
                                    <strong>Email:</strong>
                                    <span class="d-block"><a
                                            href="https://mail.google.com/mail/?view=cm&to=apply@atracconsultants.com&su=Inquiry%20About%20{{$university->name}}&body={{ urlencode("Hey there!, I want some details about {$university->name}. I would like to here from you ASAP.") }}"
                                            target="_blank">apply@atracconsultants.com</a></span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="ri-phone-line fs-5 text-primary me-3"></i>
                                <div>
                                    <strong>Phone:</strong>
                                    <span class="d-block">+92 335 3737904</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center justify-content-center mt-2">
                                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                    data-bs-target="#applyNowModal">
                                    Apply Now
                                </button>
                                <div class="modal fade" id="applyNowModal" tabindex="-1"
                                    aria-labelledby="applyNowModalLabel" aria-hidden="true">
                                    <div class="modal-xl modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white" id="applyNowModalLabel">Apply Now</h5>
                                                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @include('include.form', ['layout' => 'modal'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        const tabButtons = document.querySelectorAll(".tab-btn");
        const tabContents = document.querySelectorAll(".tab-content");

        tabButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                const target = btn.getAttribute("data-tab");

                tabContents.forEach(content => content.classList.add("hidden"));
                document.getElementById(target).classList.remove("hidden");

                tabButtons.forEach(b => {
                    b.classList.remove("tab-active");
                });

                btn.classList.add("tab-active");
            });
        });
    </script>
@endsection