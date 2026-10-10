@extends('layouts.admin_layout')

@section('title', 'UTM Link Generator')

@section('content')
    <div class="container-fluid">
        {{-- UTM LINK GENERATOR --}}
        <div class="card mb-4" data-bs-theme="dark">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ri-links-line"></i> UTM Link Generator
                </h5>
            </div>

            <div class="card-body">
                <form id="utmGeneratorForm">
                    <div class="mb-3">
                        <label for="destination_url" class="form-label">
                            Destination URL
                        </label>
                        <input type="url" id="destination_url" class="form-control" placeholder="https://atracconsultants.com/" required>
                        <small class="text-muted">
                            Apni website ke jis page ko track karna hai, uska URL enter karo.
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="utm_source" class="form-label">
                                UTM Source
                            </label>
                            <input type="text" id="utm_source" class="form-control" placeholder="facebook" required>
                            <small class="text-muted">
                                Link jahan promote karni hai, uska naam likhein, jaise ke facebook ya instagram even if any link is posted in a blog, write blog
                            </small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="utm_medium" class="form-label">
                                UTM Medium
                            </label>
                            <input type="text" id="utm_medium" class="form-control" placeholder="social" required>
                            <small class="text-muted">
                                Traffic kis type ke channel se aa rahi hai, uska naam likhein, jaise ke social_post, blog ya direct_link
                            </small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="utm_campaign" class="form-label">
                                UTM Campaign
                            </label>
                            <input type="text" id="utm_campaign" class="form-control" placeholder="blog_promotion" required>
                            <small class="text-muted">
                                Marketing campaign ka naam likhein, jaise ke blog_promotion, website_promotion ya koi_new_service
                            </small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="ri-link"></i> Generate Link
                    </button>
                </form>
            </div>
        </div>

        {{-- GENERATED LINK CARD --}}
        <div class="card mb-4" id="generatedLinkCard" style="display: none;" data-bs-theme="dark">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ri-checkbox-circle-line"></i> Generated Tracking Link
                </h5>
            </div>

            <div class="card-body">
                <label for="generatedLink" class="form-label">
                    Your tracking URL
                </label>

                <div class="input-group">
                    <input type="text" id="generatedLink" class="form-control" readonly>

                    <button type="button" class="btn btn-success" id="copyGeneratedLink">
                        <i class="ri-file-copy-line"></i> Copy Link
                    </button>
                </div>

                <small class="text-muted d-block mt-2" id="copyMessage">
                    Yeh link copy karke apni post, ad ya message mein use karo.
                </small>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('utmGeneratorForm');
            const resultCard = document.getElementById('generatedLinkCard');
            const generatedLink = document.getElementById('generatedLink');
            const copyButton = document.getElementById('copyGeneratedLink');
            const copyMessage = document.getElementById('copyMessage');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const destination = document
                    .getElementById('destination_url')
                    .value.trim();

                const source = document
                    .getElementById('utm_source')
                    .value.trim();

                const medium = document
                    .getElementById('utm_medium')
                    .value.trim();

                const campaign = document
                    .getElementById('utm_campaign')
                    .value.trim();

                try {
                    const url = new URL(destination);

                    if (!['http:', 'https:'].includes(url.protocol)) {
                        throw new Error('Invalid protocol');
                    }

                    // Add or update UTM parameters without removing existing query parameters.
                    url.searchParams.set('utm_source', source);
                    url.searchParams.set('utm_medium', medium);
                    url.searchParams.set('utm_campaign', campaign);

                    generatedLink.value = url.toString();
                    resultCard.style.display = 'block';

                    copyMessage.textContent =
                        'Tracking link generate ho gaya hai. Ab copy kar sakte ho.';

                    copyButton.innerHTML =
                        '<i class="ri-file-copy-line"></i> Copy Link';

                } catch (error) {
                    alert('Please enter a valid URL, including https://');
                }
            });

            copyButton.addEventListener('click', async function() {
                const link = generatedLink.value;

                if (!link) return;

                try {
                    await navigator.clipboard.writeText(link);

                    copyButton.innerHTML =
                        '<i class="ri-check-line"></i> Copied!';

                    copyMessage.textContent = 'Link clipboard mein copy ho gaya.';

                } catch (error) {
                    generatedLink.select();

                    const copied = document.execCommand('copy');

                    if (copied) {
                        copyButton.innerHTML =
                            '<i class="ri-check-line"></i> Copied!';
                        copyMessage.textContent = 'Link clipboard mein copy ho gaya.';
                    } else {
                        copyMessage.textContent =
                            'Link select kar diya hai. Ctrl + C press karke copy karo.';
                    }
                }
            });
        });
    </script>
@endsection
