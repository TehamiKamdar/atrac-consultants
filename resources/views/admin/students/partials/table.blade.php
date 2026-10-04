@if (count($students) > 0)
    @foreach ($students as $key => $student)
        <!-- Example Student Card -->
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ ucfirst($student->first_name) . ' ' . ucfirst($student->last_name) }}</td>
            <td>{{ strtolower($student->email) }}</td>
            <td>{{ $student->phone }}</td>
            <td>{{ $student->country_names }}</td>
            <td>
                @if(!$student->user_id)

                    <form action="{{ route('admin.students.create-user', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Create an account for this student?')">

                        @csrf

                        <button type="submit"
                                class="btn btn-sm btn-outline-success text-white">
                            Create Student Portal Account
                        </button>

                    </form>

                @else
                    @if ($student->status === 'active')

                        <form action="{{ route('admin.students.disable-user', $student->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Disable account of this student?')">

                            @csrf

                            <button type="submit"
                                    class="btn btn-sm btn-outline-warning text-white">
                                Disable Account
                            </button>

                        </form>

                    @else

                    <form action="{{ route('admin.students.enable-user', $student->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Enable account of this student?')">

                        @csrf

                        <button type="submit"
                                class="btn btn-sm btn-outline-primary text-white">
                            Enable Account
                        </button>

                    </form>

                    @endif
                @endif
            </td>
            <td>
                <div class="dropdown">
                    <button type="button" class="btn btn-sm text-light" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-arrow-down-s-fill"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <button type="button" class="dropdown-item profileBtn" data-id="{{ $student->id }}">
                                <i class="ri-file-pdf-2-line me-2"></i>
                                Download Profile
                            </button>
                        </li>

                        <li>
                            <a type="button" class="dropdown-item detailsBtn" href="{{ route('admin-students-get-documents', $student->id) }}">
                                <i class="ri-file-zip-line me-2"></i>
                                View Documents
                            </a>
                        </li>

                        <li>
                            <button type="button" class="dropdown-item credentialsBtn" data-id="{{ $student->id }}">
                                <i class="ri-key-2-fill me-2"></i>
                                Credentials
                            </button>
                        </li>

                        <li>
                            <button type="button" class="dropdown-item detailsBtn" data-id="{{ $student->id }}">
                                <i class="ri-information-line me-2"></i>
                                Program Details
                            </button>
                        </li>

                        @if (!empty($student->user_id))
                            <li>
                                <a href="{{ route('admin.students.login-as', $student->id) }}" class="dropdown-item detailsBtn">
                                    <i class="ri-login-box-line me-2"></i>
                                    Login as Student
                                </a>
                            </li>
                        @endif

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <button type="button" class="dropdown-item text-danger"
                                data-bs-target="#deleteModal{{ $student->id }}" data-bs-toggle="modal">
                                <i class="ri-delete-bin-2-line me-2"></i>
                                Delete
                            </button>
                        </li>

                    </ul>
                </div>
            </td>
        </tr>
        <div class="modal fade" id="deleteModal{{ $student->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light border-secondary">

                    <div class="modal-header border-secondary py-2 px-4">
                        <h5 class="modal-title">Delete Record</h5>
                        <button type="button" class="btn-sm btn-danger py-0 px-1 rounded" data-bs-dismiss="modal"><i
                                class="ri-close-line"></i></button>
                    </div>

                    <div class="modal-body py-2 px-4">
                        <p style="font-size: 14px;">
                            Are you sure you want to delete
                            {{ ucfirst($student->first_name) . ' ' . ucfirst($student->last_name) . '\'s' }} record?
                            Deleting will may result in lost of documents, educational details and profile document.
                        </p>
                    </div>

                    <div class="modal-footer border-secondary">
                        <button type="button" data-id="{{ $student->id }}" class="btn btn-sm btn-danger deleteBtn">
                            <i class="ri-delete-bin-2-line me-2"></i>Delete
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Edit Modal -->
    @endforeach
@else
    <tr>
        <td colspan="7" class="text-center">Student Record Not Found. Add one from <a href="{{ route('register') }}">here</a></td>
    </tr>
@endif