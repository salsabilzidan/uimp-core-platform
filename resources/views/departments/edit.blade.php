@extends('layouts.master')
@section('title', 'تعديل قسم')
@section('page-title', 'تعديل بيانات القسم العلمي')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('departments.update', $department->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">الكلية</label>
                <select name="faculty_id" class="form-select" required>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ $department->faculty_id == $faculty->id ? 'selected' : '' }}>{{ $faculty->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الرمز</label>
                <input type="text" name="code" class="form-control" value="{{ $department->code }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (عربي)</label>
                <input type="text" name="name_ar" class="form-control" value="{{ $department->name_ar }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (إنجليزي)</label>
                <input type="text" name="name_en" class="form-control" value="{{ $department->name_en }}" required>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">تحديث</button>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
