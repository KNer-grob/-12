<?php

namespace App\Http\Controllers;

use App\Http\Requests\StepAddRequest;
use App\Models\Recipe;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Comment;
use App\Models\Ingridient;
use App\Models\RecipeStep;
use App\Models\UserStep;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function saveStep(StepAddRequest  $request)
    {
        if ($request->id) {
            $recipe = RecipeStep::find($request->id);
        } else {
            $recipe = new RecipeStep();
        }
        $recipe->recipe_id = $request->recipe_id;
        $recipe->description = $request->description;
        $recipe->step_number = $request->step_number;
        if ($request->image_url) {
            $image_url = Storage::disk("public")->putFile('/image_url', $request->image_url);
            $recipe->image_url = $image_url;
        }
        $recipe->save();
        return response()->json($recipe->id);
    }
    public function changeStep(Request $request, $recipe_id)
    {
        $recipe = UserStep::where('recipe_id', $recipe_id)->where('user_id', Auth::id())->first();
        if ($recipe) {
            $recipe->step_number = $request->step_number;
        } else {
            $recipe = new UserStep();
            $recipe->step_number = $request->step_number;
            $recipe->user_id = Auth::id();
            $recipe->recipe_id = $recipe_id;
        }
        $recipe->save();
        return response()->json(['massage' => 'ok']);
    }
    public function recipesHome(Request $request)
    {

        $sort = json_decode($request->sort);

        return Recipe::with('category')->where(function ($query) use ($request) {
            if ($request->categories) {
                $query->whereIn('category', json_decode($request->categories));
            }

            if ($request->difficulty) {
                $query->where('difficulty', $request->difficulty);
            }
            if ($request->checkedTime) {
                $query->whereBetween('cook_time', json_decode($request->checkedTime));
            }
            if ($request->serch) {
                $query->whereLike('title', '%' . $request->serch . '%');
            }
        })->orderBy($sort->field, $sort->by)->paginate(3);
    }
    public function recipesAdmin()
    {
        return response()->json(["recipes" => Recipe::with("user")->withCount("comments")->orderBy('created_at', 'asc')->paginate(6),]);
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

    public function store(StoreRecipeRequest $request)
    {
        $recipe = new Recipe();
        $recipe->user_id = Auth::id();
        $recipe->title = $request->title;
        $recipe->difficulty = $request->difficulty;
        $recipe->cook_time = $request->cook_time;
        $recipe->description = $request->description;
        $recipe->category = $request->category;
        $puth = Storage::disk('public')->putFile('/photos', $request->file('photo'));
        $recipe->photo = $puth;
        $recipe->save();
        return response()->json(["id" => $recipe->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show($recipe)
    {
        // $recipe = Recipe::with('user' , 'comments')->findOrFail($recipe);
        // return $recipe;


        $recipe = Recipe::with('user','category')->withCount("comments")->findOrFail($recipe);
        $recipes = RecipeStep::where("recipe_id", $recipe->id)->get();
        $comments = Comment::where("recipe_id",  $recipe->id)->with('user')->get();

        $isAdmin = false;
        $stepUser = 0;
        if (Auth::check()) {

            if (Auth::user()->role == 'admin') {
                $isAdmin = true;
            }
            $us =  UserStep::where("recipe_id",  $recipe->id)->where('user_id', Auth::id())->first();

            $stepUser  = $us ? $us->step_number : 0;
        }

        return response()->json(["recipe" =>  $recipe, "comments" => $comments, "stepUser" => $stepUser, "steps" => $recipes, 'isAdmin' => $isAdmin,]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $recipe->title = $request->title;
        $recipe->cook_time = $request->cook_time;
        $recipe->description = $request->description;
        $recipe->difficulty = $request->difficulty;
        $recipe->category = $request->category;
        if ($request->has("photo")) {
            $puth = Storage::disk('public')->putFile('/photos', $request->file('photo'));
            $recipe->photo = $puth;
        }

        $recipe->save();
        return response()->json(["id" => $recipe->id]);
    }
    public function getSteps($recipe_id)
    {
        $recipes = RecipeStep::where('recipe_id', $recipe_id)
            ->orderBy('step_number')
            ->get();
        return response()->json($recipes);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecipeStep $step)
    {
        $step->delete();
        return response()->json(['message' => 'ok']);
    }
}
