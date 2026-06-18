@extends('layouts.master')
@section('title', 'عرض مبنى')
@section('page-title', 'بيانات المبنى')

@section('content')
<div class="card card-custom p-4">
    <div class="row">
        <div class="col-md-6">
            <p><strong>الرمز:</strong> {{ $building->code }}</p>
            <p><strong>الاسم (عربي):</strong> {{ $building->name_ar }}</p>
            <p><strong>الاسم (إنجليزي):</strong> {{ $building->name_en }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>الموقع:</strong> {{ $building->location ?? '—' }}</p>
            <p><strong>عدد الطوابق:</strong> {{ $building->floors }}</p>
            <p><strong>الوصف:</strong> {{ $building->description ?? '—' }}</p>
        </div>
    </div>
    @if($building->rooms->count() > 0)
        <hr>
        <h6 class="fw-bold">القاعات التابعة:</h6>
        <ul>
            @foreach($building->rooms as $room)
                <li>{{ $room->name_ar }} ({{ $room->code }}) - {{ $room->type }}</li>
            @endforeach
        </ul>
    @endif
    <a href="{{ route('buildings.index') }}" class="btn btn-secondary fw-bold px-4 mt-3">عودة</a>
</div>
@endsection
