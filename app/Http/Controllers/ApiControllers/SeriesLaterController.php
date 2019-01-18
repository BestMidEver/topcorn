<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Model\Series_later;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SeriesLaterController extends Controller
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
        $series_later = Series_later::updateOrCreate(array('user_id' => Auth::id(), 'series_id' => $request->series_id));
        //SuckSeriesJob::dispatch($request->series_id, false)->onQueue("high");
        return Response([
            'data' => $series_later,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Series_later  $series_later
     * @return \Illuminate\Http\Response
     */
    public function show($series_later_id)
    {
        $series_later = Series_later::where('series_id', $series_later_id)
        ->where('user_id', Auth::id())
        ->first();

        return $series_later;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Series_later  $series_later
     * @return \Illuminate\Http\Response
     */
    public function edit(Series_later $series_later)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Series_later  $series_later
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Series_later $series_later)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Series_later  $series_later
     * @return \Illuminate\Http\Response
     */
    public function destroy($series_later_id)
    {
        $will_be_deleted = Series_later::where('id', $series_later_id)
        ->where('user_id', Auth::id())->first();
        
        if($will_be_deleted){
            $will_be_deleted->delete();
        }
        
        return Response(null, Response::HTTP_NO_CONTENT);
    }
}
