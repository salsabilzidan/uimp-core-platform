@extends('layouts.master')
@section('title', 'المعامل')
@section('page-title', 'إدارة المعامل')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><p class="text-muted mb-0">إدارة المعامل التابعة للجامعة والمربوطة بالقاعات</p></div>
    @if(Auth::user()->hasRole('sys_admin'))
        <a href="{{ route('laboratories.create') }}" class="btn btn-primary fw-bold px-4 shadow-sm">إضافة معمل جديد +</a>
    @endif
</div>
<div class="card card-custom p-3">
    <table class="table table-hover text-center align-middle m-0">
        <thead style="background: #1a2a3a; color: #fff;">
            <tr><th>#</th><th>الاسم</th><th>القاعة المرتبطة</th><th>المبنى</th><th>القسم</th><th>السعة</th><th>الحالة</th><th>العمليات</th></tr>
        </thead>
        <tbody>
            @forelse($laboratories as $lab)
                <tr>
                    <td>{{ $lab->id }}</td>
                    <td class="fw-bold">{{ $lab->name_ar }}</td>
                    <td>{{ $lab->room->name_ar ?? '—' }}</td>
                    <td>{{ $lab->room->building->name_ar ?? '—' }}</td>
                    <td>{{ $lab->department->name_ar ?? '—' }}</td>
                    <td>{{ $lab->capacity }}</td>
                    <td>{!! $lab->is_active ? '<span class="badge bg-success">نشط</span>' : '<span class="badge bg-danger">غير نشط</span>' !!}</td>
                    <td>
                        <a href="{{ route('laboratories.show', $lab->id) }}" class="btn btn-sm btn-info fw-bold px-2 me-1">
                            <i class="bi bi-eye"></i> عرض
                        </a>
                        @if(Auth::user()->hasRole('sys_admin'))
                            <a href="{{ route('laboratories.edit', $lab->id) }}" class="btn btn-sm btn-warning fw-bold px-2">تعديل</a>
                            <form action="{{ route('laboratories.destroy', $lab->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد؟');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger fw-bold px-2">حذف</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-muted p-4">لا توجد معامل مضافة حالياً</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
