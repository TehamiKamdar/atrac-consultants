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
                {{ $student->application_details->first()?->status
                    ? ucfirst($student->application_details->first()->status)
                    : 'Not applied yet' }}
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
                            <button type="button" class="dropdown-item documentBtn"
                                data-folder="{{ strtolower(str_replace(' ', '', $student->first_name)) . '_' . strtolower(str_replace(' ', '', $student->last_name)) . '_' . strtolower(str_replace(' ', '', $student->intake)) }}_documents">
                                <i class="ri-file-zip-line me-2"></i>
                                Download Documents
                            </button>
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
                                Details
                            </button>
                        </li>

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
        <div class="modal fade" id="editApplicationModal" data-bs-theme="dark" tabindex="-1"
            aria-labelledby="editApplicationModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editApplicationModalLabel">
                            Edit Application Details
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form id="editApplicationForm">

                            <!-- Hidden ID -->
                            <input type="hidden" id="editApplicationId">

                            <!-- User ID -->
                            <div class="mb-3">
                                <label for="editUserId" class="form-label">
                                    User ID
                                </label>

                                <input type="text" class="form-control" id="editUserId" name="user_id"
                                    placeholder="Enter user ID">
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="editPassword" class="form-label">
                                    Password
                                </label>

                                <input type="text" class="form-control" id="editPassword" name="password"
                                    placeholder="Enter password">
                            </div>

                            <!-- URL -->
                            <div class="mb-3">
                                <label for="editUrl" class="form-label">
                                    URL
                                </label>

                                <input type="url" class="form-control" id="editUrl" name="url"
                                    placeholder="https://example.com">
                            </div>

                        </form>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="button" class="btn btn-primary" id="saveApplicationChanges">
                            Save Changes
                        </button>

                    </div>

                </div>
            </div>
        </div>
    @endforeach
@else
    <tr>
        <td colspan="7" class="text-center">Student Record Not Found. Add one from <a href="https://atracconsultants.com/student/form/ajax">here</a></td>
    </tr>
@endif