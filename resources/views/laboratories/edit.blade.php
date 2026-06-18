@extends('layouts.master')
@section('title', 'تعديل معمل')
@section('page-title', 'تعديل بيانات المعمل')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('laboratories.update', $laboratory->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">الاسم (عربي)</label>
                <input type="text" name="name_ar" class="form-control" value="{{ $laboratory->name_ar }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (إنجليزي)</label>
                <input type="text" name="name_en" class="form-control" value="{{ $laboratory->name_en }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">القاعة المرتبطة</label>
                <select name="room_id" class="form-select">
                    <option value="">بدون</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ $laboratory->room_id == $room->id ? 'selected' : '' }}>{{ $room->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">القسم العلمي</label>
                <select name="department_id" class="form-select">
                    <option value="">بدون</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $laboratory->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">السعة</label>
                <input type="number" name="capacity" class="form-control" value="{{ $laboratory->capacity }}" min="1" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $laboratory->is_active ? 'selected' : '' }}>نشط</option>
                    <option value="0" {{ !$laboratory->is_active ? 'selected' : '' }}>غير نشط</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">وصف</label>
                <textarea name="description" class="form-control" rows="2">{{ $laboratory->description }}</textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">تحديث</button>
            <a href="{{ route('laboratories.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
