@extends('layouts.admin_layout')

@section('title', 'Website Analytics')

@section('content')
    <div class="container-fluid py-4">
        <h3 class="mb-4"></h3> {{-- Date filter --}}
        {{-- <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3"> <label class="form-label">From</label> <input type="date" name="from"
                    value="{{ request('from') }}" class="form-control"> </div>
            <div class="col-md-3"> <label class="form-label">To</label> <input type="date" name="to"
                    value="{{ request('to') }}" class="form-control"> </div>
        </form>  --}}
        {{-- Summary cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card-dark" style="padding: 12px 20px 8px; border: 1px solid var(--dark-sidebar)" data-bs-theme="dark">
                    <div class="card-body">
                        <h6>Total Page Views</h6>
                        <h2>{{ number_format($totalViews) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-dark" style="padding: 12px 20px 8px; border: 1px solid var(--dark-sidebar)" data-bs-theme="dark">
                    <div class="card-body">
                        <h6>Unique Visitors</h6>
                        <h2>{{ number_format($uniqueVisitors) }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Traffic sources --}}
        <h5>Traffic Sources</h5>

        <div class="table-responsive">
            <table class="table table-dark-custom">
                <thead>
                    <tr>
                        <th>Source</th>
                        <th>Total Visits</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sources as $item)
                        <tr>
                            <td>{{ $item->source ?: 'Unknown' }}</td>
                            <td>{{ number_format($item->total) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">No data found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <h5>Devices</h5>

        <div class="table-responsive">
            <table class="table table-dark-custom">
                <thead>
                    <tr>
                        <th>Device</th>
                        <th>Total Visits</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devices as $item)
                        <tr>
                            <td>{{ $item->device_type ?: 'Unknown' }}</td>
                            <td>{{ number_format($item->total) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">No data found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Countries --}}
        <h5>Countries</h5>

        <div class="table-responsive">
            <table class="table table-dark-custom">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Country Code</th>
                        <th>Total Visits</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($countries as $item)
                        <tr>
                            <td>{{ $item->country }}</td>
                            <td>{{ $item->country_code }}</td>
                            <td>{{ $item->total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No data found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        {{-- <div class="mt-3"> {{ $recentVisits->links() }} </div> --}}
    </div>
@endsection