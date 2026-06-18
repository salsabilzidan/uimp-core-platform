<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subsystem;
use Illuminate\Http\Request;

class SubsystemController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'slug'          => 'required|alpha_dash|unique:subsystems,slug|max:100',
            'description'   => 'nullable',
            'contact_email' => 'nullable|email',
        ]);

        $subsystem = Subsystem::create([
            'name'                => $request->name,
            'slug'                => $request->slug,
            'description'         => $request->description,
            'contact_email'       => $request->contact_email,
            'api_key'             => \Illuminate\Support\Str::random(64),
            'api_key_generated_at' => now(),
            'is_active'           => true,
            'metadata'            => $request->webhook_url ? ['webhook_url' => $request->webhook_url] : null,
        ]);

        return response()->json([
            'message' => 'Subsystem registered successfully',
            'subsystem' => $subsystem,
            'api_key' => $subsystem->api_key,
        ], 201);
    }

    public function health()
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now(),
            'version' => '1.0.0',
            'name' => config('app.name'),
        ]);
    }
}
