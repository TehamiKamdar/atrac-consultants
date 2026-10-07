@extends('layouts.student_layout')

@section('title', 'Application Details')

@section('content')

    <div class="row g-3">
        @forelse($applications as $application)

        @php
            $detail = $application->details->first();

            $status = strtolower($detail->status ?? 'applied');

            $statusConfig = match ($status) {

                'applied' => [
                    'label' => 'Applied',
                    'class' => 'status-applied',
                    'icon'  => 'ri-send-plane-line',
                ],

                'under-evaluation' => [
                    'label' => 'Under Evaluation',
                    'class' => 'status-warning',
                    'icon'  => 'ri-search-eye-line',
                ],

                'offer-received' => [
                    'label' => 'Offer Received',
                    'class' => 'status-offer',
                    'icon'  => 'ri-mail-check-line',
                ],

                'acceptance-applied' => [
                    'label' => 'Acceptance Applied',
                    'class' => 'status-warning',
                    'icon'  => 'ri-file-edit-line',
                ],

                'acceptance-received' => [
                    'label' => 'Acceptance Received',
                    'class' => 'status-acceptance',
                    'icon'  => 'ri-checkbox-circle-line',
                ],

                'pre-enrollment-applied' => [
                    'label' => 'Pre-Enrollment Applied',
                    'class' => 'status-warning',
                    'icon'  => 'ri-file-list-3-line',
                ],

                'pre-enrollment-received' => [
                    'label' => 'Pre-Enrollment Received',
                    'class' => 'status-pre-enrollment',
                    'icon'  => 'ri-file-list-3-line',
                ],

                'visa-file-preparation' => [
                    'label' => 'Visa File Preparation',
                    'class' => 'status-visa',
                    'icon'  => 'ri-passport-line',
                ],

                'scholarship-application-done' => [
                    'label' => 'Scholarship Application Done',
                    'class' => 'status-scholarship',
                    'icon'  => 'ri-award-line',
                ],

                'application-rejected' => [
                    'label' => 'Application Rejected',
                    'class' => 'status-rejected',
                    'icon'  => 'ri-close-circle-line',
                ],

                default => [
                    'label' => ucwords(str_replace('-', ' ', $status)),
                    'class' => 'status-applied',
                    'icon'  => 'ri-time-line',
                ],
            };
        @endphp


        <div class="col-md-4 col-12">
            <div class="application-card {{ $statusConfig['class'] }}">

            {{-- =========================
                CARD HEADER
            ========================== --}}
            <div class="application-card-header">

                <div class="application-title">

                    <div>

                        <h5 class="application-university mb-0">
                            {{ $application->university->name }}
                        </h5>
                    </div>

                </div>


                {{-- Status --}}
                <div class="application-status">

                    <i class="{{ $statusConfig['icon'] }}"></i>

                    <span>
                        {{ $statusConfig['label'] }}
                    </span>

                </div>

            </div>


            {{-- =========================
                CARD BODY
            ========================== --}}
            <div class="application-card-body">

                <div class="application-info-grid">


                    {{-- Country --}}
                    <div class="application-info">

                        <div class="info-label">
                            <i class="ri-global-line"></i>
                            Country
                        </div>

                        <div class="info-value">
                            {{ $application->country->name }}
                        </div>

                    </div>


                    {{-- University --}}
                    <div class="application-info">

                        <div class="info-label">
                            <i class="ri-building-line"></i>
                            University
                        </div>

                        <div class="info-value">
                            {{ $application->university->name }}
                        </div>

                    </div>


                    {{-- Departments --}}
                    <div class="application-info">

                        <div class="info-label">
                            <i class="ri-node-tree"></i>
                            Department
                        </div>

                        <div class="info-value tag-list">

                            @if(is_array($application->department_id))

                                @foreach($application->departments as $department)

                                    <span class="application-tag">
                                        {{ $department->name }}
                                    </span>

                                @endforeach

                            @elseif($application->department_id)

                                <span class="application-tag">
                                    #{{ $application->department_id }}
                                </span>

                            @else

                                <span class="text-muted">
                                    Not specified
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- Courses --}}
                    <div class="application-info application-courses">

                        <div class="info-label">
                            <i class="ri-book-open-line"></i>
                            Courses
                        </div>

                        <div class="course-list">

                            @if(is_array($application->course_name))

                                @foreach($application->course_name as $course)

                                    <span class="course-tag">
                                        {{ $course }}
                                    </span>

                                @endforeach

                            @elseif($application->course_name)

                                <span class="course-tag">
                                    {{ $application->course_name }}
                                </span>

                            @else

                                <span class="text-muted">
                                    No course specified
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================
                CARD FOOTER
            ========================== --}}
            <div class="application-card-footer">

                <div class="application-meta">

                    <i class="ri-file-list-3-line"></i>

                    <span>
                        Application #{{ $loop->iteration }}
                    </span>

                </div>


                <div class="application-meta">

                    <i class="ri-calendar-line"></i>

                    <span>
                        {{ $application->created_at->format('d M Y') }}
                    </span>

                </div>

            </div>

        </div>
        </div>

    @empty

        {{-- Empty State --}}
        <div class="empty-applications">

            <div class="empty-icon">
                <i class="ri-file-list-3-line"></i>
            </div>

            <h5>
                No Applications Found
            </h5>

            <p>
                You don't have any student applications yet.
            </p>

        </div>

    @endforelse
    </div>

@endsection