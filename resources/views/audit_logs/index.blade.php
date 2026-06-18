@extends('layouts.master')
@section('title', 'سجل التدقيق')
@section('page-title', 'سجل التدقيق - Audit Log')

@section('content')
<div class="card card-custom p-3 mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-2">
            <label class="form-label small">العملية</label>
            <select name="action" class="form-select form-select-sm">
                <option value="">الكل</option>
                @foreach($actions as $act)
                    <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>{{ $act }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">الجدول</label>
            <select name="table_name" class="form-select form-select-sm">
                <option value="">الكل</option>
                @foreach($tables as $tbl)
                    <option value="{{ $tbl }}" {{ request('table_name') == $tbl ? 'selected' : '' }}>{{ $tbl }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">اسم المستخدم</label>
            <input type="text" name="user_name" class="form-control form-control-sm" value="{{ request('user_name') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label small">من تاريخ</label>
            <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label small">إلى تاريخ</label>
            <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-sm w-100">بحث</button>
        </div>
    </form>
</div>

<div class="card card-custom p-3">
    <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
        <table class="table table-hover table-sm text-center m-0">
            <thead style="position: sticky; top: 0; background: #1a2a3a; color: #fff;">
                <tr>
                    <th>#</th>
                    <th>التاريخ</th>
                    <th>المستخدم</th>
                    <th>العملية</th>
                    <th>الجدول</th>
                    <th>النظام الفرعي</th>
                    <th>IP</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td class="small">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $log->user_name }}</td>
                        <td>
                            <span class="badge bg-{{ $log->action == 'Created' ? 'success' : ($log->action == 'Updated' ? 'warning' : ($log->action == 'Deleted' ? 'danger' : 'info')) }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td><code>{{ $log->table_name }}</code></td>
                        <td>{{ $log->subsystem_slug ?? '—' }}</td>
                        <td class="small">{{ $log->ip_address ?? '—' }}</td>
                        <td>
                            <a href="{{ route('audit-logs.show', $log->id) }}" class="btn btn-sm btn-outline-info">عرض</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-muted p-4">لا توجد سجلات</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($logs->hasPages())
    <div class="mt-3">{{ $logs->links() }}</div>
@endif
@endsection
