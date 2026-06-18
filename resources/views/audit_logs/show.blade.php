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
            <p><strong>عنوان IP:</strong> {{ $log->ip_address ?? '—' }}</p>
            <p><strong>المتصفح:</strong> <span class="small">{{ $log->user_agent ?? '—' }}</span></p>
        </div>
    </div>
    @if($log->details)
        <hr>
        <h6 class="fw-bold">التفاصيل:</h6>
        <pre class="bg-light p-3 rounded" style="max-height: 300px; overflow: auto; direction: ltr; text-align: left;">{{ json_encode(json_decode($log->details), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    @endif
    <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary fw-bold px-4 mt-3">عودة</a>
</div>
@endsection
