@extends('layouts.master')
@section('title', 'عرض موظف')
@section('page-title', 'بيانات الموظف')

@section('content')
<div class="card card-custom p-4">
    <div class="row">
        <div class="col-md-6">
            <p><strong>الاسم:</strong> {{ $employee->user->name }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $employee->user->email }}</p>
            <p><strong>الرقم الوظيفي:</strong> {{ $employee->employee_code }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>القسم:</strong> {{ $employee->department->name_ar ?? '—' }}</p>
            <p><strong>الهاتف:</strong> {{ $employee->phone ?? '—' }}</p>
            <p><strong>تاريخ التسجيل:</strong> {{ $employee->created_at->format('Y-m-d') }}</p>
        </div>
    </div>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary fw-bold px-4 mt-3">عودة</a>
</div>
@endsection
