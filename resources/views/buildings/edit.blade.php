@extends('layouts.master')
@section('title', 'تعديل مبنى')
@section('page-title', 'تعديل بيانات المبنى')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('buildings.update', $building->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">الرمز</label>
                <input type="text" name="code" class="form-control" value="{{ $building->code }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (عربي)</label>
                <input type="text" name="name_ar" class="form-control" value="{{ $building->name_ar }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (إنجليزي)</label>
                <input type="text" name="name_en" class="form-control" value="{{ $building->name_en }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الموقع</label>
                <input type="text" name="location" class="form-control" value="{{ $building->location }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">عدد الطوابق</label>
                <input type="number" name="floors" class="form-control" value="{{ $building->floors }}" min="1" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">وصف</label>
                <textarea name="description" class="form-control" rows="1">{{ $building->description }}</textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">تحديث</button>
            <a href="{{ route('buildings.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
