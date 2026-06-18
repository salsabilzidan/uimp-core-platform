@extends('layouts.master')
@section('title', 'الأنظمة الفرعية')
@section('page-title', 'سجل الأنظمة الفرعية')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><p class="text-muted mb-0">إدارة الأنظمة الفرعية المسجلة والمتصلة بالنظام المركزي</p></div>
    @if(Auth::user()->hasRole('sys_admin'))
    <a href="{{ route('subsystems.create') }}" class="btn btn-primary fw-bold px-4 shadow-sm">تسجيل نظام جديد +</a>
    @endif
</div>
<div class="card card-custom p-3">
    <table class="table table-hover text-center align-middle m-0">
        <thead style="background: #1a2a3a; color: #fff;">
            <tr><th>#</th><th>الاسم</th><th>المعرف (Slug)</th><th>البريد الإلكتروني</th><th>API Key</th><th>الحالة</th><th>العمليات</th></tr>
        </thead>
        <tbody>
            @forelse($subsystems as $sub)
                <tr>
                    <td>{{ $sub->id }}</td>
                    <td class="fw-bold">{{ $sub->name }}</td>
                    <td><span class="badge bg-secondary">{{ $sub->slug }}</span></td>
                    <td>{{ $sub->contact_email ?? '—' }}</td>
                    <td>
                        <code class="small">{{ substr($sub->api_key, 0, 20) }}...</code>
                    </td>
                    <td>{!! $sub->is_active ? '<span class="badge bg-success">نشط</span>' : '<span class="badge bg-danger">غير نشط</span>' !!}</td>
                    <td>
                        <a href="{{ route('subsystems.show', $sub->id) }}" class="btn btn-sm btn-info fw-bold px-2 me-1">عرض</a>
                        <a href="{{ route('subsystems.edit', $sub->id) }}" class="btn btn-sm btn-warning fw-bold px-2 me-1">تعديل</a>
                        <form action="{{ route('subsystems.destroy', $sub->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد؟');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger fw-bold px-2">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-muted p-4">لا توجد أنظمة فرعية مسجلة</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
