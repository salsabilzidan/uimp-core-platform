@extends('layouts.master')
@section('title', 'عرض معمل')
@section('page-title', 'بيانات المعمل')

@section('content')
<div class="card card-custom p-4">
    <div class="row">
        <div class="col-md-6">
            <p><strong>الاسم:</strong> {{ $laboratory->name_ar }}</p>
            <p><strong>القاعة:</strong> {{ $laboratory->room->name_ar ?? '—' }}</p>
            <p><strong>المبنى:</strong> {{ $laboratory->room->building->name_ar ?? '—' }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>القسم:</strong> {{ $laboratory->department->name_ar ?? '—' }}</p>
            <p><strong>السعة:</strong> {{ $laboratory->capacity }}</p>
            <p><strong>الحالة:</strong> {!! $laboratory->is_active ? '<span class="badge bg-success">نشط</span>' : '<span class="badge bg-danger">غير نشط</span>' !!}</p>
        </div>
    </div>
    @if($laboratory->description)
        <p><strong>الوصف:</strong> {{ $laboratory->description }}</p>
    @endif
    <a href="{{ route('laboratories.index') }}" class="btn btn-secondary fw-bold px-4 mt-3">عودة</a>
</div>
@endsection
