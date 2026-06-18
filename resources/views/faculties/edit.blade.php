@extends('layouts.master')
@section('title', 'تعديل كلية')
@section('page-title', 'تعديل بيانات الكلية')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('faculties.update', $faculty->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">الرمز</label>
                <input type="text" name="code" class="form-control" value="{{ $faculty->code }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (عربي)</label>
                <input type="text" name="name_ar" class="form-control" value="{{ $faculty->name_ar }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (إنجليزي)</label>
                <input type="text" name="name_en" class="form-control" value="{{ $faculty->name_en }}" required>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">تحديث</button>
            <a href="{{ route('faculties.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
