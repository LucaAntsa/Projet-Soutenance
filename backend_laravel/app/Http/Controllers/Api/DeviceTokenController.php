<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'device_type' => 'nullable|string|max:50',
        ]);

        $deviceToken = DeviceToken::updateOrCreate(
            [
                'token' => $validated['token'],
            ],
            [
                'user_id' => $request->user()->id,
                'device_type' => $validated['device_type'] ?? null,
            ]
        );

        return response()->json([
            'message' => 'Token enregistré avec succès.',
            'device_token' => $deviceToken,
        ]);
    }
}
