<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewPlanningRequest;
use App\Http\Requests\UpdatePlanningRecipe;
use App\Http\Resources\PlanningResource;
use App\Models\Planning;
use App\Models\PlanningRecipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autenticatedUserId = Auth::guard('sanctum')->id();

        return PlanningResource::collection(Planning::where('user_id', $autenticatedUserId)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewPlanningRequest $request)
    {
        try {

            $autenticatedUserId = Auth::guard('sanctum')->id();

            $validateNewPlanning = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateNewPlanning->fails()) {

                return response()->json([
                    'message' => 'Invalid new Planning parameters',
                    'errors' => $validateNewPlanning->errors()
                ], 401);
            }

            $planning = Planning::create([
                'date' => $request->date,
                'user_id' => $autenticatedUserId
            ]);

            $planningId = $planning->id;

            foreach ($request->recipes as $recipe) {

                PlanningRecipe::create([
                    'planning_id' => $planningId,
                    'recipe_id' => $recipe['id'],
                    'meal' => $recipe['meal']
                ]);
            };

            return response()->json([
                'message' => 'Planning Created Successfully'
            ], 200);
        } catch (\Throwable $throwable) {

            return response()->json([
                'message' => $throwable->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function show(Planning $planning)
    {
        $autenticatedUserId = Auth::guard('sanctum')->id();

        if ($planning && $planning->user_id === $autenticatedUserId) {
            return new PlanningResource($planning);
        } else {
            return response()->json([
                'message' => 'Planning not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlanningRecipe $request, Planning $planning)
    {
        try {

            $validateUpdatePlanning = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateUpdatePlanning->fails()) {

                return response()->json([
                    'message' => 'Invalid update Planning parameters',
                    'errors' => $validateUpdatePlanning->errors()
                ], 401);
            }

            foreach ($request->recipes as $recipe) {

                $planningRecipe =
                    PlanningRecipe::where('planning_id', $planning->id)
                    ->where('recipe_id', $recipe['id'])
                    ->where('meal', $recipe['meal'])
                    ->first();

                if ($planningRecipe) {

                    if (!$planningRecipe->delete()) {
                        return response()->json([
                            'message' => "Planning Recipe not deleted"
                        ], 401);
                    }
                } else {

                    if (!PlanningRecipe::create([
                        'planning_id' => $planning->id,
                        'recipe_id' => $recipe['id'],
                        'meal' => $recipe['meal']
                    ])) {
                        return response()->json([
                            'message' => "Planning Recipe not created"
                        ], 401);
                    }
                }
            }

            if (!$planning->update($request->all())) {

                return response()->json([
                    'message' => 'Planning not updated',
                    'data' => $planning
                ], 401);
            }

            return response()->json([
                'message' => 'Planning Updated Successfully',
                'data' => $planning
            ], 200);
        } catch (\Throwable $throwable) {

            return response()->json([
                'message' => $throwable->getMessage()
            ], 204);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planning $planning)
    {
        if ($planning->delete()) {

            return response()->json([
                'message' => 'Planning deleted successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'Planning not found'
        ], 404);
    }
}
