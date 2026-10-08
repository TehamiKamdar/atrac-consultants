@if (session('error'))
    <div class="alert alert-sm alert-danger alert-dismissible fade show" role="alert" data-bs-theme="dark" style="border-radius: 4px;">
        <i class="ri-error-warning-fill me-2"></i>
        <strong>{{ session('error') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif 

@if (session('info'))
    <div class="alert alert-sm alert-info alert-dismissible fade show" role="alert" data-bs-theme="dark" style="border-radius: 4px;">
        <i class="ri-information-fill me-2"></i>
        <strong>{{ session('info') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif 

@if (session('success'))
    <div class="alert alert-sm alert-success alert-dismissible fade show" role="alert" data-bs-theme="dark" style="border-radius: 4px;">
        <i class="ri-checkbox-circle-fill me-2"></i>
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif 

@if (session('warning'))
    <div class="alert alert-sm alert-warning alert-dismissible fade show" role="alert" data-bs-theme="dark" style="border-radius: 4px;">
        <i class="ri-alert-fill me-2"></i>
        <strong>{{ session('warning') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif