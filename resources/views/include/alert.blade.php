@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" data-bs-theme="dark" style="border-radius: 12px;">
        <i class="ri-alert-fill me-2"></i>
        <strong>Email or Password Error</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif 