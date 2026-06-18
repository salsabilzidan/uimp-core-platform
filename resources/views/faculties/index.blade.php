@extends('layouts.master')
@section('title', 'الكليات')
@section('page-title', 'إدارة الكليات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><p class="text-muted mb-0">إدارة الكليات التابعة للنظام المركزي للجامعة</p></div>
    @if(Auth::user()->hasRole('sys_admin'))
        <a href="{{ route('faculties.create') }}" class="btn btn-primary fw-bold px-4 shadow-sm">إضافة كلية جديدة +</a>
    @endif
</div>
<div class="card card-custom p-3">
    <table class="table table-hover text-center align-middle m-0">
        <thead style="background: #1a2a3a; color: #fff;">
            <tr><th>#</th><th>الرمز</th><th>الاسم (عربي)</th><th>الاسم (إنجليزي)</th><th>العمليات</th></tr>
        </thead>
        <tbody>
            @forelse($faculties as $faculty)
                <tr>
                    <td>{{ $faculty->id }}</td>
                    <td><span class="badge bg-secondary fs-6">{{ $faculty->code }}</span></td>
                    <td class="fw-bold">{{ $faculty->name_ar }}</td>
                    <td class="text-muted">{{ $faculty->name_en }}</td>
                    <td>
                        <a href="{{ route('faculties.show', $faculty->id) }}" class="btn btn-sm btn-info fw-bold px-2 me-1">
                            <i class="bi bi-eye"></i> عرض
                        </a>
                        @if(Auth::user()->hasRole('sys_admin'))
                            <a href="{{ route('faculties.edit', $faculty->id) }}" class="btn btn-sm btn-warning fw-bold px-3 me-1">تعديل</a>
                            <form action="{{ route('faculties.destroy', $faculty->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الكلية؟');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger fw-bold px-3">حذف</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-muted p-4">لا توجد كليات مضافة حالياً</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
