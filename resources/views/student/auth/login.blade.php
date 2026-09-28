<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Student Portal</title>
    <link rel="stylesheet" href="{{ asset('student/css/style.css') }}">

</head>

<body>

    <!-- ============ ILLUSTRATION LIBRARY ============ -->
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <g id="ill-student">
                <circle cx="150" cy="150" r="118" fill="var(--accent)" opacity=".14" />
                <circle cx="150" cy="150" r="118" fill="none" stroke="var(--accent)" stroke-opacity=".4"
                    stroke-dasharray="4 7" />
                <path d="M62 300c0-58 40-92 88-92s88 34 88 92z" fill="var(--shirt)" />
                <path d="M112 214c-6 22-8 52-8 86h16c0-30 2-56 8-76z" fill="var(--accent)" />
                <path d="M188 214c6 22 8 52 8 86h-16c0-30-2-56-8-76z" fill="var(--accent)" />
                <rect x="134" y="186" width="32" height="34" rx="12" fill="#e2b18e" />
                <ellipse cx="150" cy="152" rx="38" ry="42" fill="#f1c9a5" />
                <path d="M112 150c-4-44 22-58 38-58s42 14 38 58c-8-24-22-32-38-32s-30 8-38 32z" fill="#1a1a1a" />
                <circle cx="137" cy="156" r="3.2" fill="#222" />
                <circle cx="163" cy="156" r="3.2" fill="#222" />
                <path d="M140 172q10 8 20 0" stroke="#222" stroke-width="2.4" fill="none" stroke-linecap="round" />
                <path d="M124 110v20q26 14 52 0v-20z" fill="#1c1c1c" />
                <path d="M92 100l58-26 58 26-58 26z" fill="#111" stroke="var(--accent)" stroke-width="2" />
                <path d="M150 100l52 4v26" stroke="var(--accent)" stroke-width="2.4" fill="none" />
                <circle cx="202" cy="133" r="4.5" fill="var(--accent)" />
                <g transform="rotate(-8 215 262)">
                    <rect x="184" y="238" width="62" height="46" rx="5" fill="var(--accent)" />
                    <rect x="189" y="243" width="52" height="36" rx="3" fill="#fff" />
                    <path d="M215 243v36" stroke="#cfd8d3" />
                    <path d="M195 253h14M195 261h14M221 253h14M221 261h14" stroke="#9aa5a0" stroke-width="2" />
                </g>
                <circle cx="52" cy="92" r="5" fill="var(--accent)" />
                <circle cx="262" cy="188" r="4" fill="var(--accent)" opacity=".6" />
                <path d="M246 62l5 11 11 5-11 5-5 11-5-11-11-5 11-5z" fill="var(--accent)" opacity=".85" />
            </g>
            <g id="ill-docs">
                <rect x="30" y="14" width="56" height="72" rx="8" fill="var(--accent)" opacity=".3"
                    transform="rotate(-10 58 50)" />
                <rect x="38" y="10" width="56" height="74" rx="8" fill="var(--text)" />
                <path d="M48 28h36M48 38h36M48 48h24" stroke="var(--bg)" stroke-opacity=".35" stroke-width="3.5"
                    stroke-linecap="round" />
                <circle cx="90" cy="74" r="15" fill="var(--accent)" />
                <path d="M83 74l5 5 9-10" stroke="#fff" stroke-width="3.5" fill="none" stroke-linecap="round"
                    stroke-linejoin="round" />
            </g>
            <g id="ill-prog">
                <rect x="26" y="68" width="68" height="12" rx="3" fill="var(--text)" />
                <rect x="32" y="56" width="60" height="12" rx="3" fill="var(--accent)" />
                <path d="M60 12l40 17-40 17-40-17z" fill="var(--text)" />
                <path d="M40 38v14q20 10 40 0V38" fill="none" stroke="var(--text)" stroke-width="5" opacity=".65" />
                <path d="M100 29v22" stroke="var(--accent)" stroke-width="3" />
                <circle cx="100" cy="54" r="4" fill="var(--accent)" />
            </g>
            <g id="ill-profile">
                <rect x="12" y="18" width="96" height="64" rx="11" fill="var(--text)" />
                <circle cx="38" cy="44" r="10" fill="var(--accent)" />
                <path d="M22 72q16-18 32 0z" fill="var(--accent)" opacity=".75" />
                <path d="M64 38h34M64 48h34M64 58h22" stroke="var(--bg)" stroke-opacity=".35" stroke-width="4"
                    stroke-linecap="round" />
            </g>
            <g id="ill-chat">
                <path d="M18 14h52a8 8 0 0 1 8 8v20a8 8 0 0 1-8 8H42L28 62V50H18a8 8 0 0 1-8-8V22a8 8 0 0 1 8-8z"
                    fill="var(--text)" />
                <circle cx="30" cy="32" r="3.5" fill="var(--bg)" opacity=".5" />
                <circle cx="44" cy="32" r="3.5" fill="var(--bg)" opacity=".5" />
                <circle cx="58" cy="32" r="3.5" fill="var(--bg)" opacity=".5" />
                <path d="M62 46h32a8 8 0 0 1 8 8v16a8 8 0 0 1-8 8h-4v12L78 78H62a8 8 0 0 1-8-8V54a8 8 0 0 1 8-8z"
                    fill="var(--accent)" />
            </g>
            <g id="ill-upload">
                <path d="M34 76a18 18 0 0 1 2-36 26 26 0 0 1 50-4 20 20 0 0 1 2 40z" fill="var(--text)" />
                <circle cx="60" cy="58" r="18" fill="var(--accent)" />
                <path d="M60 68V49M52 57l8-8 8 8" stroke="#fff" stroke-width="4" fill="none" stroke-linecap="round"
                    stroke-linejoin="round" />
            </g>
            <g id="ill-shield">
                <path d="M60 8l38 14v28c0 24-16 40-38 48-22-8-38-24-38-48V22z" fill="var(--text)" />
                <rect x="44" y="44" width="32" height="26" rx="6" fill="var(--accent)" />
                <path d="M50 44v-8a10 10 0 0 1 20 0v8" fill="none" stroke="var(--accent)" stroke-width="5" />
                <circle cx="60" cy="57" r="4" fill="#fff" />
            </g>
        </defs>
    </svg>

    <!-- ================= LOGIN ================= -->
    <div id="login">
        <div class="l-left">
            <div class="logo"><i><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 9l10-5 10 5-10 5z" />
                        <path d="M6 11.5V16c3 2 9 2 12 0v-4.5" />
                    </svg></i>Student Portal</div>
            <div>
                <h2>Your future starts with <em>one login.</em></h2>
                <p class="sub">Complete your profile, upload documents and track every program application from one
                    modern
                    dashboard.</p>
            </div>
            <div class="l-stage">
                <svg class="ill" viewBox="0 0 300 300">
                    <use href="#ill-student" />
                </svg>
                <div class="chip c1"><b>✓</b>
                    <div>Application approved<small>BS Computer Science</small></div>
                </div>
                <div class="chip c2"><b>4</b>
                    <div>Documents verified<small>3 still pending</small></div>
                </div>
                <div class="chip c3"><b>★</b>
                    <div>New programs open<small>Fall 2026 intake</small></div>
                </div>
            </div>
            <div class="l-feats"><span>Secure student data</span><span>Real-time status</span><span>Easy document upload</span></div>
        </div>
        <div class="l-right">
            <form class="login-card" id="loginForm" method="POST" action="{{ route('student.login.submit') }}">

                @csrf

                <h1>Welcome back</h1>
                <div class="sub">Sign in to your student account</div>
                <div class="field">
                    <label>Email or Username</label>
                    <input id="uid" placeholder="Email or Username" name="login" autocomplete="username">
                </div>
                <div class="field">
                    <label>Password</label>
                    <input id="pwd" type="password" name="password" placeholder="Enter your password" autocomplete="current-password">
                </div>
                <button class="btn primary" type="submit">Sign in</button>
                <div class="err" id="loginErr">
                    @error('login')
                    {{ $message }}
                    @enderror
                </div>
                <div class="apply">
                    <svg class="ill ic" viewBox="0 0 120 100">
                        <use href="#ill-profile" />
                    </svg>
                    <div>New student?<a href="{{ route('register') }}">Start your application →</a></div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>