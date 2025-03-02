<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StateController extends Controller {
    public function index() {
        try {
            return response()->json(State::all());
        } catch (\Exception $e) {
            Log::error('Error fetching states: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load states.'], 500);
        }
    }
}
