<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jugadora;
use Illuminate\Http\Request;
use App\Http\Resources\JugadoraResource;
use App\Http\Resources\JugadoraCollection;


class JugadoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new JugadoraCollection(Jugadora::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jugadora  $jugadora
     * @return \Illuminate\Http\Response
     */
    public function show(Jugadora $jugadora)
    {
        return new JugadoraResource($jugadora);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jugadora  $jugadora
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jugadora $jugadora)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jugadora  $jugadora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jugadora $jugadora)
    {
        //
    }
}
