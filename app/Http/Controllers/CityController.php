<?php

namespace App\Http\Controllers;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CityController extends Controller {
    public function getCities($state_id) {
        try {
            $cities = City::where('state_id', $state_id)->get();
            return response()->json($cities);
        } catch (\Exception $e) {
            Log::error('Error fetching cities:', ['error' => $e->getMessage(), 'state_id' => $state_id]);
            return response()->json(['error' => 'Failed to fetch cities'], 500);
        }
    }
}
