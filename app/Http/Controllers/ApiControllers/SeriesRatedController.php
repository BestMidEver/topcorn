<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Model\Series_rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SeriesRatedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
        $series_rated = Series_rated::updateOrCreate(array('user_id' => Auth::id(), 'series_id' => $request->series_id), array('rate' => $request->rate));
        //SuckSeriesJob::dispatch($request->series_id, false)->onQueue("high");
        return Response([
            'data' => $series_rated,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Series_rated  $series_rated
     * @return \Illuminate\Http\Response
     */
    public function show($series_id)
    {
        $series_rated = Series_rated::where('series_id', $series_id)
        ->where('user_id', Auth::id())
        ->first();

        return $series_rated;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Series_rated  $series_rated
     * @return \Illuminate\Http\Response
     */
    public function edit(Series_rated $series_rated)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Series_rated  $series_rated
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Series_rated $series_rated)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Series_rated  $series_rated
     * @return \Illuminate\Http\Response
     */
    public function destroy($series_rated_id)
    {
        $will_be_deleted = Series_rated::where('id', $series_rated_id)
        ->where('user_id', Auth::id())->first();
        
        if($will_be_deleted){
            $will_be_deleted->delete();
        }
        
        return Response(null, Response::HTTP_NO_CONTENT);
    }
}
