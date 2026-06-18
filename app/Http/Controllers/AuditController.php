<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::query();

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('table_name')) {
            $query->where('table_name', $request->table_name);
        }

        if ($request->filled('user_name')) {
            $query->where('user_name', 'like', '%' . $request->user_name . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->paginate(50);

        $actions = AuditLog::select('action')->distinct()->pluck('action');
        $tables = AuditLog::select('table_name')->distinct()->pluck('table_name');

        return view('audit_logs.index', compact('logs', 'actions', 'tables'));
    }

    public function show(string $id)
    {
        $log = AuditLog::findOrFail($id);
        return view('audit_logs.show', compact('log'));
    }
}
