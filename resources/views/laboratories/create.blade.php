@extends('layouts.master')
@section('title', 'إضافة معمل')
@section('page-title', 'إضافة معمل جديد')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('laboratories.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">الاسم (عربي)</label>
                <input type="text" name="name_ar" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الاسم (إنجليزي)</label>
                <input type="text" name="name_en" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">القاعة المرتبطة</label>
                <select name="room_id" class="form-select">
                    <option value="">بدون</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name_ar }} ({{ $room->building->name_ar ?? '' }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">القسم العلمي</label>
                <select name="department_id" class="form-select">
                    <option value="">بدون</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">السعة</label>
                <input type="number" name="capacity" class="form-control" min="1" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة</label>
                <select name="is_active" class="form-select">
                    <option value="1">نشط</option>
                    <option value="0">غير نشط</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">وصف</label>
                <textarea name="description" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">حفظ</button>
            <a href="{{ route('laboratories.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
