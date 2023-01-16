<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewPlanningRequest;
use App\Http\Requests\UpdatePlanningRecipe;
use App\Http\Resources\PlanningResource;
use App\Models\Planning;
use App\Models\PlanningRecipe;
use App\Services\PlanningService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlanningController extends Controller
{

    public function __construct(private PlanningService $planningService)
    {
    }
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

            $planningFound = Planning::where('date', $request->date)->first();

            if ($planningFound) {
                $planningRecipe =
                    PlanningRecipe::where('planning_id', $planningFound->id)
                    ->where('recipe_id', $request->recipe_id)
                    ->where('meal', $request->recipe_meal)
                    ->first();

                if ($planningRecipe) {

                    if (!$planningRecipe->delete()) {
                        return response()->json([
                            'message' => "Planning Recipe not deleted"
                        ], 401);
                    }
                } else {

                    if (!PlanningRecipe::create([
                        'planning_id' => $planningFound->id,
                        'recipe_id' => $request->recipe_id,
                        'meal' => $request->recipe_meal
                    ])) {
                        return response()->json([
                            'message' => "Planning Recipe not created"
                        ], 401);
                    }

                    $this->planningService->checkIngredients($request->recipe_id);
                }

                return response()->json([
                    'message' => 'Planning Updated Successfully',
                    'data' => $planningFound
                ], 200);
            } else {
                $planning = Planning::create([
                    'date' => $request->date,
                    'user_id' => $autenticatedUserId
                ]);

                if (!$planning) {
                    return response()->json([
                        'message' => "Planning not created"
                    ], 401);
                }

                if (!PlanningRecipe::create([
                    'planning_id' => $planning->id,
                    'recipe_id' => $request->recipe_id,
                    'meal' => $request->recipe_meal
                ])) {
                    return response()->json([
                        'message' => "Planning not created"
                    ], 401);
                }
                return response()->json([
                    'message' => 'Planning Created Successfully'
                ], 200);
            }
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
        try {
            $autenticatedUserId = Auth::guard('sanctum')->id();

            if ($planning && $planning->user_id === $autenticatedUserId) {
                return new PlanningResource($planning);
            } else {
                return response()->json([
                    'message' => 'Planning not found'
                ], 404);
            }
        } catch (\Throwable $throwable) {

            return response()->json([
                'message' => $throwable->getMessage()
            ], 500);
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

            if (!$planning) {
                return response()->json([
                    'message' => 'Planning not found'
                ], 404);
            }

            $planningRecipe =
                PlanningRecipe::where('planning_id', $planning->id)
                ->where('recipe_id', $request->recipe_id)
                ->where('meal', $request->recipe_meal)
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
                    'recipe_id' => $request->recipe_id,
                    'meal' => $request->recipe_meal
                ])) {
                    return response()->json([
                        'message' => "Planning Recipe not created"
                    ], 401);
                }
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
