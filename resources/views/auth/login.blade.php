@extends('layouts.auth')

@section('content')
    <div class="login-container">
        <div class="login-card">
            @include('include.alert')
            <div class="card-body">
                <h4 class="mb-4 text-center">Login</h4>
                <form action="{{route('login')}}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email or username" required>
                    </div>
                    <div class="position-relative">
                        <input type="password" class="form-control pe-5" name="password" id="password" placeholder="Password" required>
                        <i class="ri-eye-line icon-eye position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;">
                        </i>
                    </div>

                    <button type="submit" class="btn btn-login mb-2">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection