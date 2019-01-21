<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Model\Series_recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SeriesRecommendationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Model\Series_recommendation  $series_recommendation
     * @return \Illuminate\Http\Response
     */
    public function show(Series_recommendation $series_recommendation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Series_recommendation  $series_recommendation
     * @return \Illuminate\Http\Response
     */
    public function edit(Series_recommendation $series_recommendation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Series_recommendation  $series_recommendation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Series_recommendation $series_recommendation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Series_recommendation  $series_recommendation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Series_recommendation $series_recommendation)
    {
        //
    }
}
