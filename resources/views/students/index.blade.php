@extends('layouts.master')
@section('title', 'الطلاب')
@section('page-title', 'إدارة الطلاب')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">عرض وإدارة بيانات الطلاب المسجلين في النظام المركزي</p>
    </div>
    @if(Auth::user()->hasRole('sys_admin'))
        <a href="{{ route('students.create') }}" class="btn btn-primary fw-bold px-4 shadow-sm">إضافة طالب جديد +</a>
    @endif
</div>

<div class="card card-custom p-3">
    <table class="table table-hover text-center align-middle m-0">
        <thead style="background: #1a2a3a; color: #fff;">
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الرقم الجامعي</th>
                <th>القسم</th>
                <th>السنة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td class="fw-bold">{{ $student->user->name }}</td>
                    <td>{{ $student->user->email }}</td>
                    <td><span class="badge bg-secondary">{{ $student->student_code }}</span></td>
                    <td>{{ $student->department->name_ar ?? '—' }}</td>
                    <td>{{ $student->academic_year }}</td>
                    <td>
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info fw-bold px-2 me-1">
                            <i class="bi bi-eye"></i> عرض
                        </a>
                        @if(Auth::user()->hasRole('sys_admin'))
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning fw-bold px-3">تعديل</a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطالب؟');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger fw-bold px-3">حذف</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-muted p-4">لا يوجد طلاب مسجلين حالياً</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
