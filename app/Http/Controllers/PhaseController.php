<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhaseRequest;
use App\Http\Requests\UpdatePhaseRequest;
use App\Models\Phase;
use App\Models\Task;
use Carbon\Carbon;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Phase $phase)
    {
        return $phase->load('tasks.user')->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Phase $phase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhaseRequest $request, Phase $phase)
    {
        try {
            $phase = Phase::query()->find($phase->id);
            if (!$phase)
                return response()->json(['message' => 'No phase found!'], 404);

            $phase->tasks()->update([
                'completed_at' => Carbon::now(),
            ]);

            $phase->update([
                'completed_at' => Carbon::now(),
            ]);

            return response()->json(['message' => 'Phase marked as completed successfully.']);
        }
        catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phase $phase)
    {
        try {
            $phase = Phase::query()->find($phase->id);
            if (!$phase)
                return response()->json(['message' => 'No phase found!'], 404);

            $phase->destroy($phase->id);

            return response()->json(['message' => 'Phase removed successfully.']);
        }
        catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
