<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subsystem;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function issueToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_key' => 'required|string',
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $subsystem = Subsystem::where('api_key', $request->api_key)
            ->where('is_active', true)
            ->first();

        if (!$subsystem) {
            AuditLog::create([
                'user_name' => 'System',
                'action' => 'API_AUTH_FAILED',
                'table_name' => 'subsystems',
                'details' => 'Invalid or inactive API key used',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'subsystem_slug' => 'unknown',
            ]);

            return response()->json(['error' => 'مفتاح API غير صالح أو غير نشط'], 401);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'بيانات الدخول غير صحيحة'], 401);
        }

        $token = $user->createToken('subsystem-' . $subsystem->slug)->plainTextToken;

        AuditLog::create([
            'user_name' => $user->name,
            'action' => 'API_TOKEN_ISSUED',
            'table_name' => 'users',
            'details' => "Token issued for subsystem: {$subsystem->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'subsystem_slug' => $subsystem->slug,
        ]);

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name'),
            ]
        ]);
    }

    public function verifyToken(Request $request)
    {
        return response()->json([
            'valid' => true,
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'roles' => $request->user()->roles->pluck('name'),
            ]
        ]);
    }
}
