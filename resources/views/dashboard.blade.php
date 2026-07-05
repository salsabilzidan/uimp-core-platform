@extends('layouts.master')
@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم الرئيسية')

@section('content')
<div class="row g-4">
    <div class="col-md-12">
        <div class="card card-custom p-4">
            <h5 class="fw-bold mb-1" style="color: #1a2a3a;">مرحباً، {{ Auth::user()->name }}</h5>
            <p class="text-muted small mb-0">نظرة عامة على مكونات النظام المركزي للجامعة</p>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a73e8, #4a8fe7);">
            <h6 class="fw-bold" style="font-size: 0.85rem; opacity: 0.9;">الكليات</h6>
            <p class="fs-3 fw-bold mb-0">{{ $collegesCount }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a2a3a, #2a3a4a);">
            <h6 class="fw-bold" style="font-size: 0.85rem; opacity: 0.9;">الأقسام</h6>
            <p class="fs-3 fw-bold mb-0">{{ $departmentsCount }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a73e8, #4a8fe7);">
            <h6 class="fw-bold" style="font-size: 0.85rem; opacity: 0.9;">الموظفين</h6>
            <p class="fs-3 fw-bold mb-0">{{ $employeesCount }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a2a3a, #2a3a4a);">
            <h6 class="fw-bold" style="font-size: 0.85rem; opacity: 0.9;">الطلاب</h6>
            <p class="fs-3 fw-bold mb-0">{{ $studentsCount }}</p>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a73e8, #4a8fe7);">
            <h6 class="fw-bold" style="font-size: 0.85rem; opacity: 0.9;">المباني</h6>
            <p class="fs-3 fw-bold mb-0">{{ $buildingsCount }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a2a3a, #2a3a4a);">
            <h6 class="fw-bold" style="font-size: 0.85rem; opacity: 0.9;">القاعات</h6>
            <p class="fs-3 fw-bold mb-0">{{ $roomsCount }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a73e8, #4a8fe7);">
            <h6 class="fw-bold" style="font-size: 0.85rem; opacity: 0.9;">المعامل</h6>
            <p class="fs-3 fw-bold mb-0">{{ $laboratoriesCount }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a2a3a, #2a3a4a);">
            <h6 class="fw-bold" style="font-size: 0.85rem; opacity: 0.9;">الأنظمة الفرعية</h6>
            <p class="fs-3 fw-bold mb-0">{{ $subsystemsCount }}</p>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">
    @if(Auth::user()->hasRole('sys_admin'))
    <div class="col-md-6">
        <div class="card card-custom p-3">
            <h6 class="fw-bold mb-3" style="color: #1a2a3a;"><i class="bi bi-plugin"></i> الأنظمة الفرعية النشطة</h6>
            @if($activeSubsystems->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($activeSubsystems as $sub)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            {{ $sub->name }}
                            <span class="badge" style="background: #1a73e8;">نشط</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted small mb-0">لا توجد أنظمة فرعية نشطة حالياً</p>
            @endif
        </div>
    </div>
    @endif
    @if(Auth::user()->hasRole('sys_admin'))
    <div class="col-md-6">
        <div class="card card-custom p-3">
            <h6 class="fw-bold mb-3" style="color: #1a2a3a;"><i class="bi bi-journal-text"></i> آخر العمليات</h6>
            @if($recentLogs->count() > 0)
                <div style="max-height: 200px; overflow-y: auto;">
                    <table class="table table-sm table-borderless mb-0">
                        @foreach($recentLogs as $log)
                            <tr>
                                <td class="text-muted small">{{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('H:i') : '—' }}</td>
                                <td><span class="badge bg-{{ $log->action == 'CREATED' ? 'success' : ($log->action == 'UPDATED' ? 'warning' : 'danger') }}">{{ $log->action }}</span></td>
                                <td class="small">{{ $log->user_name }}</td>
                                <td class="small text-muted">{{ $log->table_name }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                @endif
            @else
                <p class="text-muted small mb-0">لا توجد عمليات حديثة</p>
            @endif
        </div>
    </div>
</div>
@endsection
