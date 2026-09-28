@extends('layouts.student_layout')

@section('content')
    <section class="section active" id="profile">
        <div class="card p-head">
            <div class="avatar">{{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->last_name, 0, 1)) }}</div>
            <div class="meta">
                <h2>{{ $student->first_name.' '.$student->last_name }}</h2>
                <div class="muted">{{ $student->email }}</div>
                <div class="bar"><i style="width:85%"></i></div>
                <div class="muted" style="margin-top:6px;font-size:11px">Profile 85% complete</div>
            </div>
            <svg class="ill" viewBox="0 0 120 100" style="width:110px;height:92px">
                <use href="#ill-profile" />
            </svg>
        </div>
        <div class="card">
            <form id="profileForm">
                <div class="form-grid">
                    <div class="field">
                        <label>First Name</label>
                        <input id="first_name" value="{{ $student->first_name }}">
                    </div>
                    <div class="field">
                        <label>Last Name</label>
                        <input id="last_name" value="{{ $student->last_name }}">
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <input id="email" type="email" value="{{ $student->email }}">
                    </div>
                    <div class="field">
                        <label>Father's Name</label>
                        <input id="father_name" value="{{ $student->father_name }}">
                    </div>
                    <div class="field">
                        <label>Mother's Name</label>
                        <input id="mother_name" value="{{ $student->mother_name }}">
                    </div>
                    <div class="field">
                        <label>City</label>
                        <input id="city" value="{{ $student->city }}">
                    </div>
                    <div class="field">
                        <label>Phone</label>
                        <input id="phone" value="{{ $student->phone }}">
                    </div>
                    <div class="field">
                        <label>Date of Birth</label>
                        <input id="dob" type="date" value="{{ $student->dob }}">
                    </div>
                    <div class="field">
                        <label>NIC Number</label>
                        <input id="cnic" value="{{ $student->cnic }}">
                    </div>
                    <div class="field">
                        <label>Passport Number</label>
                        <input id="passport_number" value="{{ $student->passport_number }}">
                    </div>
                    <div class="field">
                        <label>Passport Valid From</label>
                        <input id="passport_valid_from" type="date" value="{{ $student->passport_valid_from }}">
                    </div>
                    <div class="field">
                        <label>Passport Valid Thru</label>
                        <input id="passport_valid_thru" type="date" value="{{ $student->passport_valid_thru }}">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn primary">Save changes</button>
                    <span
                        class="save-msg" id="saveMsg">Saved
                    </span>
                </div>
            </form>
        </div>
    </section>
@endsection