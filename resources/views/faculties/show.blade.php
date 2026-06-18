@extends('layouts.master')
@section('title', 'عرض كلية')
@section('page-title', 'بيانات الكلية')

@section('content')
<div class="card card-custom p-4">
    <div class="row">
        <div class="col-md-6">
            <p><strong>الرمز:</strong> {{ $faculty->code }}</p>
            <p><strong>الاسم (عربي):</strong> {{ $faculty->name_ar }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>الاسم (إنجليزي):</strong> {{ $faculty->name_en }}</p>
            <p><strong>تاريخ التسجيل:</strong> {{ $faculty->created_at->format('Y-m-d') }}</p>
        </div>
    </div>
    <a href="{{ route('faculties.index') }}" class="btn btn-secondary fw-bold px-4 mt-3">عودة</a>
</div>
@endsection
