<?php

namespace App\Http\Controllers;

use App\Models\Subsystem;
use App\Services\EventBusService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubsystemController extends Controller
{
    public function index()
    {
        $subsystems = Subsystem::all();
        return view('subsystems.index', compact('subsystems'));
    }

    public function create()
    {
        return view('subsystems.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'slug'          => 'required|alpha_dash|unique:subsystems,slug|max:100',
            'description'   => 'nullable',
            'contact_email' => 'nullable|email',
            'allowed_ips'   => 'nullable',
            'permissions'   => 'nullable',
        ]);

        $data = $request->all();
        $data['api_key'] = Str::random(64);
        $data['api_key_generated_at'] = now();
        $data['allowed_ips'] = $request->allowed_ips ? array_map('trim', explode("\n", $request->allowed_ips)) : null;
        $data['permissions'] = $request->permissions ? array_map('trim', explode("\n", $request->permissions)) : null;
        $data['metadata'] = $request->webhook_url ? ['webhook_url' => $request->webhook_url] : null;

        $subsystem = Subsystem::create($data);

        app(EventBusService::class)->dispatch('subsystem.created', [
            'subsystem_id' => $subsystem->id,
            'name' => $subsystem->name,
            'slug' => $subsystem->slug,
        ]);

        return redirect()->route('subsystems.index')->with('success', 'تم تسجيل النظام الفرعي بنجاح!');
    }

    public function show(string $id)
    {
        $subsystem = Subsystem::findOrFail($id);
        return view('subsystems.show', compact('subsystem'));
    }

    public function edit(string $id)
    {
        $subsystem = Subsystem::findOrFail($id);
        return view('subsystems.edit', compact('subsystem'));
    }

    public function update(Request $request, string $id)
    {
        $subsystem = Subsystem::findOrFail($id);

        $request->validate([
            'name'          => 'required|max:255',
            'slug'          => 'required|alpha_dash|unique:subsystems,slug,' . $id . '|max:100',
            'description'   => 'nullable',
            'contact_email' => 'nullable|email',
            'is_active'     => 'boolean',
        ]);

        $data = $request->all();
        $data['allowed_ips'] = $request->allowed_ips ? array_map('trim', explode("\n", $request->allowed_ips)) : null;
        $data['permissions'] = $request->permissions ? array_map('trim', explode("\n", $request->permissions)) : null;
        $data['metadata'] = $request->webhook_url ? ['webhook_url' => $request->webhook_url] : null;

        $subsystem->update($data);

        app(EventBusService::class)->dispatch('subsystem.updated', [
            'subsystem_id' => $subsystem->id,
            'slug' => $subsystem->slug,
            'name' => $subsystem->name,
        ]);

        return redirect()->route('subsystems.index')->with('success', 'تم تحديث بيانات النظام الفرعي بنجاح!');
    }

    public function regenerateKey(string $id)
    {
        $subsystem = Subsystem::findOrFail($id);
        $subsystem->api_key = Str::random(64);
        $subsystem->api_key_generated_at = now();
        $subsystem->save();

        return redirect()->route('subsystems.show', $id)->with('success', 'تم إعادة توليد مفتاح API بنجاح!');
    }

    public function destroy(string $id)
    {
        $subsystem = Subsystem::findOrFail($id);
        $subsystemId = $subsystem->id;
        $subsystem->delete();

        app(EventBusService::class)->dispatch('subsystem.deleted', [
            'subsystem_id' => $subsystemId,
        ]);

        return redirect()->route('subsystems.index')->with('success', 'تم حذف النظام الفرعي من النظام!');
    }
}
