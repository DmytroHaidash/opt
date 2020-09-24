<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function toggle(Request $request): JsonResponse
    {
        $message = 'added';
        $type = $request->input('type');
        $model = $request->input('model');

        $exists = Auth::user()->favorites()->where([
            'favoritable_type' => $type,
            'favoritable_id' => $model,
        ])->first();

        if ($exists) {
            $exists->delete();
            $message = 'removed';
        } else {
            Auth::user()->favorites()->create([
                'favoritable_type' => $type,
                'favoritable_id' => $model,
            ]);
        }

        return response()->json([
            'status' => $message,
        ]);
    }
}
