@extends('layouts.admin_layout')

@section('styles')

@endsection

@section('scripts')

    <script src="{{ asset('admin/jqueryui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/script.js') }}"></script>

@endsection

@section('content')
    <div class="container-fluid board">
        <div class="row g-3">
            <!-- Pending Column -->
            <div class="col-md-3">
                <div class="column pending" data-status="pending">
                    <h3><i class="ri-time-fill"></i> Pending</h3>
                    <div class="column-content">
                        @foreach ($pendinginquiries as $data)
                            <div class="task draggable pending {{ $data->is_seen == 0 ? 'newConsult' : '' }} {{ $data->is_seen }}" data-id="{{ $data->id }}" draggable="true">
                                @php
                                    $encryptedId = encrypt($data->id);

                                @endphp
                                <div class="task-header justify-content-between">
                                    <div><i class="ri-user-3-fill"></i> {{ $data->name }}</div>
                                    <form id="deleteInquiry"><input type="hidden" class="encrypted-id"
                                            value="{{ $encryptedId }}"><button type="submit"
                                            class="btn btn-delete btn-danger"><i class="ri-delete-bin-2-line"></i></button>
                                    </form>
                                </div>
                                <div class="task-content">
                                    <div class="user-detail">
                                        <span class="detail-label">Phone:</span>
                                        <span class="detail-value">{{ $data->phone }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Email:</span>
                                        <span class="detail-value">{{ $data->email }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Qualification:</span>
                                        <span class="detail-value">{{ $data->qualification }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Interested In:</span>
                                        <span class="detail-value">{{ $data->country_name }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Percentage / GPA:</span>
                                        <span
                                            class="detail-value">{{ $data->percentage }}{{$data->percentage > 4 ? '%' : '' }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Nearest Office: </span>
                                        <span class="detail-value">{{ ucfirst($data->office_location) }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Message: </span>
                                        <span class="detail-value">{{ ucfirst($data->message) ?? 'No data' }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Requested On: </span>
                                        <span
                                            class="detail-value">{{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</span>
                                    </div>
                                    @if(is_null($data->date))
                                        <div class="user-detail">
                                            <span class="detail-label">Can Meet On: </span>
                                            <span class="detail-value text-danger" data-bs-theme="dark">Not Decided Yet</span>
                                        </div>
                                    @else
                                        <div class="user-detail">
                                            <span class="detail-label">Can Meet On: </span>
                                            <span
                                                class="detail-value">{{ \Carbon\Carbon::parse($data->date)->format('d F Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Active Column -->
            <div class="col-md-3">
                <div class="column active" data-status="active">
                    <h3><i class="ri-user-follow-fill"></i> Active Meetings</h3>
                    <div class="column-content">
                        @foreach ($activeinquiries as $data)
                            <div class="task draggable active" data-id="{{ $data->id }}" draggable="true">
                                @php
                                    $encryptedId = encrypt($data->id);
                                @endphp
                                <div class="task-header justify-content-between">
                                    <div><i class="ri-user-3-fill"></i> {{ $data->name }}</div>
                                    <form id="deleteInquiry"><input type="hidden" class="encrypted-id"
                                            value="{{ $encryptedId }}"><button type="submit"
                                            class="btn btn-delete btn-danger"><i class="ri-delete-bin-2-line"></i></button>
                                    </form>
                                </div>
                                <div class="task-content">
                                    <div class="user-detail">
                                        <span class="detail-label">Phone:</span>
                                        <span class="detail-value">{{ $data->phone }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Email:</span>
                                        <span class="detail-value">{{ $data->email }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Qualification:</span>
                                        <span class="detail-value">{{ $data->qualification }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Interested In:</span>
                                        <span class="detail-value">{{ $data->country_name }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Percentage / GPA:</span>
                                        <span
                                            class="detail-value">{{ $data->percentage }}{{$data->percentage > 4 ? '%' : '' }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Nearest Office: </span>
                                        <span class="detail-value">{{ ucfirst($data->office_location) }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Requested On: </span>
                                        <span
                                            class="detail-value">{{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</span>
                                    </div>
                                    @if(is_null($data->date))
                                        <div class="user-detail">
                                            <span class="detail-label">Can Meet On: </span>
                                            <span class="detail-value text-danger" data-bs-theme="dark">Not Decided Yet</span>
                                        </div>
                                    @else
                                        <div class="user-detail">
                                            <span class="detail-label">Can Meet On: </span>
                                            <span
                                                class="detail-value">{{ \Carbon\Carbon::parse($data->date)->format('d F Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Active Modal -->
            <div class="modal fade" id="activeModal" tabindex="-1" aria-labelledby="activeModalLabel" aria-hidden="true"
                data-bs-theme="dark">
                <div class="modal-dialog">
                    <div class="modal-content inquiry-modal activate-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="ri-checkbox-circle-line me-2"></i>Accept Inquiry
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="activeForm">
                                <input type="hidden" name="inquiry_id" id="active_inquiry_id">
                                <div class="mb-4">
                                    <label for="activation_time" class="form-label">
                                        <i class="ri-time-line me-1"></i>Meeting Time
                                    </label>
                                    <input type="datetime-local" class="form-control" id="activeTime" name="datetime" required>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-light me-2"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-activate">
                                        <i class="ri-check-line me-1"></i>Activate
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Hold Column -->
            <div class="col-md-3">
                <div class="column hold" data-status="hold">
                    <h3><i class="ri-pause-fill"></i> On Hold</h3>
                    <div class="column-content">
                        @foreach ($holdinquiries as $data)
                            <div class="task draggable hold" data-id="{{ $data->id }}" draggable="true">
                                @php
                                    $encryptedId = encrypt($data->id);
                                @endphp
                                <div class="task-header justify-content-between">
                                    <div><i class="ri-user-3-fill"></i> {{ $data->name }}</div>
                                    <form id="deleteInquiry"><input type="hidden" class="encrypted-id"
                                            value="{{ $encryptedId }}"><button type="submit"
                                            class="btn btn-delete btn-danger"><i class="ri-delete-bin-2-line"></i></button>
                                    </form>
                                </div>
                                <div class="task-content">
                                    <div class="user-detail">
                                        <span class="detail-label">Phone:</span>
                                        <span class="detail-value">{{ $data->phone }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Email:</span>
                                        <span class="detail-value">{{ $data->email }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Qualification:</span>
                                        <span class="detail-value">{{ $data->qualification }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Interested In:</span>
                                        <span class="detail-value">{{ $data->country_name }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Percentage / GPA:</span>
                                        <span
                                            class="detail-value">{{ $data->percentage }}{{$data->percentage > 4 ? '%' : '' }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Nearest Office: </span>
                                        <span class="detail-value">{{ ucfirst($data->office_location) }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Requested On: </span>
                                        <span
                                            class="detail-value">{{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</span>
                                    </div>
                                    @if(is_null($data->date))
                                        <div class="user-detail">
                                            <span class="detail-label">Can Meet On: </span>
                                            <span class="detail-value text-danger" data-bs-theme="dark">Not Decided Yet</span>
                                        </div>
                                    @else
                                        <div class="user-detail">
                                            <span class="detail-label">Can Meet On: </span>
                                            <span
                                                class="detail-value">{{ \Carbon\Carbon::parse($data->date)->format('d F Y') }}</span>
                                        </div>
                                    @endif
                                    @if($data->reason)
                                        <div class="user-detail">
                                            <span class="detail-label">Reason: </span>
                                            <span
                                                class="detail-value">{{$data->reason}}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="modal fade" id="holdModal" tabindex="-1" data-bs-theme="dark">
                <div class="modal-dialog">
                    <div class="modal-content inquiry-modal hold-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="ri-time-line me-2"></i>Hold Inquiry
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="holdForm">
                                <div class="mb-3">
                                    <label for="holdReason" class="form-label">
                                        <i class="ri-questionnaire-line me-1"></i>Reason
                                    </label>
                                    <textarea class="form-control" id="holdReason" rows="3" required></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="revisitDate" class="form-label">
                                        <i class="ri-calendar-line me-1"></i>Re-Inquiry Date <span class="text-danger ms-1"> (Optional)</span>
                                    </label>
                                    <input type="date" class="form-control" id="revisitDate">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-light me-2"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-hold">
                                        <i class="ri-save-line me-1"></i>Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Reject Column -->
            <div class="col-md-3">
                <div class="column reject" data-status="reject">
                    <h3><i class="ri-close-circle-fill"></i> Reject</h3>
                    <div class="column-content">
                        @foreach ($rejectinquiries as $data)
                            <div class="task draggable reject" data-id="{{ $data->id }}" draggable="true">
                                @php
                                    $encryptedId = encrypt($data->id);
                                @endphp
                                <div class="task-header justify-content-between">
                                    <div><i class="ri-user-3-fill"></i> {{ $data->name }}</div>
                                    <form id="deleteInquiry"><input type="hidden" class="encrypted-id"
                                            value="{{ $encryptedId }}"><button type="submit"
                                            class="btn btn-delete btn-danger"><i class="ri-delete-bin-2-line"></i></button>
                                    </form>
                                </div>
                                <div class="task-content">
                                    <div class="user-detail">
                                        <span class="detail-label">Phone:</span>
                                        <span class="detail-value">{{ $data->phone }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Email:</span>
                                        <span class="detail-value">{{ $data->email }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Qualification:</span>
                                        <span class="detail-value">{{ $data->qualification }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Interested In:</span>
                                        <span class="detail-value">{{ $data->country_name }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Percentage / GPA:</span>
                                        <span
                                            class="detail-value">{{ $data->percentage }}{{$data->percentage > 4 ? '%' : '' }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Nearest Office: </span>
                                        <span class="detail-value">{{ ucfirst($data->office_location) }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="detail-label">Requested On: </span>
                                        <span
                                            class="detail-value">{{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</span>
                                    </div>
                                    @if(is_null($data->date))
                                        <div class="user-detail">
                                            <span class="detail-label">Can Meet On: </span>
                                            <span class="detail-value text-danger" data-bs-theme="dark">Not Decided Yet</span>
                                        </div>
                                    @else
                                        <div class="user-detail">
                                            <span class="detail-label">Can Meet On: </span>
                                            <span
                                                class="detail-value">{{ \Carbon\Carbon::parse($data->date)->format('d F Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal fade" id="rejectModal" tabindex="-1" data-bs-theme="dark">
                <div class="modal-dialog">
                    <div class="modal-content inquiry-modal reject-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="ri-close-circle-line me-2"></i>Reject Inquiry
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="rejectForm">
                                <div class="mb-3">
                                    <label for="rejectReason" class="form-label">Reason</label>
                                    <textarea class="form-control" id="rejectReason" required></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-light me-2"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="ri-save-line me-1"></i>Save
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection