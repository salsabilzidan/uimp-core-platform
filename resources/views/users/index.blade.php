@extends('layouts.master')
@section('title', 'المستخدمين')
@section('page-title', 'إدارة المستخدمين والصلاحيات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><p class="text-muted mb-0">إدارة حسابات المستخدمين وتحديد صلاحياتهم</p></div>
</div>
<div class="card card-custom p-3">
    <table class="table table-hover text-center align-middle m-0">
        <thead style="background: #1a2a3a; color: #fff;">
            <tr><th>#</th><th>الاسم</th><th>البريد الإلكتروني</th><th>الأدوار</th><th>تاريخ التسجيل</th><th>العمليات</th></tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td class="fw-bold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary">{{ $role->display_name_ar }}</span>
                        @endforeach
                    </td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning fw-bold px-3 me-1">تعديل الصلاحيات</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted p-4">لا يوجد مستخدمين</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection