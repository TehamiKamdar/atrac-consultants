@extends('layouts.student_layout')

@section('title', 'Application Details')

@section('styles')
<style>
.applications-wrapper {
    display: flex;
    flex-direction: column;
    gap: 20px;
}


/* ==========================================
   APPLICATION CARD
========================================== */

.application-card {
    --status-color: #6c757d;

    position: relative;
    overflow: hidden;

    background: transparent;

    border: 1px solid color-mix(
        in srgb,
        var(--status-color) 55%,
        transparent
    );

    border-radius: 14px;

    transition:
        border-color 0.25s ease,
        box-shadow 0.25s ease,
        transform 0.25s ease;
}

.application-card:hover {
    border-color: var(--status-color);

    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.18);
}


/* ==========================================
   STATUS COLORS
========================================== */

.status-applied {
    --status-color: #7c7d6c;
}

.status-offer {
    --status-color: #20c997;
}

.status-acceptance {
    --status-color: #198754;
}

.status-pre-enrollment {
    --status-color: #fd7e14;
}

.status-visa {
    --status-color: #0d6efd;
}

.status-scholarship {
    --status-color: #105ff2;
}

.status-warning {
    --status-color: #ffc107;
}

.status-rejected {
    --status-color: #dc3545;
}


/* ==========================================
   HEADER
========================================== */

.application-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    padding: 12px 16px;

    background: color-mix(
        in srgb,
        var(--status-color) 6%,
        transparent
    );

    border-bottom: 1px solid color-mix(
        in srgb,
        var(--status-color) 25%,
        transparent
    );
}


/* ==========================================
   TITLE
========================================== */

.application-title {
    display: flex;
    align-items: center;
    gap: 13px;
}

.application-icon {
    width: 44px;
    height: 44px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    color: var(--status-color);

    background: color-mix(
        in srgb,
        var(--status-color) 12%,
        transparent
    );

    font-size: 21px;
}

.application-label {
    margin-bottom: 3px;

    color: var(--status-color);

    font-size: 10px;
    font-weight: 600;

    text-transform: uppercase;
    letter-spacing: 0.08em;
}

.application-university {
    color: var(--bs-white);

    font-size: 13.8px;
    font-weight: 600;
}


/* ==========================================
   STATUS
========================================== */

.application-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    flex-shrink: 0;
    padding: 3px 8px;
    color: var(--status-color);
    background: color-mix(in srgb, var(--status-color) 10%, transparent);
    border: 1px solid color-mix(in srgb, var(--status-color) 30%, transparent);
    border-radius: 12px;
    font-size: 10.6px;
    font-weight: 600;
    white-space: nowrap;
}

.application-status i {
    font-size: 15px;
}


/* ==========================================
   BODY
========================================== */

.application-card-body {
    padding: 0;
}

.application-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0;
}

.application-info {
    min-width: 0;

    padding: 10px;

    background: rgba(255, 255, 255, 0.015);

    border: 1px solid rgba(255, 255, 255, 0.07);

    border-radius: 0px;
}


/* ==========================================
   LABELS
========================================== */

.info-label {
    display: flex;
    align-items: center;
    gap: 7px;

    margin-bottom: 4px;

    color: var(--bs-white);

    font-size: 8.4px;
    font-weight: 600;

    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.info-label i {
    color: var(--status-color);

    font-size: 12px;
}


/* ==========================================
   VALUES
========================================== */

.info-value {
    color: var(--bs-white);

    font-size: 10.6px;
    font-weight: 500;
}


/* ==========================================
   DEPARTMENT TAGS
========================================== */

.tag-list {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.application-tag {
    display: inline-flex;

    padding: 4px 8px;

    color: var(--bs-white);

    background: rgba(255, 255, 255, 0.05);

    border: 1px solid rgba(255, 255, 255, 0.08);

    border-radius: 5px;

    font-size: 11px;
}


/* ==========================================
   COURSES
========================================== */

.course-list {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.course-tag {
    display: inline-flex;
    align-items: center;

    padding: 6px 9px;

    color: var(--bs-white);

    background: color-mix(
        in srgb,
        var(--status-color) 8%,
        transparent
    );

    border: 1px solid color-mix(
        in srgb,
        var(--status-color) 20%,
        transparent
    );

    border-radius: 6px;

    font-size: 11px;
}


/* ==========================================
   FOOTER
========================================== */

.application-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 11px 20px;

    border-top: 1px solid rgba(255, 255, 255, 0.06);

    color: var(--bs-white);

    font-size: 11px;
}

.application-meta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.application-meta i {
    color: var(--status-color);

    font-size: 14px;
}


/* ==========================================
   EMPTY STATE
========================================== */

.empty-applications {
    padding: 60px 20px;

    text-align: center;

    border: 1px dashed rgba(255, 255, 255, 0.12);

    border-radius: 14px;

    color: var(--bs-white);
}

.empty-icon {
    margin-bottom: 12px;

    font-size: 45px;

    opacity: 0.45;
}

.empty-applications h5 {
    margin-bottom: 5px;

    color: var(--bs-white);
}

.empty-applications p {
    margin: 0;

    font-size: 13px;
}


/* ==========================================
   MOBILE
========================================== */

@media (max-width: 767.98px) {

    .application-card-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .application-status {
        align-self: flex-start;
    }

    .application-info-grid {
        grid-template-columns: 1fr;
    }

    .application-card-footer {
        align-items: flex-start;
        flex-direction: column;
        gap: 6px;
    }
}
</style>
@endsection

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