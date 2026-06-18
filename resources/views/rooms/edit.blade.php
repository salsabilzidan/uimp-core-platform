@extends('layouts.master')
@section('title', 'تعديل قاعة')
@section('page-title', 'تعديل بيانات القاعة')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('rooms.update', $room->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">المبنى</label>
                <select name="building_id" class="form-select" required>
                    @foreach($buildings as $b)
                        <option value="{{ $b->id }}" {{ $room->building_id == $b->id ? 'selected' : '' }}>{{ $b->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">رمز القاعة</label>
                <input type="text" name="code" class="form-control" value="{{ $room->code }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (عربي)</label>
                <input type="text" name="name_ar" class="form-control" value="{{ $room->name_ar }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (إنجليزي)</label>
                <input type="text" name="name_en" class="form-control" value="{{ $room->name_en }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الطابق</label>
                <input type="number" name="floor" class="form-control" value="{{ $room->floor }}" min="0" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">السعة</label>
                <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}" min="1" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">النوع</label>
                <select name="type" class="form-select" required>
                    <option value="lecture" {{ $room->type == 'lecture' ? 'selected' : '' }}>قاعة محاضرات</option>
                    <option value="lab" {{ $room->type == 'lab' ? 'selected' : '' }}>معمل</option>
                    <option value="office" {{ $room->type == 'office' ? 'selected' : '' }}>مكتب</option>
                    <option value="meeting" {{ $room->type == 'meeting' ? 'selected' : '' }}>قاعة اجتماعات</option>
                    <option value="auditorium" {{ $room->type == 'auditorium' ? 'selected' : '' }}>مدرج</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">هل هو معمل؟</label>
                <select name="is_lab" class="form-select">
                    <option value="0" {{ !$room->is_lab ? 'selected' : '' }}>لا</option>
                    <option value="1" {{ $room->is_lab ? 'selected' : '' }}>نعم</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">وصف</label>
                <textarea name="description" class="form-control" rows="1">{{ $room->description }}</textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">تحديث</button>
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
