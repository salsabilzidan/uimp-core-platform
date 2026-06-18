@extends('layouts.master')
@section('title', 'إضافة طالب')
@section('page-title', 'إضافة طالب جديد')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">الاسم الكامل</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">القسم العلمي</label>
                <select name="department_id" class="form-select" required>
                    <option value="">اختر القسم</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الرقم الجامعي</label>
                <input type="text" name="student_code" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">السنة الدراسية</label>
                <input type="number" name="academic_year" class="form-control" min="1" max="10" required>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">حفظ</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
