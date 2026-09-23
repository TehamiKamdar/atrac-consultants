@extends('layouts.admin_layout')

@section('content')
    <div class="container-fluid py-4">
        <!-- Your content goes here -->
        <div class="row g-4">
            <!-- Card 1: Total Revenue -->
            <div class="col-12 col-md-6 col-lg-3 mt-0 mb-3">
                <div class="stats-card card shadow">
                    <div class="card-body p-4">
                        <div class="card-icon icon-1">
                            <i class="ri-money-dollar-circle-line"></i>
                        </div>
                        <h6 class="card-title">TOTAL REVENUE</h6>
                        <h3 class="card-value">$24,780</h3>
                        <div class="card-change change-up">
                            <i class="ri-arrow-up-line"></i> 12.5% vs last month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: New Users -->
            <div class="col-12 col-md-6 col-lg-3 mt-0 mb-3">
                <div class="stats-card card shadow">
                    <div class="card-body p-4">
                        <div class="card-icon icon-2">
                            <i class="ri-user-add-line"></i>
                        </div>
                        <h6 class="card-title">NEW USERS</h6>
                        <h3 class="card-value">1,254</h3>
                        <div class="card-change change-up">
                            <i class="ri-arrow-up-line"></i> 7.2% vs last month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Orders -->
            <div class="col-12 col-md-6 col-lg-3 mt-0 mb-3">
                <div class="stats-card card shadow">
                    <div class="card-body p-4">
                        <div class="card-icon icon-3">
                            <i class="ri-shopping-basket-line"></i>
                        </div>
                        <h6 class="card-title">TOTAL ORDERS</h6>
                        <h3 class="card-value">3,142</h3>
                        <div class="card-change change-down">
                            <i class="ri-arrow-down-line"></i> 3.1% vs last month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Conversion Rate -->
            <div class="col-12 col-md-6 col-lg-3 mt-0 mb-3">
                <div class="stats-card card shadow">
                    <div class="card-body p-4">
                        <div class="card-icon icon-4">
                            <i class="ri-line-chart-line"></i>
                        </div>
                        <h6 class="card-title">CONVERSION RATE</h6>
                        <h3 class="card-value">3.42%</h3>
                        <div class="card-change change-up">
                            <i class="ri-arrow-up-line"></i> 1.6% vs last month
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
