<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Student Portal</title>
    <link rel="stylesheet" href="{{ asset('student/css/style.css') }}">

</head>

<body>
    <div id="app">
        <aside class="sidebar">
            <div>
                <div class="brand">
                    <i>
                        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 9l10-5 10 5-10 5z" />
                            <path d="M6 11.5V16c3 2 9 2 12 0v-4.5" />
                        </svg>
                    </i>
                    <span>Student Portal</span></div>
                <nav>
                    <button class="nav-item active" data-target="profile"><svg viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.7">
                            <circle cx="12" cy="8" r="3.5" />
                            <path d="M4.5 20c1.5-4 4.2-6 7.5-6s6 2 7.5 6" />
                        </svg><span class="label">Profile</span></button>
                    <button class="nav-item" data-target="documents"><svg viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.7">
                            <path d="M6 3h8l4 4v14H6z" />
                            <path d="M14 3v4h4" />
                            <path d="M9 13h6M9 16.5h6" />
                        </svg><span class="label">Documents</span></button>
                    <button class="nav-item" data-target="programs"><svg viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.7">
                            <path d="M4 19V6l8-3 8 3v13" />
                            <path d="M4 19h16" />
                            <path d="M9 19v-6h6v6" />
                        </svg><span class="label">Program Selection</span></button>
                    <button class="nav-item" data-target="settings"><svg viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.7">
                            <circle cx="12" cy="12" r="2.6" />
                            <path
                                d="M19 12a7 7 0 0 0-.1-1.2l2-1.5-2-3.4-2.3.9a7 7 0 0 0-2-1.2L14.2 3H9.8l-.4 2.6a7 7 0 0 0-2 1.2l-2.3-.9-2 3.4 2 1.5A7 7 0 0 0 5 12c0 .4 0 .8.1 1.2l-2 1.5 2 3.4 2.3-.9c.6.5 1.3.9 2 1.2l.4 2.6h4.4l.4-2.6c.7-.3 1.4-.7 2-1.2l2.3.9 2-3.4-2-1.5c.1-.4.1-.8.1-1.2Z" />
                        </svg><span class="label">Settings</span></button>
                </nav>
            </div>
            <div class="sidebar-foot">
                <button class="nav-item" id="logout"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <path d="M16 17l5-5-5-5" />
                        <path d="M21 12H9" />
                    </svg><span class="label">Log out</span></button>
            </div>
        </aside>

        <div class="main">
            <header class="topbar">
                <h1 id="pageTitle">Dashboard</h1>
                <div class="top-right">
                    <button class="theme-btn" data-theme-toggle>Light / Dark</button>
                    <div class="profile-chip">
                        <div class="who">
                            <div class="name">{{ $student->first_name.' '.$student->last_name }}</div>
                            <div class="email">{{ $student->email }}</div>
                        </div>
                        <div class="avatar">
                            {{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->last_name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
<script src="{{ asset('website/lib/js/jquery.min.js') }}"></script>
@yield('scripts')