<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات الكلية - منصة UIMP</title>
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
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 700px;">
        <div class="mb-4">
            <h2 class="fw-bold text-secondary">تعديل بيانات الكلية</h2>
            <p class="text-muted">تعديل بيانات كلية: {{ $faculty->name_ar }}</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger p-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card p-4 shadow-sm border-0" style="border-radius: 10px;">
            <form action="{{ route('faculties.update', $faculty->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- توجيه لارافيل للاستجابة لدالة التحديث --}}

                <div class="mb-3">
                    <label for="code" class="form-label fw-bold">رمز الكلية</label>
                    <input type="text" name="code" class="form-control" id="code" required value="{{ old('code', $faculty->code) }}">
                </div>

                <div class="mb-3">
                    <label for="name_ar" class="form-label fw-bold">اسم الكلية باللغة العربية</label>
                    <input type="text" name="name_ar" class="form-control" id="name_ar" required value="{{ old('name_ar', $faculty->name_ar) }}">
                </div>

                <div class="mb-3">
                    <label for="name_en" class="form-label fw-bold">اسم الكلية باللغة الإنجليزية</label>
                    <input type="text" name="name_en" class="form-control" id="name_en" required value="{{ old('name_en', $faculty->name_en) }}">
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('faculties.index') }}" class="btn btn-light fw-bold me-2">إلغاء</a>
                    <button type="submit" class="btn btn-warning fw-bold px-4">تحديث البيانات</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>