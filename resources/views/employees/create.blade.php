<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة موظف جديد - منصة UIMP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght=400;600;700&display=swap" rel="stylesheet">
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

    <div class="container mt-5" style="max-width: 800px;">
        <div class="mb-4">
            <h2 class="fw-bold text-secondary">إضافة حساب موظف / عضو هيئة تدريس جديد</h2>
            <p class="text-muted">أدخلي البيانات الأساسية لإنشاء حساب دخول للمنظومة وربطه بالقسم العلمي</p>
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

        <div class="card p-4 shadow-sm border-0 mb-5" style="border-radius: 10px;">
            <form action="{{ route('employees.store') }}" method="POST">
                @csrf

                <h4 class="text-primary fw-bold mb-3 border-bottom pb-2">🔒 بيانات الحساب والدخول</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-bold">الاسم بالكامل</label>
                        <input type="text" name="name" class="form-control" id="name" required value="{{ old('name') }}" placeholder="مثال: د. أحمد علي">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-bold">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" id="email" required value="{{ old('email') }}" placeholder="username@uimp.edu.ly">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="password" class="form-label fw-bold">كلمة المرور الافتراضية</label>
                        <input type="password" name="password" class="form-control" id="password" required placeholder="يجب ألا تقل عن 8 خانات">
                    </div>
                </div>

                <h4 class="text-primary fw-bold mt-4 mb-3 border-bottom pb-2">📋 البيانات الوظيفية والأكاديمية</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="employee_code" class="form-label fw-bold">الرقم الوظيفي / الكود</label>
                        <input type="text" name="employee_code" class="form-control" id="employee_code" required value="{{ old('employee_code') }}" placeholder="مثال: EMP-2026">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label fw-bold">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" id="phone" required value="{{ old('phone') }}" placeholder="091XXXXXXX">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="department_id" class="form-label fw-bold">القسم العلمي التابع له</label>
                        <select name="department_id" id="department_id" class="form-select" required>
                            <option value="">-- اختاري القسم العلمي المستهدف --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name_ar }} ({{ $dept->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('employees.index') }}" class="btn btn-light fw-bold me-2">إلغاء</a>
                    <button type="submit" class="btn btn-warning fw-bold px-4 text-dark">حفظ الحساب والموظف</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>