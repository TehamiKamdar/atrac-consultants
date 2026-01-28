@php
$fields = \App\Models\fields::orderBy('field', 'asc')->get();
$sim_codes = \App\Models\sim_codes::all();
@endphp
<style>
    .btn:disabled{
        background-color: #2bb673 !important;
    }
</style>
<form action="{{route('consultation')}}" method="POST" class="needs-validation" novalidate>
    @csrf

    <div class="{{ $layout === 'wide' || $layout === 'modal' ? 'row g-3 mb-4' : 'mb-3' }}">
        <div class="col-12 {{ $layout === 'wide' || $layout === 'modal' ? 'col-md-6' : 'mb-3' }}">
            <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text bg-light">
                    <i class="ri-user-line text-muted"></i>
                </span>
                <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
            </div>
        </div>
        <div class="col-12 {{ $layout === 'wide' || $layout === 'modal' ? 'col-md-6' : 'mb-3' }}">
            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text bg-light">
                    <i class="ri-mail-line text-muted"></i>
                </span>
                <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" required>
            <div class="invalid-feedback" id="emailError"></div>
            </div>
        </div>
    </div>

    <div class="{{ $layout === 'wide' || $layout === 'modal' ? 'row g-3 mb-4' : 'mb-3' }}">
        <div class="col-12 {{ $layout === 'wide' || $layout === 'modal' ? 'col-md-6' : 'mb-3' }}">
            <label for="phone" class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group">
                    <!-- Prefix dropdown 25% -->
                    <select id="phonePrefix" name="prefix" class="form-select" style="flex: 0 0 35%; max-width: 35%;"
                        required>
                        @foreach ($sim_codes as $sim)
                            <option value="0{{$sim->code}}">0{{$sim->code}}</option>
                        @endforeach
                    </select>

                    <!-- Main number input 75% -->
                    <input type="text" id="phoneNumber" name="phone" class="form-control"
                        style="flex: 0 0 65%; max-width: 65%;" placeholder="1234567" maxlength="7" required>
                </div>
            </div>
        </div>
        <div class="col-12 {{ $layout === 'wide' || $layout === 'modal' ? 'col-md-6' : 'mb-3' }}">
            <label for="office_location" class="form-label fw-semibold">Nearest Office Location <span
                    class="text-danger">*</span></label>
            <select class="form-select" id="office_location" name="office_location" required>
                <option value="" selected disabled>Select Location</option>
                <option value="karachi">Karachi</option>
                <option value="islamabad">Islamabad</option>
                <option value="lahore">Lahore</option>
            </select>
        </div>
    </div>

    <div class="{{ $layout === 'wide' || $layout === 'modal' ? 'row g-3 mb-4' : 'mb-3' }}">
        <div class="col-12 {{ $layout === 'wide' || $layout === 'modal' ? 'col-md-6' : 'mb-3' }}">
            <label for="qualification" class="form-label fw-semibold">Latest Qualification <span
                    class="text-danger">*</span></label>
            <select class="form-select" id="qualification" name="qualification" required>
                <option value="" selected disabled>Select your qualification</option>
                <option value="Matric">Matric</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Bachelors">Bachelors</option>
                <option value="Masters">Masters</option>
                <option value="others">Others</option>
            </select>
        </div>
        <div class="col-12 {{ $layout === 'wide' || $layout === 'modal' ? 'col-md-6' : 'mb-3' }}">
            <label for="percentage" class="form-label fw-semibold">Percentage/GPA <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control" id="percentage" name="percentage" max="100" placeholder="e.g. 85" required>
        </div>
    </div>

    <div class="{{ $layout === 'wide' || $layout === 'modal' ? 'row g-3 mb-4' : 'mb-3' }}">
        <div class="col-12 {{ $layout === 'wide' || $layout === 'modal' ? 'col-md-6' : 'mb-3' }}">
            <label for="country" class="form-label fw-semibold">Country of Interest <span
                    class="text-danger">*</span></label>
            <select class="form-select" id="country" name="country" required>
                <option value="" selected disabled>Select preferred country</option>
                @foreach ($countries as $c)
                    <option value="{{$c->id}}">{{$c->name}}</option>
                @endforeach
                <option value="others">Others</option>
            </select>
        </div>
        <div class="col-12 {{ $layout === 'wide' || $layout === 'modal' ? 'col-md-6' : 'mb-3' }}">
            <label for="field" class="form-label fw-semibold">Field of Interest <span
                    class="text-danger">*</span></label>
            <select class="form-select" id="field" name="field" required>
                <option value="" selected disabled>Select field of study</option>
                @foreach ($fields as $f)
                    <option value="{{$f->field}}">{{$f->field}}</option>
                @endforeach
                <option value="others">Others</option>
            </select>
        </div>
    </div>

    <div class="mb-4">
        <label for="date" class="form-label fw-semibold">When You Can Meet<span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="date" name="date" required>
        <div class="invalid-feedback" id="dateError"></div>
    </div>

    <div class="mb-4">
        <label for="message" class="form-label fw-semibold">Your Message</label>
        <textarea class="form-control" id="message" name="message" rows="3"
            placeholder="Any specific questions or requirements..."></textarea>
    </div>

    <div class="mb-4">
        <input type="hidden" name="recaptcha_token" id="recaptcha_token">
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg fw-semibold" disabled>
            <i class="ri-calendar-check-line me-2"></i> Book Free Consultation
        </button>
    </div>
</form>

<script src="https://www.google.com/recaptcha/enterprise.js?render={{ config('services.recaptcha.site_key') }}"></script>

<script>
    grecaptcha.enterprise.ready(function () {
        grecaptcha.enterprise.execute(
            "{{ config('services.recaptcha.site_key') }}",
            { action: 'consultation' }
        ).then(function (token) {
            document.getElementById('recaptcha_token').value = token;
        });
    });
</script>