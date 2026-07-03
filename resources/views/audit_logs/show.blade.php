@extends('layouts.master')
@section('title', 'تفاصيل السجل')
@section('page-title', 'تفاصيل سجل التدقيق')

@section('content')
<div class="card card-custom p-4">
    <div class="row">
        <div class="col-md-6">
            <p><strong>المعرف:</strong> {{ $log->id }}</p>
            <p><strong>التاريخ:</strong> {{ $log->created_at->format('Y-m-d H:i:s') }}</p>
            <p><strong>المستخدم:</strong> {{ $log->user_name }}</p>
            <p><strong>العملية:</strong> <span class="badge bg-info">{{ $log->action }}</span></p>
        </div>
        <div class="col-md-6">
            <p><strong>الجدول:</strong> <code>{{ $log->table_name }}</code></p>
            <p><strong>النظام الفرعي:</strong> {{ $log->subsystem_slug ?? '—' }}</p>
         
        </div>
    </div>
    @if($log->details)
      
    @endif
    <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary fw-bold px-4 mt-3">عودة</a>
</div>
@endsection
