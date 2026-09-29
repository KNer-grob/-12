<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\IngridientController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeIngridientController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("/register", [UserController::class, "register"]);
Route::post("/login", [UserController::class, "login"]);


Route::post("/recipesHome", [RecipeController::class, "recipesHome"]);
Route::get("/recipesAdmin", [RecipeController::class, "recipesAdmin"]);
    Route::get("/recipe/{recipe}", [RecipeController::class, "show"]);



Route::middleware(['auth:sanctum'])->group(function () {


    Route::get("/user", [UserController::class, "user"]);
    Route::get('/usersSpisok', [UserController::class, 'usersSpisok']);
    Route::post("/step", [RecipeController::class, "saveStep"]);
    Route::post("/changeStep/{recipe}", [RecipeController::class, "changeStep"]);
    Route::get('/getStepUser/{recipe}', [RecipeController::class, 'getStepUser']);

    Route::delete('/step/{step}', [RecipeController::class, 'destroy']);

    Route::get("/ingridient", [IngridientController::class, "index"]);
    Route::post("/ingridient", [IngridientController::class, "store"]);
    Route::delete("/ingridient/{ingridient}", [IngridientController::class, "destroy"]);

    Route::get("/category", [CategoryController::class, "index"]);
    Route::post("/category", [CategoryController::class, "store"]);
    Route::delete("/category/{category}", [CategoryController::class, "destroy"]);
    Route::put("/category/{category}", [CategoryController::class, "update"]);

    Route::post("/saveIngridient", [RecipeIngridientController::class, "saveIngridient"]);
    Route::post('saveIngredients/{recipe_id}', [RecipeIngridientController::class, 'createAll']);

    Route::delete("/ingridientsRecept/{ingridientsRecept}", [RecipeController::class, "destroy"]);
    Route::get('/getRecipeIngredient/{recipe}', [RecipeIngridientController::class, 'getRecipeIngredient']);
    Route::put("/ingridient/{ingridient}", [IngridientController::class, "update"]);

    Route::get("/recipeUser/{recipe}", [RecipeController::class, "show"]);
    Route::post("/receptadd", [RecipeController::class, "store"]);
    Route::get('/step/{recipe}', [RecipeController::class, 'getSteps']);
    Route::post("/recept/{recipe}", [RecipeController::class, "update"]);
    Route::post("/comment/{recipe}", [CommentController::class, "store"]);

    Route::get('/recipes/{id}/favorite', [FavoriteController::class, 'favorite']);
    Route::get('/user/{favorites}', [FavoriteController::class, 'getFavorites']);
});
