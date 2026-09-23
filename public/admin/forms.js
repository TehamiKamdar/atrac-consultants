// --- Form Validation ---
const forms = document.querySelectorAll('.needs-validation');
forms.forEach(form => {
    form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();

            form.querySelectorAll(':invalid').forEach(el => {
                el.classList.add('animate__animated', 'animate__headShake');
                setTimeout(() => el.classList.remove('animate__animated', 'animate__headShake'), 1000);
            });
        }
        form.classList.add('was-validated');
    }, false);
});