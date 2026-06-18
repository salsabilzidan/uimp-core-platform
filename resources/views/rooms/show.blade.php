@extends('layouts.master')
@section('title', 'عرض قاعة')
@section('page-title', 'بيانات القاعة')

@section('content')
<div class="card card-custom p-4">
    <div class="row">
        <div class="col-md-6">
            <p><strong>الرمز:</strong> {{ $room->code }}</p>
            <p><strong>الاسم:</strong> {{ $room->name_ar }}</p>
            <p><strong>المبنى:</strong> {{ $room->building->name_ar ?? '—' }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>الطابق:</strong> {{ $room->floor }}</p>
            <p><strong>السعة:</strong> {{ $room->capacity }}</p>
            <p><strong>النوع:</strong> {{ $room->type }}</p>
        </div>
    </div>
    <a href="{{ route('rooms.index') }}" class="btn btn-secondary fw-bold px-4 mt-3">عودة</a>
</div>
@endsection
