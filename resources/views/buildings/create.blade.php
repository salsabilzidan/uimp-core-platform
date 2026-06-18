@extends('layouts.master')
@section('title', 'إضافة مبنى')
@section('page-title', 'إضافة مبنى جديد')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('buildings.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">الرمز</label>
                <input type="text" name="code" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (عربي)</label>
                <input type="text" name="name_ar" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (إنجليزي)</label>
                <input type="text" name="name_en" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الموقع</label>
                <input type="text" name="location" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">عدد الطوابق</label>
                <input type="number" name="floors" class="form-control" min="1" value="1" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">وصف</label>
                <textarea name="description" class="form-control" rows="1"></textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">حفظ</button>
            <a href="{{ route('buildings.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
