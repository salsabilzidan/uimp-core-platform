@extends('layouts.master')
@section('title', 'المباني')
@section('page-title', 'إدارة المباني')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><p class="text-muted mb-0">إدارة المباني التابعة للجامعة</p></div>
    @if(Auth::user()->hasRole('sys_admin'))
        <a href="{{ route('buildings.create') }}" class="btn btn-primary fw-bold px-4 shadow-sm">إضافة مبنى جديد +</a>
    @endif
</div>
<div class="card card-custom p-3">
    <table class="table table-hover text-center align-middle m-0">
        <thead style="background: #1a2a3a; color: #fff;">
            <tr><th>#</th><th>الرمز</th><th>الاسم (عربي)</th><th>الاسم (إنجليزي)</th><th>الموقع</th><th>عدد الطوابق</th><th>القاعات</th><th>العمليات</th></tr>
        </thead>
        <tbody>
            @forelse($buildings as $building)
                <tr>
                    <td>{{ $building->id }}</td>
                    <td><span class="badge bg-secondary">{{ $building->code }}</span></td>
                    <td class="fw-bold">{{ $building->name_ar }}</td>
                    <td>{{ $building->name_en }}</td>
                    <td>{{ $building->location ?? '—' }}</td>
                    <td>{{ $building->floors }}</td>
                    <td><span class="badge bg-info">{{ $building->rooms_count }}</span></td>
                    <td>
                        <a href="{{ route('buildings.show', $building->id) }}" class="btn btn-sm btn-info fw-bold px-2 me-1">عرض</a>
                        @if(Auth::user()->hasRole('sys_admin'))
                            <a href="{{ route('buildings.edit', $building->id) }}" class="btn btn-sm btn-warning fw-bold px-2 me-1">تعديل</a>
                            <form action="{{ route('buildings.destroy', $building->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد؟');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger fw-bold px-2">حذف</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-muted p-4">لا توجد مباني مضافة حالياً</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
