@extends('layouts.student_layout')

@section('content')
    <section class="section active" id="dashboard">
        <div class="hero">
            <div>
                <span class="tag">Fall 2026 Intake · STU-2026-0142</span>
                <h2>Welcome back, Ayesha. You're 60% of the way there.</h2>
                <p>Upload your remaining documents and confirm your program choices to complete your admission application.
                </p>
                <div class="btns"><button class="btn primary" data-go="documents">Upload documents</button><button
                        class="btn ghost" data-go="programs">View programs</button></div>
            </div>
            <div class="hero-art">
                <svg class="ill" viewBox="0 0 300 300">
                    <use href="#ill-student" />
                </svg>
                <div class="ring"><svg viewBox="0 0 40 40">
                        <circle cx="20" cy="20" r="16" fill="none" stroke="rgba(255,255,255,.2)" stroke-width="4" />
                        <circle cx="20" cy="20" r="16" fill="none" stroke="#fff" stroke-width="4" stroke-linecap="round"
                            stroke-dasharray="60.3 100.5" />
                    </svg>
                    <div><b>60%</b><small>Application done</small></div>
                </div>
            </div>
        </div>

        <div class="ctas">
            <button class="cta" data-go="documents"><span class="badge">3 pending</span><svg class="ill art"
                    viewBox="0 0 120 100">
                    <use href="#ill-docs" />
                </svg>
                <h4>Upload Documents</h4>
                <p>Submit your remaining certificates.</p><span class="go">Upload now →</span>
            </button>
            <button class="cta" data-go="programs"><svg class="ill art" viewBox="0 0 120 100">
                    <use href="#ill-prog" />
                </svg>
                <h4>Choose Programs</h4>
                <p>Compare and confirm your picks.</p><span class="go">Explore programs →</span>
            </button>
            <button class="cta" data-go="profile"><svg class="ill art" viewBox="0 0 120 100">
                    <use href="#ill-profile" />
                </svg>
                <h4>Update Profile</h4>
                <p>Keep your details accurate.</p><span class="go">Edit profile →</span>
            </button>
            <button class="cta" data-go="dashboard"><svg class="ill art" viewBox="0 0 120 100">
                    <use href="#ill-chat" />
                </svg>
                <h4>Talk to a Counsellor</h4>
                <p>Get help with your application.</p><span class="go">Book a session →</span>
            </button>
        </div>

        <div class="stats">
            <div class="stat">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 19V6l8-3 8 3v13" />
                        <path d="M4 19h16" />
                    </svg></div>
                <div>
                    <div class="k">Programs Applied</div>
                    <div class="v">4</div>
                </div>
            </div>
            <div class="stat">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M6 3h8l4 4v14H6z" />
                    </svg></div>
                <div>
                    <div class="k">Documents Uploaded</div>
                    <div class="v">4 / 7</div>
                </div>
            </div>
            <div class="stat">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v5l3 2" />
                    </svg></div>
                <div>
                    <div class="k">Pending Documents</div>
                    <div class="v">3</div>
                </div>
            </div>
            <div class="stat">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M5 12l5 5 9-10" />
                    </svg></div>
                <div>
                    <div class="k">Status</div>
                    <div class="v" style="color:var(--accent)">Under Review</div>
                </div>
            </div>
        </div>

        <div class="grid2">
            <div class="card">
                <h3>Application Journey</h3>
                <ul class="tl">
                    <li class="done"><b></b>
                        <div>Account created<small>10 Aug 2026</small></div>
                    </li>
                    <li class="done"><b></b>
                        <div>Profile completed<small>10 Aug 2026</small></div>
                    </li>
                    <li class="done"><b></b>
                        <div>Programs selected<small>13 Aug 2026</small></div>
                    </li>
                    <li class="now"><b></b>
                        <div>Upload remaining documents<small>In progress · 3 pending</small></div>
                    </li>
                    <li><b></b>
                        <div>Final admission decision<small>Expected Oct 2026</small></div>
                    </li>
                </ul>
            </div>
            <div class="card">
                <h3>Recent Activity</h3>
                <ul class="feed">
                    <li><span>Intermediate Transcript submitted</span><small>14 Aug</small></li>
                    <li><span>BS Computer Science approved</span><small>13 Aug</small></li>
                    <li><span>Passport scan verified</span><small>12 Aug</small></li>
                    <li><span>Profile details updated</span><small>10 Aug</small></li>
                </ul>
                <div class="deadline"><span style="font-size:18px">⏰</span>
                    <div><strong>Medical Fitness Report</strong><small>Due 10 Oct 2026</small></div>
                </div>
            </div>
        </div>
    </section>
@endsection