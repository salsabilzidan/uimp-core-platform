@extends('layouts.master')
@section('title', 'الأقسام')
@section('page-title', 'إدارة الأقسام العلمية')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><p class="text-muted mb-0">إدارة الأقسام العلمية التابعة للكليات</p></div>
    @if(Auth::user()->hasRole('sys_admin'))
        <a href="{{ route('departments.create') }}" class="btn btn-primary fw-bold px-4 shadow-sm">إضافة قسم جديد +</a>
    @endif
</div>
<div class="card card-custom p-3">
    <table class="table table-hover text-center align-middle m-0">
        <thead style="background: #1a2a3a; color: #fff;">
            <tr><th>#</th><th>الرمز</th><th>الاسم (عربي)</th><th>الاسم (إنجليزي)</th><th>الكلية</th><th>العمليات</th></tr>
        </thead>
        <tbody>
            @forelse($departments as $dept)
                <tr>
                    <td>{{ $dept->id }}</td>
                    <td><span class="badge bg-secondary">{{ $dept->code }}</span></td>
                    <td class="fw-bold">{{ $dept->name_ar }}</td>
                    <td>{{ $dept->name_en }}</td>
                    <td>{{ $dept->faculty->name_ar ?? '—' }}</td>
                    <td>
                        <a href="{{ route('departments.show', $dept->id) }}" class="btn btn-sm btn-info fw-bold px-2 me-1">
                            <i class="bi bi-eye"></i> عرض
                        </a>
                        @if(Auth::user()->hasRole('sys_admin'))
                            <a href="{{ route('departments.edit', $dept->id) }}" class="btn btn-sm btn-warning fw-bold px-3 me-1">تعديل</a>
                            <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد؟');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger fw-bold px-3">حذف</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted p-4">لا توجد أقسام مضافة حالياً</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
