<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\InteractionEventRequest;
use App\Http\Requests\Api\StoreInteractionRequest;
use App\Http\Resources\InteractionResource;
use App\Models\Interaction;
use App\Models\InteractionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\In;

class InteractionController extends Controller
{
    public function index()
    {
        try {
            $interactions = Interaction::where('user_id',Auth::user()->id)->get();
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

    public function simulateEvent(InteractionEventRequest $request, $id)
    {
        try{
            $interaction = Interaction::find($id);

            if (!$interaction) {
                return response()->json(['error' => 'Interaction not found'], 404);
            }
            $interactionEvent = new InteractionEvent();
            $interactionEvent->interaction_id = $interaction->id;
            $interactionEvent->event_type = $request->event_type;
            $interactionEvent->user_id = Auth::user()->id;
            $interactionEvent->save();
            return response()->json(['message' => 'Simulated interaction event recorded']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }

    }
    public function getStatistics($id, Request $request)
    {
        $interaction = Interaction::find($id);

        if (!$interaction) {
            return response()->json(['error' => 'Interaction not found'], 404);
        }

        $query = DB::table('interaction_events')
            ->where('interaction_id', $interaction->id)
            ->groupBy('event_type')
            ->select('event_type', DB::raw('count(*) as count'));

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }

        $statistics = $query->get();
        return response()->json(['statistics' => $statistics]);
    }
}
