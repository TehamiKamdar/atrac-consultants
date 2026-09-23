@extends('layouts.admin_layout')

@section('title', 'Calendar')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div id="calendar"></div>
</div>
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title">Add Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="eventForm">
                    @csrf

                    <input type="hidden" name="start" id="start_date">
                    <input type="hidden" name="end" id="end_date">

                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control form-control-sm bg-dark text-white" required>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control form-control-sm bg-dark text-white">
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="hold">Hold</option>
                            <option value="reject">Reject</option>
                            <option value="complete">Complete</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        Save Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        themeSystem: 'bootstrap5',
        initialView: 'dayGridMonth',
        headerToolbar: {
            right: 'prev,next today',
            center: 'title',
            left: 'dayGridMonth,timeGridWeek,listWeek'
        },

        events: '/events',

        selectable: true,

        select: function(info) {
            console.log(info);
            document.getElementById('start_date').value = info.startStr;
            document.getElementById('end_date').value = info.endStr;

            var modal = new bootstrap.Modal(document.getElementById('eventModal'));
            modal.show();
        }
    });

    calendar.render();
});
</script>
@endsection