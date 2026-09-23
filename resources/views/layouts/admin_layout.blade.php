<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('admin/images/favicon.svg')}}" type="image/x-icon">
    <!-- RemixIcon -->
    <link href="{{ asset('admin/remixicons/remixicon.css') }}" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="{{asset('admin/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/style.css') }}"><!-- IziToast CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&display=swap" rel="stylesheet">

    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('admin/images/logo.svg') }}" class="img-fluid" width="90" alt="">
        </div>

        <ul class="nav flex-column px-2">
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin-home') ? 'active' : '' }}" href="{{route('admin-home')}}">
                    <i class="ri-dashboard-line"></i>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin-country-*') ? 'active' : '' }}" href="{{route('admin-country-index')}}">
                    <i class="ri-earth-line"></i>
                    <span class="nav-link-text">Countries</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin-program-levels-index') ? 'active' : '' }}" href="{{route('admin-program-levels-index')}}">
                    <i class="ri-stack-line"></i>
                    <span class="nav-link-text">Program Levels</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin-inquiries') ? 'active' : '' }}" href="{{route('admin-inquiries')}}">
                    <i class="ri-question-mark"></i>
                    <span class="nav-link-text">Inquiries</span>
                    @php
                        $unreadCount = \App\Models\consults::where('is_seen', false)->count();
                    @endphp
                    @if ($unreadCount > 0)
                    <span class="badge p-1 border border-light rounded">
                        <span class="visually-hidden">New</span>
                    </span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin-university-*') ? 'active' : '' }}" href="{{route('admin-university-index')}}">
                    <i class="ri-school-line"></i>
                    <span class="nav-link-text">University List</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin-students-*') ? 'active' : '' }}" href="{{route('admin-students-index')}}">
                    <i class="ri-group-line"></i>
                    <span class="nav-link-text">Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin-contacts') ? 'active' : '' }}" href="{{route('admin-contacts')}}">
                    <i class="ri-file-list-line"></i>
                    <span class="nav-link-text">Contacts</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link {{ Route::is('admin-reviews') ? 'active' : '' }}" href="{{route('admin-reviews')}}">
                    <i class="ri-star-fill"></i>
                    <span class="nav-link-text">Reviews</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link {{ Route::is(patterns: 'admin-faqs') ? 'active' : '' }}" href="{{route('admin-faqs')}}">
                    <i class="ri-question-line"></i>
                    <span class="nav-link-text">FAQs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is(patterns: 'admin-blogs-index') || Route::is('admin-blogs-show') || Route::is('admin-blogs-create') || Route::is('admin-blogs-edit') ? 'active' : '' }}" href="{{route('admin-blogs-index')}}">
                    <i class="ri-blogger-line"></i>
                    <span class="nav-link-text">Blogs (Not Ready)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is(patterns: 'admin-offices-index') ? 'active' : '' }}" href="{{route('admin-offices-index')}}">
                    <i class="ri-building-2-line"></i>
                    <span class="nav-link-text">Offices</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is(patterns: 'admin-calendar-index') ? 'active' : '' }}" href="{{route('admin-calendar-index')}}">
                    <i class="ri-calendar-2-line"></i>
                    <span class="nav-link-text">Calendar (Not Ready)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is(patterns: 'admin-users-index') ? 'active' : '' }}" href="{{route('admin-users-index')}}">
                    <i class="ri-group-line"></i>
                    <span class="nav-link-text">Users</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Header (Simplified without dropdown) -->
    <header class="header">
        <i class="ri-menu-line header-icon"></i>
        <span class="header-title">@yield('title')</span>

        <div class="header-actions">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="btn btn-danger btn-sm" type="submit">Logout</button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

</body>
</html>
<script>
    function toTitleCase(str) {
        return str.replace(/\w\S*/g, function(txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    }
</script>
<script src="{{ asset('admin/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/jqueryui/external/jquery/jquery.js') }}"></script>
<script src="{{ asset('admin/forms.js') }}"></script>
<!-- IziToast JS -->
<script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
@yield('scripts')