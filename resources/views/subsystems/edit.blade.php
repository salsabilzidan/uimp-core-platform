@extends('layouts.master')
@section('title', 'تعديل نظام فرعي')
@section('page-title', 'تعديل بيانات النظام الفرعي')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('subsystems.update', $subsystem->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">اسم النظام</label>
                <input type="text" name="name" class="form-control" value="{{ $subsystem->name }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">المعرف (Slug)</label>
                <input type="text" name="slug" class="form-control" value="{{ $subsystem->slug }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="contact_email" class="form-control" value="{{ $subsystem->contact_email }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">الحالة</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $subsystem->is_active ? 'selected' : '' }}>نشط</option>
                    <option value="0" {{ !$subsystem->is_active ? 'selected' : '' }}>غير نشط</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control" rows="2">{{ $subsystem->description }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">عناوين IP المسموحة</label>
                <textarea name="allowed_ips" class="form-control" rows="3">{{ $subsystem->allowed_ips ? implode("\n", $subsystem->allowed_ips) : '' }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">الصلاحيات</label>
                <textarea name="permissions" class="form-control" rows="3">{{ $subsystem->permissions ? implode("\n", $subsystem->permissions) : '' }}</textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label">رابط Webhook (لإرسال الأحداث)</label>
                <input type="url" name="webhook_url" class="form-control" value="{{ $subsystem->metadata['webhook_url'] ?? '' }}" placeholder="https://lab-system.example.com/api/webhook">
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary fw-bold px-4">تحديث</button>
            <a href="{{ route('subsystems.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
