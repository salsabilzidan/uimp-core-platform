@extends('layouts.master')
@section('title', 'تعديل حرم جامعي')
@section('page-title', 'تعديل بيانات الحرم الجامعي')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('campuses.update', $campus->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">الاسم (عربي)</label>
                <input type="text" name="name_ar" class="form-control" value="{{ $campus->name_ar }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (إنجليزي)</label>
                <input type="text" name="name_en" class="form-control" value="{{ $campus->name_en }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الموقع</label>
                <input type="text" name="location" class="form-control" value="{{ $campus->location }}">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">حفظ التغييرات</button>
            <a href="{{ route('campuses.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
