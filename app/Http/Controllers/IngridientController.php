<?php

namespace App\Http\Controllers;

use App\Models\Ingridient;
use App\Http\Requests\StoreIngridientRequest;
use App\Http\Requests\UpdateIngridientRequest;
use Illuminate\Support\Facades\Request;

class IngridientController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Ingridient::all()->keyBy('id');
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
    public function store(StoreIngridientRequest $request)
    {
        $ingridient = new Ingridient();
        $ingridient->name = $request->name;
        $ingridient->unit = $request->unit;
        $ingridient->save();

        return response()->json($ingridient);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingridient $ingridient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingridient $ingridient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIngridientRequest $request, Ingridient $ingridient)
    {
        $ingridient->update($request->all());
        return response()->json(['message' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingridient $ingridient)
    {
        $ingridient->delete();
        return response()->json(['message' => 'ok']);
    }
}
