@extends('layouts.web_layout')
@push('title')
    Details - {{$uniName}}
@endpush
<style>
    .accordion-button:not(.collapsed) {
        background-color: rgba(43, 182, 115, 0.1);
        color: #2BB673;
    }
    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(43, 182, 115, 0.25);
        border-color: #2BB673;
    }
    .nav-tabs .nav-link {
        color: #495057;
        transition: all 0.3s ease;
    }
    .nav-tabs .nav-link:hover {
        color: #2BB673;
    }
    .nav-tabs .nav-link.active {
        color: #2BB673;
        border-bottom: 3px solid #2BB673;
        font-weight: 500;
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
                    <i class="ri-building-2-line me-2"></i>About {{$uniName}}
                </h1>
                <div class="university-description fs-5 text-muted">
                    {!! $university->description !!}
                </div>
            </div>

            <div class="d-flex align-items-center text-muted mb-3">
                <i class="ri-question-line me-2"></i>
                <small>Select a program to view available courses</small>
            </div>

            <!-- Programs Tabs -->
            <div class="programs-tabs bg-white rounded-3 shadow-sm">
                <ul class="nav nav-tabs nav-justified" id="programsTab" role="tablist">
                    @if ($asscdepartments->isNotEmpty())
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active d-flex align-items-center justify-content-center" id="associate-tab" data-bs-toggle="tab" data-bs-target="#associate" type="button" role="tab">
                            <i class="ri-graduation-cap-line me-2"></i> Associate Degree
                        </button>
                    </li>
                    @endif

                    @if ($bachelordepartments->isNotEmpty())
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center justify-content-center" id="bachelor-tab" data-bs-toggle="tab" data-bs-target="#bachelor" type="button" role="tab">
                            <i class="ri-book-2-line me-2"></i> Bachelor's
                        </button>
                    </li>
                    @endif

                    @if ($mastersdepartments->isNotEmpty())
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center justify-content-center" id="master-tab" data-bs-toggle="tab" data-bs-target="#master" type="button" role="tab">
                            <i class="ri-medal-line me-2"></i> Master's
                        </button>
                    </li>
                    @endif

                    @if ($phddepartments->isNotEmpty())
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center justify-content-center" id="phd-tab" data-bs-toggle="tab" data-bs-target="#phd" type="button" role="tab">
                            <i class="ri-user-star-line me-2"></i> PhD
                        </button>
                    </li>
                    @endif
                </ul>

                <div class="tab-content p-4" id="programsTabContent">
                    <!-- Associate Degree Programs -->
                    @if ($asscdepartments->isNotEmpty())
                    <div class="tab-pane fade show active" id="associate" role="tabpanel">
                        <div class="accordion" id="associateAccordion">
                            @foreach ($asscdepartments as $departmentName => $courses)
                            <div class="accordion-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
                                <h2 class="accordion-header bg-light">
                                    <button class="accordion-button d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#associateCollapse{{$loop->index}}">
                                        <i class="ri-community-line me-3 text-primary"></i>
                                        <span class="fw-bold">Department of {{ $departmentName }}</span>
                                    </button>
                                </h2>
                                <div id="associateCollapse{{$loop->index}}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#associateAccordion">
                                    <div class="accordion-body p-0">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($courses as $course)
                                            <li class="list-group-item d-flex align-items-center py-3">
                                                <i class="ri-bookmark-line text-muted me-3"></i>
                                                {{ $course->course_title }}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Bachelor's Programs -->
                    @if ($bachelordepartments->isNotEmpty())
                    <div class="tab-pane fade" id="bachelor" role="tabpanel">
                        <div class="accordion" id="bachelorAccordion">
                            @foreach ($bachelordepartments as $departmentName => $courses)
                            <div class="accordion-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
                                <h2 class="accordion-header bg-light">
                                    <button class="accordion-button d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#bachelorCollapse{{$loop->index}}">
                                        <i class="ri-community-line me-3 text-primary"></i>
                                        <span class="fw-bold">{{ $departmentName }}</span>
                                    </button>
                                </h2>
                                <div id="bachelorCollapse{{$loop->index}}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#bachelorAccordion">
                                    <div class="accordion-body p-0">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($courses as $course)
                                            <li class="list-group-item d-flex align-items-center py-3">
                                                <i class="ri-bookmark-line text-muted me-3"></i>
                                                {{ $course->course_title }}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Master's Programs -->
                    @if ($mastersdepartments->isNotEmpty())
                    <div class="tab-pane fade" id="master" role="tabpanel">
                        <div class="accordion" id="masterAccordion">
                            @foreach ($mastersdepartments as $departmentName => $courses)
                            <div class="accordion-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
                                <h2 class="accordion-header bg-light">
                                    <button class="accordion-button d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#masterCollapse{{$loop->index}}">
                                        <i class="ri-community-line me-3 text-primary"></i>
                                        <span class="fw-bold">{{ $departmentName }}</span>
                                    </button>
                                </h2>
                                <div id="masterCollapse{{$loop->index}}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#masterAccordion">
                                    <div class="accordion-body p-0">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($courses as $course)
                                            <li class="list-group-item d-flex align-items-center py-3">
                                                <i class="ri-bookmark-line text-muted me-3"></i>
                                                {{ $course->course_title }}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- PhD Programs -->
                    @if ($phddepartments->isNotEmpty())
                    <div class="tab-pane fade" id="phd" role="tabpanel">
                        <div class="accordion" id="phdAccordion">
                            @foreach ($phddepartments as $departmentName => $courses)
                            <div class="accordion-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
                                <h2 class="accordion-header bg-light">
                                    <button class="accordion-button d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#phdCollapse{{$loop->index}}">
                                        <i class="ri-community-line me-3 text-primary"></i>
                                        <span class="fw-bold">{{ $departmentName }}</span>
                                    </button>
                                </h2>
                                <div id="phdCollapse{{$loop->index}}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#phdAccordion">
                                    <div class="accordion-body p-0">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($courses as $course)
                                            <li class="list-group-item d-flex align-items-center py-3">
                                                <i class="ri-bookmark-line text-muted me-3"></i>
                                                {{ $course->course_title }}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Area -->
        <div class="col-lg-4">
            <!-- Quick Facts Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0 d-flex align-items-center">
                        <i class="ri-information-line me-2"></i> Quick Facts
                    </h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <i class="ri-map-pin-line text-primary me-3"></i>
                            <div>
                                <strong>Location:</strong>
                                <span class="d-block">{{ $university->location ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="ri-star-line text-primary me-3"></i>
                            <div>
                                <strong>Rating:</strong>
                                <span class="d-block">{{ $university->rating ? $university->rating.'/5' : 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="ri-group-line text-primary me-3"></i>
                            <div>
                                <strong>Students:</strong>
                                <span class="d-block">{{ $university->student_count ? $university->student_count : 'N/A' }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contact Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0 d-flex align-items-center">
                        <i class="ri-contacts-line me-2"></i> Contact
                    </h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <i class="ri-mail-line text-primary me-3"></i>
                            <div>
                                <strong>Email:</strong>
                                <span class="d-block"><a href="https://mail.google.com/mail/?view=cm&to=atracconsultants@gmail.com&su=Inquiry%20About%20{{$uniName}}&body={{ urlencode("Hey there!, I want some details about {$uniName}. I would like to here from you ASAP.") }}" target="_blank">atracconsultants@gmail.com</a></span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="ri-phone-line text-primary me-3"></i>
                            <div>
                                <strong>Phone:</strong>
                                <span class="d-block">+92 335 3737904</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="ri-global-line text-primary me-3"></i>
                            <div>
                                <strong>Website:</strong>
                                <a href="{{ $university->website ?? '#' }}" target="_blank" class="d-block text-decoration-none">{{ $university->website ?? 'N/A' }}</a>
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