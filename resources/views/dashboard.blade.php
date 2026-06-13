<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - منصة UIMP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; }
        .navbar-custom { background-color: #1e3d59; }
        .card-counter { border: none; border-radius: 10px; color: white; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom p-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">لوحة تحكم UIMP</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">مرحباً، {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">تسجيل الخروج</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2 class="fw-bold text-secondary">الاحصائيات العامة للنظام</h2>
                <p class="text-muted">متابعة فورية للمكونات الأساسية للجامعة والمعامل</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-counter bg-primary p-4 shadow-sm">
                    <h3>الكليات</h3>
                    <p class="fs-2 fw-bold mb-0">{{ $collegesCount }}</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card card-counter bg-success p-4 shadow-sm">
                    <h3>الأقسام العلمية</h3>
                    <p class="fs-2 fw-bold mb-0">{{ $departmentsCount }}</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card card-counter bg-warning text-dark p-4 shadow-sm">
                    <h5>أعضاء هيئة التدريس والموظفين</h5>
                    <p class="fs-2 fw-bold mb-0">{{ $employeesCount }}</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>