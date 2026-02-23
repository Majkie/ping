<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StorePing extends Controller
{
    public function __invoke(StorePingRequest $request): JsonResponse
    {
        // DB insert over Eloquent model to avoid the overhead of creating a model instance for each ping, since we don't need any of the model's features here.
        DB::table('pings')->insert([
            'uuid' => $request->validated('uuid'),
            'battery_percent' => $request->validated('battery_percent'),
        ]);

        return response()->json([
            'status' => 'ok',
        ]);
    }
}
