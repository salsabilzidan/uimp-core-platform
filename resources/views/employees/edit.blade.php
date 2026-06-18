@extends('layouts.master')
@section('title', 'تعديل موظف')
@section('page-title', 'تعديل بيانات الموظف')

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">الاسم الكامل</label>
                <input type="text" name="name" class="form-control" value="{{ $employee->user->name }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" value="{{ $employee->user->email }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">كلمة المرور (اترك فارغاً للتغيير)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">القسم</label>
                <select name="department_id" class="form-select" required>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $employee->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الرقم الوظيفي</label>
                <input type="text" name="employee_code" class="form-control" value="{{ $employee->employee_code }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">نوع الحساب</label>
                <select name="role" class="form-select" required>
                    <option value="">اختر نوع الحساب</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $employee->user->roles->contains('id', $role->id) ? 'selected' : '' }}>{{ $role->display_name_ar }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr class="my-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-shield-check"></i> صلاحيات المشاهدة</h6>
        <p class="text-muted small mb-3">اختر الوحدات التي يمكن لهذا الموظف مشاهدتها:</p>
        <div class="row g-2">
            @php $userPermIds = $employee->user->permissions->pluck('id')->toArray(); @endphp
            @foreach($permissions as $module => $modPerms)
                @php $first = $modPerms->first(); @endphp
                @if(str_contains($first->name, '.view'))
                <div class="col-md-3">
                    <div class="form-check">
                        <input type="checkbox" name="permissions[]" value="{{ $first->id }}" class="form-check-input" id="perm_{{ $module }}" {{ in_array($first->id, $userPermIds) ? 'checked' : '' }}>
                        <label class="form-check-label" for="perm_{{ $module }}">{{ $first->display_name_ar }}</label>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">تحديث</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection
