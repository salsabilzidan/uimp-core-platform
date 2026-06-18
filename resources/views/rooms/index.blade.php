@extends('layouts.master')
@section('title', 'القاعات')
@section('page-title', 'إدارة القاعات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><p class="text-muted mb-0">إدارة القاعات الدراسية والمعامل في جميع المباني</p></div>
    @if(Auth::user()->hasRole('sys_admin'))
        <a href="{{ route('rooms.create') }}" class="btn btn-primary fw-bold px-4 shadow-sm">إضافة قاعة جديدة +</a>
    @endif
</div>
<div class="card card-custom p-3">
    <table class="table table-hover text-center align-middle m-0">
        <thead style="background: #1a2a3a; color: #fff;">
            <tr><th>#</th><th>الرمز</th><th>الاسم</th><th>المبنى</th><th>الطابق</th><th>السعة</th><th>النوع</th><th>معمل</th><th>العمليات</th></tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td><span class="badge bg-secondary">{{ $room->code }}</span></td>
                    <td class="fw-bold">{{ $room->name_ar }}</td>
                    <td>{{ $room->building->name_ar ?? '—' }}</td>
                    <td>{{ $room->floor }}</td>
                    <td>{{ $room->capacity }}</td>
                    <td>{{ $room->type }}</td>
                    <td>{!! $room->is_lab ? '<span class="badge bg-success">نعم</span>' : '<span class="badge bg-secondary">لا</span>' !!}</td>
                    <td>
                        <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-sm btn-info fw-bold px-2 me-1">
                            <i class="bi bi-eye"></i> عرض
                        </a>
                        @if(Auth::user()->hasRole('sys_admin'))
                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-warning fw-bold px-2">تعديل</a>
                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد؟');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger fw-bold px-2">حذف</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-muted p-4">لا توجد قاعات مضافة حالياً</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
