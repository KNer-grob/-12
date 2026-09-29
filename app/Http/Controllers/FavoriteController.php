<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function favorite($id)
    {
        $favorite = Favorite::where('recipe_id', $id)->where('user_id', Auth::id())->first();
        if ($favorite) {
            $favorite->delete();
        } else {
            $favorite = new Favorite();
            $favorite->recipe_id = $id;
            $favorite->user_id = Auth::id();
            $favorite->save();
        }
        return response()->json(['message' => 'ok']);
    }

    public function getFavorites()
    {
        return Favorite::where('user_id', Auth::id())->with('recipe')->get();
    }


    public function index()
    {

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
    public function store(StoreFavoriteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavoriteRequest $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favorite $favorite)
    {
        //
    }
}
