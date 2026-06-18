@extends('layouts.master')
@section('title', 'تسجيل نظام فرعي')
@section('page-title', 'تسجيل نظام فرعي جديد')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('subsystems.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">اسم النظام</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">المعرف (Slug) - أحرف وأرقام فقط</label>
                <input type="text" name="slug" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">البريد الإلكتروني للتواصل</label>
                <input type="email" name="contact_email" class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">عناوين IP المسموحة (سطر واحد لكل IP)</label>
                <textarea name="allowed_ips" class="form-control" rows="3" placeholder="192.168.1.1&#10;10.0.0.0/24"></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">الصلاحيات الممنوحة (سطر واحد لكل صلاحية)</label>
                <textarea name="permissions" class="form-control" rows="3" placeholder="users.read&#10;rooms.read&#10;laboratories.read"></textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label">رابط Webhook (لإرسال الأحداث)</label>
                <input type="url" name="webhook_url" class="form-control" placeholder="https://lab-system.example.com/api/webhook">
            </div>
        </div>
        <div class="alert alert-info mt-3">
            <i class="bi bi-info-circle"></i> بعد التسجيل، سيتم توليد مفتاح API تلقائياً. يمكنك مشاهدته في صفحة عرض النظام.
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary fw-bold px-4">تسجيل</button>
            <a href="{{ route('subsystems.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
