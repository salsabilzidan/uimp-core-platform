@extends('layouts.master')
@section('title', 'تعديل طالب')
@section('page-title', 'تعديل بيانات الطالب')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">الاسم الكامل</label>
                <input type="text" name="name" class="form-control" value="{{ $student->user->name }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" value="{{ $student->user->email }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">كلمة المرور (اترك فارغاً إن لم ترد التغيير)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">القسم العلمي</label>
                <select name="department_id" class="form-select" required>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $student->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الرقم الجامعي</label>
                <input type="text" name="student_code" class="form-control" value="{{ $student->student_code }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">السنة الدراسية</label>
                <input type="number" name="academic_year" class="form-control" value="{{ $student->academic_year }}" min="1" max="10" required>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">تحديث</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
