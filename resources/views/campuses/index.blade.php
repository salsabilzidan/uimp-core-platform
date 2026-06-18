@extends('layouts.master')
@section('title', 'الحرم الجامعي')
@section('page-title', 'إدارة الحرم الجامعي')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><p class="text-muted mb-0">إدارة أحرم الجامعة التابعة للنظام المركزي</p></div>
    @if(Auth::user()->hasRole('sys_admin'))
        <a href="{{ route('campuses.create') }}" class="btn btn-primary fw-bold px-4 shadow-sm">إضافة حرم جديد +</a>
    @endif
</div>
<div class="card card-custom p-3">
    <table class="table table-hover text-center align-middle m-0">
        <thead style="background: #1a2a3a; color: #fff;">
            <tr><th>#</th><th>الاسم (عربي)</th><th>الاسم (إنجليزي)</th><th>الموقع</th><th>العمليات</th></tr>
        </thead>
        <tbody>
            @forelse($campuses as $campus)
                <tr>
                    <td>{{ $campus->id }}</td>
                    <td class="fw-bold">{{ $campus->name_ar }}</td>
                    <td class="text-muted">{{ $campus->name_en }}</td>
                    <td><span class="badge bg-secondary">{{ $campus->location ?? '—' }}</span></td>
                    <td>
                        <a href="{{ route('campuses.show', $campus->id) }}" class="btn btn-sm btn-info fw-bold px-2 me-1">
                            <i class="bi bi-eye"></i> عرض
                        </a>
                        @if(Auth::user()->hasRole('sys_admin'))
                            <a href="{{ route('campuses.edit', $campus->id) }}" class="btn btn-sm btn-warning fw-bold px-3 me-1">تعديل</a>
                            <form action="{{ route('campuses.destroy', $campus->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الحرم؟');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger fw-bold px-3">حذف</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-muted p-4">لا توجد أحرم جامعية مضافة حالياً</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
