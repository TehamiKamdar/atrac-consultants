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

(function () {
    var b = document.body;
    var icon = document.querySelector('.header-icon');
    if (icon) icon.addEventListener('click', function () { b.classList.toggle('sidebar-open'); });

    // overlay (body) pe click karne se drawer band
    b.addEventListener('click', function (e) { if (e.target === b) b.classList.remove('sidebar-open'); });

    // kisi link pe click karne se bhi band
    document.querySelectorAll('.sidebar .nav-link').forEach(function (l) {
        l.addEventListener('click', function () { b.classList.remove('sidebar-open'); });
    });
})();