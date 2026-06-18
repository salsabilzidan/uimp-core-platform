@extends('layouts.master')
@section('title', 'تعديل صلاحيات المستخدم')
@section('page-title', 'تعديل صلاحيات المستخدم: ' . $user->name)

@section('content')
<div class="card card-custom p-4">
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf @method('PUT')

        <h6 class="fw-bold mb-3"><i class="bi bi-person-badge"></i> الأدوار</h6>
        <div class="row g-3 mb-4">
            @foreach($roles as $role)
                <div class="col-md-3">
                    <div class="form-check">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-check-input" id="role_{{ $role->id }}"
                            {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->display_name_ar }}</label>
                    </div>
                </div>
            @endforeach
        </div>

        <hr>
        <h6 class="fw-bold mb-3"><i class="bi bi-shield-check"></i> صلاحيات المشاهدة</h6>
        <p class="text-muted small mb-3">اختر الوحدات التي يمكن لهذا المستخدم مشاهدتها:</p>
        @php $userPermIds = $user->permissions->pluck('id')->toArray(); @endphp
        <div class="row g-2">
            @foreach($permissions as $module => $modPerms)
                @php $first = $modPerms->first(); @endphp
                @if(str_contains($first->name, '.view'))
                <div class="col-md-3">
                    <div class="form-check">
                        <input type="checkbox" name="permissions[]" value="{{ $first->id }}" class="form-check-input" id="perm_{{ $module }}"
                            {{ in_array($first->id, $userPermIds) ? 'checked' : '' }}>
                        <label class="form-check-label" for="perm_{{ $module }}">{{ $first->display_name_ar }}</label>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary fw-bold px-4">حفظ التغييرات</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary fw-bold px-4">إلغاء</a>
        </div>
    </form>
</div>
@endsection