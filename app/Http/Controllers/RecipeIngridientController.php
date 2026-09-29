<?php

namespace App\Http\Controllers;

use App\Models\RecipeIngridient;
use App\Http\Requests\StoreRecipeIngridientRequest;
use App\Http\Requests\UpdateRecipeIngridientRequest;
use Illuminate\Http\Request;

class RecipeIngridientController
{
    /**
     * Display a listing of the resource.
     */

      public function getRecipeIngredient($recipe_id)
    {
         return RecipeIngridient::where('recipe_id', $recipe_id)->get();
    }
    public function index()
    {
        return RecipeIngridient::all();
    }
     public function saveIngridient(Request $request)
    {
        return $request->all();
    }
    public function createAll(Request $request, $recipe_id)
{
   
    RecipeIngridient::where('recipe_id', $recipe_id)->delete();
    foreach (json_decode($request->all) as $value) {
        $RecipeIngredient = new RecipeIngridient();
        $RecipeIngredient->recipe_id = $recipe_id;
        $RecipeIngredient->ingridient_id = $value->ingridient_id;
        $RecipeIngredient->quantity = $value->quantity;
        $RecipeIngredient->save();
    }

    return response()->json(["message" => "ok"]);
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
    public function store(StoreRecipeIngridientRequest $request)
    {
        $ingridientsRecept = new RecipeIngridient();
        $ingridientsRecept->name = $request->name;
        $ingridientsRecept->unit = $request->unit;
        $ingridientsRecept->save();
        
        return response()->json($ingridientsRecept);
    }

    /**
     * Display the specified resource.
     */
    public function show(RecipeIngridient $recipeIngridient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecipeIngridient $recipeIngridient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeIngridientRequest $request, RecipeIngridient $recipeIngridient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecipeIngridient $recipeIngridient)
    {
        //
    }
}
