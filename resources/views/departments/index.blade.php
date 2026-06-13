<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الأقسام العلمية - منصة UIMP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; }
        .navbar-custom { background-color: #1e3d59; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom p-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">لوحة تحكم UIMP</a>
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
        
        @if(session('success'))
            <div class="alert alert-success fw-bold text-center border-0 shadow-sm mb-4" style="border-radius: 10px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-secondary">إدارة الأقسام العلمية</h2>
                <p class="text-muted">عرض وتعديل الأقسام العلمية وربطها بالكليات المركزية</p>
            </div>
            <a href="{{ route('departments.create') }}" class="btn btn-success fw-bold px-4 shadow-sm">إضافة قسم جديد +</a>
        </div>

        <div class="card p-4 shadow-sm border-0" style="border-radius: 10px;">
            <table class="table table-hover text-center align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>الكلية التابع لها</th>
                        <th>رمز القسم (Code)</th>
                        <th>الاسم باللغة العربية</th>
                        <th>الاسم باللغة الإنجليزية</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                        <tr>
                            <td class="fw-bold text-secondary">{{ $dept->id }}</td>
                            <td><span class="badge bg-primary fs-6">{{ $dept->faculty->name_ar ?? 'غير مرتبط' }}</span></td>
                            <td><span class="badge bg-secondary fs-6">{{ $dept->code ?? 'N/A' }}</span></td>
                            <td class="fw-bold">{{ $dept->name_ar }}</td>
                            <td class="text-muted">{{ $dept->name_en }}</td>
                            <td>
                                <a href="{{ route('departments.edit', $dept->id) }}" class="btn btn-sm btn-warning fw-bold px-3 me-1">تعديل</a>
                                <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنتِ متأكدة من حذف هذا القسم؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger fw-bold px-3">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted p-4">لا توجد أقسام علمية مضافة حالياً في النظام.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>