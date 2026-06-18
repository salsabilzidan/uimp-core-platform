@extends('layouts.master')
@section('title', 'الموظفين')
@section('page-title', 'إدارة الموظفين')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><p class="text-muted mb-0">إدارة أعضاء هيئة التدريس والموظفين</p></div>
    @if(Auth::user()->hasRole('sys_admin'))
        <a href="{{ route('employees.create') }}" class="btn btn-primary fw-bold px-4 shadow-sm">إضافة موظف جديد +</a>
    @endif
</div>
<div class="card card-custom p-3">
    <table class="table table-hover text-center align-middle m-0">
        <thead style="background: #1a2a3a; color: #fff;">
            <tr><th>#</th><th>الاسم</th><th>البريد الإلكتروني</th><th>الرقم الوظيفي</th><th>القسم</th><th>الهاتف</th><th>العمليات</th></tr>
        </thead>
        <tbody>
            @forelse($employees as $emp)
                <tr>
                    <td>{{ $emp->id }}</td>
                    <td class="fw-bold">{{ $emp->user->name }}</td>
                    <td>{{ $emp->user->email }}</td>
                    <td><span class="badge bg-secondary">{{ $emp->employee_code }}</span></td>
                    <td>{{ $emp->department->name_ar ?? '—' }}</td>
                    <td>{{ $emp->phone ?? '—' }}</td>
                    <td>
                        <a href="{{ route('employees.show', $emp->id) }}" class="btn btn-sm btn-info fw-bold px-2 me-1">
                            <i class="bi bi-eye"></i> عرض
                        </a>
                        @if(Auth::user()->hasRole('sys_admin'))
                            <a href="{{ route('employees.edit', $emp->id) }}" class="btn btn-sm btn-warning fw-bold px-3 me-1">تعديل</a>
                            <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد؟');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger fw-bold px-3">حذف</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-muted p-4">لا يوجد موظفين مسجلين</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
