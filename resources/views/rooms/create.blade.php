@extends('layouts.master')
@section('title', 'إضافة قاعة')
@section('page-title', 'إضافة قاعة جديدة')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">المبنى</label>
                <select name="building_id" class="form-select" required>
                    <option value="">اختر المبنى</option>
                    @foreach($buildings as $b)
                        <option value="{{ $b->id }}">{{ $b->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">رمز القاعة</label>
                <input type="text" name="code" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (عربي)</label>
                <input type="text" name="name_ar" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (إنجليزي)</label>
                <input type="text" name="name_en" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الطابق</label>
                <input type="number" name="floor" class="form-control" min="0" value="0" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">السعة</label>
                <input type="number" name="capacity" class="form-control" min="1" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">النوع</label>
                <select name="type" class="form-select" required>
                    <option value="lecture">قاعة محاضرات</option>
                    <option value="lab">معمل</option>
                    <option value="office">مكتب</option>
                    <option value="meeting">قاعة اجتماعات</option>
                    <option value="auditorium">مدرج</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">هل هو معمل؟</label>
                <select name="is_lab" class="form-select">
                    <option value="0">لا</option>
                    <option value="1">نعم</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">وصف</label>
                <textarea name="description" class="form-control" rows="1"></textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">حفظ</button>
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
