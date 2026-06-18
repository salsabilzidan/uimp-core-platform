@extends('layouts.master')
@section('title', 'عرض طالب')
@section('page-title', 'بيانات الطالب')

@section('content')
<div class="card card-custom p-4">
    <div class="row">
        <div class="col-md-6">
            <p><strong>الاسم:</strong> {{ $student->user->name }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $student->user->email }}</p>
            <p><strong>الرقم الجامعي:</strong> {{ $student->student_code }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>القسم:</strong> {{ $student->department->name_ar ?? '—' }}</p>
            <p><strong>السنة الدراسية:</strong> {{ $student->academic_year }}</p>
            <p><strong>تاريخ التسجيل:</strong> {{ $student->created_at->format('Y-m-d') }}</p>
        </div>
    </div>
    <a href="{{ route('students.index') }}" class="btn btn-secondary fw-bold px-4 mt-3">عودة</a>
</div>
@endsection
