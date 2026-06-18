@extends('layouts.master')
@section('title', 'عرض نظام فرعي')
@section('page-title', 'تفاصيل النظام الفرعي')

@section('content')
<div class="card card-custom p-4">
    <div class="row">
        <div class="col-md-6">
            <p><strong>الاسم:</strong> {{ $subsystem->name }}</p>
            <p><strong>المعرف:</strong> <span class="badge bg-secondary">{{ $subsystem->slug }}</span></p>
            <p><strong>البريد الإلكتروني:</strong> {{ $subsystem->contact_email ?? '—' }}</p>
            <p><strong>الحالة:</strong> {!! $subsystem->is_active ? '<span class="badge bg-success">نشط</span>' : '<span class="badge bg-danger">غير نشط</span>' !!}</p>
        </div>
        <div class="col-md-6">
            <p><strong>مفتاح API:</strong></p>
            <div class="input-group mb-2">
                <input type="text" class="form-control font-monospace small" id="apiKey" value="{{ $subsystem->api_key }}" readonly>
                <button class="btn btn-outline-secondary" type="button" onclick="copyApiKey()">نسخ</button>
            </div>
            <p class="text-muted small">تاريخ التوليد: {{ $subsystem->api_key_generated_at ? $subsystem->api_key_generated_at->format('Y-m-d H:i') : '—' }}</p>
            <form action="{{ route('subsystems.regenerate-key', $subsystem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من إعادة توليد المفتاح؟ سيفقد المفتاح القديم صلاحيته فوراً.');">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm fw-bold">إعادة توليد المفتاح</button>
            </form>
        </div>
    </div>
    @if($subsystem->allowed_ips)
        <hr>
        <h6 class="fw-bold">عناوين IP المسموحة:</h6>
        <ul>
            @foreach($subsystem->allowed_ips as $ip)
                <li><code>{{ $ip }}</code></li>
            @endforeach
        </ul>
    @endif
    @if($subsystem->permissions)
        <hr>
        <h6 class="fw-bold">الصلاحيات:</h6>
        <ul>
            @foreach($subsystem->permissions as $perm)
                <li><span class="badge bg-info">{{ $perm }}</span></li>
            @endforeach
        </ul>
    @endif
    @if($subsystem->metadata && ($subsystem->metadata['webhook_url'] ?? null))
        <hr>
        <h6 class="fw-bold">رابط Webhook:</h6>
        <p><code>{{ $subsystem->metadata['webhook_url'] }}</code></p>
    @endif
    <a href="{{ route('subsystems.index') }}" class="btn btn-secondary fw-bold px-4 mt-3">عودة</a>
</div>
<script>
function copyApiKey() {
    var input = document.getElementById('apiKey');
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value);
}
</script>
@endsection
