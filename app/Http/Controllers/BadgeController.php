<?php

namespace App\Http\Controllers;

use App\Services\ItemCreationService;
use Illuminate\Http\Request;

class badgeController {
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image_url' => 'nullable|url',
        'style' => 'nullable|array',
        'price' => 'nullable|numeric|min:0',
    ]);

    $service = new ItemCreationService();
    $badge = $service->createBadge($validated, $validated['price'] ?? 0);

    return response()->json([
        'message' => 'Badge created successfully!',
        'badge' => $badge
    ]);
}
}
