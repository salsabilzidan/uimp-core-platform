<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'منصة UIMP') - النظام المركزي للجامعة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f0f4f8; }
        .sidebar { position: fixed; top: 0; right: 0; width: 250px; height: 100vh; background: #1a2a3a; z-index: 100; overflow-y: auto; }
        .sidebar .nav-link { color: rgba(255,255,255,0.7); padding: 10px 18px; border-radius: 0; font-size: 0.9rem; transition: all 0.2s; border-right: 3px solid transparent; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,0.05); border-right-color: rgba(255,255,255,0.3); }
        .sidebar .nav-link.active { color: #fff; background: rgba(26,115,232,0.15); border-right-color: #1a73e8; }
        .sidebar .nav-link i { margin-left: 10px; width: 20px; text-align: center; }
        .sidebar .section-title { color: rgba(255,255,255,0.3); font-size: 0.7rem; padding: 16px 18px 6px; text-transform: uppercase; letter-spacing: 1px; }
        .sidebar .brand { padding: 1rem 18px; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .main-content { margin-right: 250px; min-height: 100vh; }
        .navbar-top { background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .card-custom { border: none; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.04); background: #fff; }
        .stat-card { border-radius: 10px; color: #fff; padding: 1.25rem; }
        .btn-primary { background: #1a73e8; border-color: #1a73e8; border-radius: 8px; }
        .btn-primary:hover { background: #1557b0; border-color: #1557b0; }
        .btn-outline-danger { border-radius: 8px; }
        .table thead { background: #f8f9fa; }
        a { color: #1a73e8; }
        .badge { font-weight: 500; }
    </style>
</head>
<body>

    <div class="sidebar d-none d-md-block">
        <div class="brand">
            <h5 class="text-white fw-bold mb-0" style="font-size: 1.1rem;">UIMP</h5>
            <small style="color: rgba(255,255,255,0.4); font-size: 0.75rem;">النظام المركزي للجامعة</small>
        </div>

        <div class="section-title">الرئيسية</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> لوحة التحكم
        </a>

        <div class="section-title">إدارة البيانات المشتركة</div>
        @if(Auth::user()->hasPermissionTo('faculties.view'))
        <a href="{{ route('faculties.index') }}" class="nav-link {{ request()->routeIs('faculties.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> الكليات
        </a>
        @endif
        @if(Auth::user()->hasPermissionTo('departments.view'))
        <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
            <i class="bi bi-diagram-3"></i> الأقسام العلمية
        </a>
        @endif
        @if(Auth::user()->hasPermissionTo('employees.view'))
        <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> الموظفين
        </a>
        @endif
        @if(Auth::user()->hasPermissionTo('students.view'))
        <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
            <i class="bi bi-mortarboard"></i> الطلاب
        </a>
        @endif

        <div class="section-title">المرافق والمعامل</div>
        @if(Auth::user()->hasPermissionTo('campuses.view'))
        <a href="{{ route('campuses.index') }}" class="nav-link {{ request()->routeIs('campuses.*') ? 'active' : '' }}">
            <i class="bi bi-geo-alt"></i> الحرم الجامعي
        </a>
        @endif
        @if(Auth::user()->hasPermissionTo('buildings.view'))
        <a href="{{ route('buildings.index') }}" class="nav-link {{ request()->routeIs('buildings.*') ? 'active' : '' }}">
            <i class="bi bi-buildings"></i> المباني
        </a>
        @endif
        @if(Auth::user()->hasPermissionTo('rooms.view'))
        <a href="{{ route('rooms.index') }}" class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
            <i class="bi bi-door-open"></i> القاعات
        </a>
        @endif
        @if(Auth::user()->hasPermissionTo('laboratories.view'))
        <a href="{{ route('laboratories.index') }}" class="nav-link {{ request()->routeIs('laboratories.*') ? 'active' : '' }}">
            <i class="bi bi-cpu"></i> المعامل
        </a>
        @endif

        <div class="section-title">الإدارة</div>
        @if(Auth::user()->hasRole('sys_admin'))
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> المستخدمين والصلاحيات
            </a>
        @endif
        <a href="{{ route('subsystems.index') }}" class="nav-link {{ request()->routeIs('subsystems.*') ? 'active' : '' }}">
            <i class="bi bi-plugin"></i> الأنظمة الفرعية
        </a>
        @if(Auth::user()->hasRole('sys_admin'))
        <a href="{{ route('api.docs') }}" class="nav-link {{ request()->routeIs('api.docs') ? 'active' : '' }}">
            <i class="bi bi-book"></i> توثيق API
        </a>
        @endif
        @if(Auth::user()->hasPermissionTo('audit-logs.view'))
        <a href="{{ route('audit-logs.index') }}" class="nav-link {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> سجل التدقيق
        </a>
        @endif
    </div>

    <div class="main-content">
        <nav class="navbar navbar-top navbar-expand px-3 py-2">
            <div class="container-fluid">
                <span class="navbar-text fw-bold" style="color: #1a2a3a;">
                    @yield('page-title', 'لوحة التحكم')
                </span>
                <div class="d-flex align-items-center gap-2">
                    <span class="small" style="color: #5f6368;"><i class="bi bi-person-circle"></i> {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">خروج</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success fw-bold text-center border-0 shadow-sm mb-4" style="border-radius: 10px; background: #e6f4ea; color: #1e7e34;">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger fw-bold border-0 shadow-sm mb-4" style="border-radius: 10px;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
