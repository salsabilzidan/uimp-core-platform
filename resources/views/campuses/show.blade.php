@extends('layouts.master')
@section('title', 'عرض الحرم الجامعي')
@section('page-title', 'تفاصيل الحرم الجامعي')

@section('content')
<div class="card card-custom p-4">
    <div class="row g-4">
        <div class="col-md-4">
            <label class="form-label text-muted">الاسم (عربي)</label>
            <p class="fw-bold fs-5">{{ $campus->name_ar }}</p>
        </div>
        <div class="col-md-4">
            <label class="form-label text-muted">الاسم (إنجليزي)</label>
            <p class="fw-bold">{{ $campus->name_en }}</p>
        </div>
        <div class="col-md-4">
            <label class="form-label text-muted">الموقع</label>
            <p>{{ $campus->location ?? '—' }}</p>
        </div>
    </div>

    @if($campus->buildings->count())
    <hr>
    <h5 class="fw-bold mb-3">المباني التابعة</h5>
    <table class="table table-hover text-center align-middle">
        <thead style="background: #f8f9fa;">
            <tr><th>#</th><th>الاسم</th><th>الرمز</th></tr>
        </thead>
        <tbody>
            @foreach($campus->buildings as $building)
                <tr>
                    <td>{{ $building->id }}</td>
                    <td class="fw-bold">{{ $building->name }}</td>
                    <td><span class="badge bg-secondary">{{ $building->code }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="mt-4">
        <a href="{{ route('campuses.index') }}" class="btn btn-secondary fw-bold px-4">العودة إلى القائمة</a>
        @if(Auth::user()->hasRole('sys_admin'))
            <a href="{{ route('campuses.edit', $campus->id) }}" class="btn btn-warning fw-bold px-4">تعديل</a>
        @endif
    </div>
</div>
@endsection
