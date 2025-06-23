@extends('layouts.admin_main')

@section('main-section')
@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
@if (session('reject'))
    <div class="alert alert-danger">
        {{session('reject')}}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-warning">
        {{session('error')}}
    </div>
@endif
<div class="col-md-8 offset-md-2">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Consult Details</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Consult Name:</dt>
                <dd class="col-sm-8">{{ $consult->name }}</dd>

                <dt class="col-sm-4">Email:</dt>
                <dd class="col-sm-8">{{ $consult->email }}</dd>

                <dt class="col-sm-4">Phone:</dt>
                <dd class="col-sm-8">{{ $consult->phone }}</dd>

                <dt class="col-sm-4">Qualified With:</dt>
                <dd class="col-sm-8">{{ $consult->qualification }}</dd>

                <dt class="col-sm-4">Percentage:</dt>
                <dd class="col-sm-8">{{ $consult->percentage }}%</dd>

                <dt class="col-sm-4">Country of Interest:</dt>
                <dd class="col-sm-8">{{ $consult->country_name }}</dd>

                <dt class="col-sm-4">Field of Interest:</dt>
                <dd class="col-sm-8">{{ $consult->field }}</dd>

                <dt class="col-sm-4">Message:</dt>
                <dd class="col-sm-8">{{ $consult->message }}</dd>

                <dt class="col-sm-4">Requested On:</dt>
                <dd class="col-sm-8">{{ $consult->created_at }}</dd>

                
                <br>

                @if ($consult->status == 'pending')
                    <dd class="col-sm-8">
                        <!-- Approve with Date and Time -->
                        <form action="{{ route('consult.schedule', $consult->id) }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="meeting_datetime">Select Meeting Date and Time:</label>
                                <input type="datetime-local" name="meeting_datetime" id="meeting_datetime"
                                    class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm">Schedule & Approve</button>
                        </form>
                    </dd>
                @else
                    @if ($consult->status == 'approved')
                        <dd class="col-sm-8">
                            <span class="badge bg-success">{{ $consult->status }}</span>
                            <br>
                            <strong>Meeting Scheduled For:</strong> {{ \Carbon\Carbon::parse($consult->meeting_datetime)->format('d-M-Y h:i A') }}
                        </dd>
                    @else
                        <dd class="col-sm-8">
                            <span class="badge bg-danger">{{ $consult->status }}</span>
                        </dd>
                    @endif
                @endif



                {{-- <dt class="col-sm-4">Assigned User:</dt>
                <dd class="col-sm-8">{{ $consult->user_name }}</dd> --}}
            </dl>
        </div>
        <div class="card-footer text-end">
            <a href="/admin/consults" class="btn btn-secondary">Back to Consults</a>
        </div>
    </div>
</div>
@endsection