@extends('layouts.admin_layout')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Student Documents</h4>
            <p class="text-muted mb-0">
                {{ $student->first_name ?? '' }} {{ $student->last_name ?? '' }}
            </p>
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line"></i>
            Back
        </a>
    </div>


    @php
        $uploadedCount = $documents->where('uploaded', true)->count();
        $pendingCount = $documents->where('uploaded', false)->count();
    @endphp


    {{-- Summary --}}

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="text-muted small">
                                Total Documents
                            </div>

                            <h3 class="mb-0">
                                {{ $documents->count() }}
                            </h3>
                        </div>

                        <div class="fs-2 text-primary">
                            <i class="ri-file-list-3-line"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="text-muted small">
                                Uploaded
                            </div>

                            <h3 class="mb-0 text-success">
                                {{ $uploadedCount }}
                            </h3>
                        </div>

                        <div class="fs-2 text-success">
                            <i class="ri-checkbox-circle-line"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="text-muted small">
                                Pending
                            </div>

                            <h3 class="mb-0 text-warning">
                                {{ $pendingCount }}
                            </h3>
                        </div>

                        <div class="fs-2 text-warning">
                            <i class="ri-time-line"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- Documents --}}

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                Required Documents
            </h5>
        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Document</th>
                            <th>Status</th>
                            <th>Files</th>
                            <th class="text-end">Action</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($documents as $document)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <div class="fw-semibold">
                                        {{ $document['name'] }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $document['type'] }}
                                    </small>

                                </td>


                                <td>

                                    @if($document['uploaded'])

                                        <span class="badge bg-success">
                                            <i class="ri-check-line"></i>
                                            Uploaded
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">
                                            <i class="ri-time-line"></i>
                                            Pending
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    @if($document['uploaded'])

                                        {{ $document['files']->count() }}

                                        {{ $document['files']->count() == 1 ? 'file' : 'files' }}

                                    @else

                                        <span class="text-muted">
                                            No file uploaded
                                        </span>

                                    @endif

                                </td>


                                <td class="text-end">

                                    @if($document['uploaded'])

                                        @foreach($document['files'] as $file)

                                            <a href="{{ asset('storage/' . $file->file_path) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary me-1">

                                                <i class="ri-eye-line"></i>
                                                View
                                            </a>

                                        @endforeach

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-5">

                                    <i class="ri-file-warning-line fs-1 text-muted"></i>

                                    <div class="mt-2 text-muted">
                                        No documents found.
                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection