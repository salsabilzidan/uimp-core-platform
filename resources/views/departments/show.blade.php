@extends('layouts.master')
@section('title', 'عرض قسم')
@section('page-title', 'بيانات القسم العلمي')

@section('content')
<div class="card card-custom p-4">
    <div class="row">
        <div class="col-md-6">
            <p><strong>الرمز:</strong> {{ $department->code }}</p>
            <p><strong>الاسم (عربي):</strong> {{ $department->name_ar }}</p>
            <p><strong>الاسم (إنجليزي):</strong> {{ $department->name_en }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>الكلية:</strong> {{ $department->faculty->name_ar ?? '—' }}</p>
            <p><strong>تاريخ التسجيل:</strong> {{ $department->created_at->format('Y-m-d') }}</p>
        </div>
    </div>
    <a href="{{ route('departments.index') }}" class="btn btn-secondary fw-bold px-4 mt-3">عودة</a>
</div>
@endsection
