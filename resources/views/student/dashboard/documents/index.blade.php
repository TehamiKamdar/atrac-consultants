@extends('layouts.student_layout')

@section('title')
    My Documents
@endsection

@section('content')

    <div class="container-fluid">
        @php
            $uploadedCount = $documents->where('uploaded', true)->count();
            $pendingCount = $documents->where('uploaded', false)->count();
        @endphp
        {{-- Summary --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 p-0 shadow-sm">
                    <div class="card-body bg-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-light small">
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
            <div class="col-md-3">
                <div class="card border-0 p-0 shadow-sm">
                    <div class="card-body bg-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-light small">
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

        <div class="table-responsive">
            <table class="table table-dark">
                <thead class="table-dark">
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
                            {{-- # --}}
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            {{-- Document --}}
                            <td>
                                <div class="fw-semibold">
                                    {{ $document['name'] }}
                                </div>
                            </td>
                            {{-- Status --}}
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
                            {{-- Files --}}
                            <td>
                                @if($document['uploaded'])
                                    1 file
                                @else
                                    <span>
                                        No file uploaded
                                    </span>
                                @endif
                            </td>
                            {{-- Action --}}
                            <td class="text-end">
                                @if($document['uploaded'])
                                    <a href="{{ asset('storage/' . $document['file']->file_path) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-primary"
                                        title="View">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-warning edit-document"
                                            data-id="{{ $document['file']->id }}"
                                            data-type="{{ $document['type'] }}"
                                            title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </button>

                                    <input type="file"
                                        id="editDocumentInput"
                                        class="d-none"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger delete-document"
                                            data-id="{{ $document['file']->id }}"
                                            title="Delete">

                                        <i class="ri-delete-bin-2-line"></i>
                                    </button>

                                @else
                                    <input type="file" class="d-none document-upload-input" id="document_{{ $document['type'] }}"
                                        data-document-type="{{ $document['type'] }}" accept=".pdf,.jpg,.jpeg,.png" multiple>
                                    <label for="document_{{ $document['type'] }}" class="btn btn-sm btn-outline-success" title="Upload">
                                        <i class="ri-upload-2-line"></i>
                                    </label>
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
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end">
                            <button
                                data-folder="{{ strtolower(str_replace(' ', '', $student->first_name)) . '_' . strtolower(str_replace(' ', '', $student->last_name)) . '_' . strtolower(str_replace(' ', '', $student->intake)) }}_documents"
                                class="btn btn-sm btn-info documentBtn">
                                <i class="ri-download-2-line"></i>
                                Download All Documents
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        /* ===============================
            DOWNLOAD DOCUMENTS
        =============================== */
        $(document).on('click', '.documentBtn', function () {
            let folderName = $(this).data('folder');
            let url = `/download/student/documents/${folderName}`;
            window.open(url, '_blank');
        });
        
        /* ===============================
            DELETE DOCUMENTS
        =============================== */
        $(document).on('click', '.delete-document', function () {
            
            let button = $(this);
            let documentId = button.data('id');

            if (!confirm('Are you sure you want to delete this document?')) {
                return;
            }

            $.ajax({
                url: `/documents/${documentId}/delete`,
                type: 'DELETE',

                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                
                success: function (response) {
                    
                    alert(response.message);
                    
                    window.location.reload();
                },
                
                error: function (xhr) {
                    
                    console.log(xhr.responseText);
                    
                    alert('Something went wrong while deleting the document.');
                }
            });
            
        });

        /* ===============================
            EDIT DOCUMENTS
        =============================== */
        let editDocumentId = null;

        $(document).on('click', '.edit-document', function () {

            editDocumentId = $(this).data('id');

            $('#editDocumentInput').val('');

            $('#editDocumentInput').click();
        });


        $('#editDocumentInput').on('change', function () {

            let file = this.files[0];

            if (!file || !editDocumentId) {
                return;
            }

            let formData = new FormData();

            formData.append('file', file);
            formData.append(
                '_token',
                $('meta[name="csrf-token"]').attr('content')
            );

            $.ajax({
                url: `/documents/${editDocumentId}/edit`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,

                success: function (response) {

                    if (response.success) {
                        alert("Document Updated");
                        window.location.reload();
                    }
                },

                error: function (xhr) {

                    console.log(xhr.responseText);

                    alert('Something went wrong while updating the document. Check console for more info.');
                }
            });
        });
        
        /* ===============================
            EDIT DOCUMENTS
        =============================== */
        $(document).on('change', '.document-upload-input', function () {

        let input = this;
        let files = input.files;

        if (!files.length) {
            return;
        }

        let documentType = $(input).data('document-type');
        let studentId = '{{ $student->id }}';

        let formData = new FormData();

        formData.append('student_id', studentId);
        formData.append('document_type', documentType);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $.each(files, function (index, file) {
            formData.append('files[]', file);
        });

        $.ajax({
            url: '/documents/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            success: function (response) {

                if (response.success) {
                    alert("Document Uploaded");
                    window.location.reload();
                }
            },

            error: function (xhr) {

                console.log(xhr.responseText);

                alert('Something went wrong while uploading documents.');
            }
        });
    });
    </script>
@endsection