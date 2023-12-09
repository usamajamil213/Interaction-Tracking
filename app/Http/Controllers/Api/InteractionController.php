<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreInteractionRequest;
use App\Http\Resources\InteractionResource;
use App\Models\Interaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\In;

class InteractionController extends Controller
{
    public function index()
    {
        try {
            $interactions = Interaction::all();
            return InteractionResource::collection($interactions);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function show($id)
    {
        try {
            $interaction = Interaction::find($id);
            if (!$interaction) {
                return response()->json(['error' => 'Interaction not found'], 404);
            }
            return response()->json($interaction);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function store(StoreInteractionRequest $request)
    {
        try {
            $interaction = new  Interaction();
            $interaction->label = $request->label;
            $interaction->type = $request->type;
            $interaction->key = Str::random(5);
            $interaction->user_id = Auth::user()->id;
            $interaction->save();
            return response()->json($interaction, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function update(StoreInteractionRequest $request, $id)
    {
        try {
            $interaction = Interaction::find($id);

            if (!$interaction) {
                return response()->json(['error' => 'Interaction not found'], 404);
            }

            $interaction->label = $request->label;
            $interaction->type = $request->type;
            $interaction->save();
            return response()->json($interaction);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $interaction = Interaction::find($id);

            if (!$interaction) {
                return response()->json(['error' => 'Interaction not found'], 404);
            }

            $interaction->delete();
            return response()->json(['message' => 'Interaction deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}
