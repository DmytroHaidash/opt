<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegionResource;
use App\Http\Resources\SettlementResource;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function regions(): JsonResponse
    {
        return response()->json(RegionResource::collection(Region::all()));
    }

    public function settlements(Region $region): JsonResponse
    {
        return response()->json(SettlementResource::collection($region->cities));
    }
}
