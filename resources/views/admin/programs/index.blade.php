@extends('layouts.admin_layout')

@section('content')
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-dark-custom table-hover">
            <thead>
                <tr>
                    <th>Active Programs</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programs as $p)
                    <tr>
                        <td>{{$p->name}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection