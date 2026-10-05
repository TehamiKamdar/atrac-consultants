@extends('layouts.student_layout')

@section('title', 'Settings')

@section('content')
    @include('include.alert')

        <div class="set-grid">
            <div class="card">
                <h3>Change Password</h3>
                <form id="passwordForm" action="{{ route('student.update-password') }}" method="POST">
                    @csrf
                    <div class="field">
                        <label>Current Password</label>
                        <input type="password" name="current" required>
                    </div>
                    <div class="field">
                        <label>New Password</label>
                        <input type="password" name="new1" @error('new1') is-invalid @enderror required>
                        @error('new1')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Confirm New Password</label>
                        <input type="password" name="new2" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn primary">Update password</button>
                    </div>
                </form>
            </div>
            <div class="card sec-card"><svg class="ill art" viewBox="0 0 120 110">
                    <use href="#ill-shield" />
                </svg>
                <h3 style="margin:0">Keep your account safe</h3>
                <p>Use a strong password with letters, numbers and symbols, and never share it with anyone.</p>
            </div>
        </div>
@endsection
@section('scripts')
    <script>
        $('#passwordForm').on('submit', function(e) {

            const current = $('input[name="current"]').val();
            const new1 = $('input[name="new1"]').val();
            const new2 = $('input[name="new2"]').val();

            // New password minimum length
            if (new1.length < 8) {
                e.preventDefault();
                alert('New password must be at least 8 characters long.');
                return;
            }

            // Password match
            if (new1 !== new2) {
                e.preventDefault();
                alert('New password and confirm password do not match.');
                return;
            }

        });
    </script>
@endsection