@extends('layouts.admin_layout')

@section('styles')
    <style>
        input[type="checkbox"]{
            cursor: pointer;
            width: 18px;
            height: 18px;
            border-radius: 8px;
            accent-color: #2bb673; /* purple, bootstrap vibe */
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <table class="table table-bordered table-dark-custom">
        <thead>
            <tr>
                <th>Country</th>
                @foreach($allProgramLevels as $level)
                    <th>{{ $level->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $country)
                <tr>
                    <td>{{ $country->name }}</td>

                    @php
                        $selectedProgramIds = $country->programLevels()->pluck('program_level_id')->toArray();
                    @endphp

                    @foreach($allProgramLevels as $level)
                        <td class="">
                            <input type="checkbox" class="program-checkbox" data-country="{{ $country->id }}"  value="{{ $level->id }}" {{ in_array($level->id, $selectedProgramIds) ? 'checked' : '' }}>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.program-checkbox').on('change', function() {
        var country_id = $(this).data('country');
        var program_id = $(this).val();
        var checked = $(this).is(':checked');

        $.ajax({
            url: "{{ route('update.country.program') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                country_id: country_id,
                program_id: program_id,
                checked: checked
            },
            success: function(response) {
                if(response.success){
                    console.log('Updated successfully');
                }
            },
            error: function(xhr){
                console.log('Error:', xhr.responseText);
            }
        });
    });
});
</script>

@endsection