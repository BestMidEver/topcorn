<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Model\Series_seen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SeriesSeenController extends Controller
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
        $series_seen = Series_seen::updateOrCreate(
            array('user_id' => Auth::id(), 'series_id' => $request->series_id), 
            array('season_number' => $request->last_seen_season, 'episode_number' => $request->last_seen_episode, 'air_date' => new Carbon($request->air_date))
        );
        //SuckSeriesJob::dispatch($request->series_id, false)->onQueue("high");
        return Response([
            'data' => $request->air_date,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Series_seen  $series_seen
     * @return \Illuminate\Http\Response
     */
    public function show($series_id)
    {
        $series_seen = Series_seen::where('series_id', $series_id)
        ->where('user_id', Auth::id())
        ->first();

        return $series_seen;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Series_seen  $series_seen
     * @return \Illuminate\Http\Response
     */
    public function edit(Series_seen $series_seen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Series_seen  $series_seen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Series_seen $series_seen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Series_seen  $series_seen
     * @return \Illuminate\Http\Response
     */
    public function destroy($series_seen_id)
    {
        $will_be_deleted = Series_seen::where('id', $series_seen_id)
        ->where('user_id', Auth::id())->first();
        
        if($will_be_deleted){
            $will_be_deleted->delete();
        }
        
        return Response(null, Response::HTTP_NO_CONTENT);
    }
}
