<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Model\Series_ban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SeriesBanController extends Controller
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
        $series_ban = Series_ban::updateOrCreate(array('user_id' => Auth::id(), 'series_id' => $request->series_id));
        //SuckSeriesJob::dispatch($request->series_id, false)->onQueue("high");
        return Response([
            'data' => $series_ban,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Series_ban  $series_ban
     * @return \Illuminate\Http\Response
     */
    public function show($series_ban_id)
    {
        $series_ban = Series_ban::where('id', $series_ban_id)
        ->where('user_id', Auth::id())
        ->get();

        return $series_ban;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Series_ban  $series_ban
     * @return \Illuminate\Http\Response
     */
    public function edit(Series_ban $series_ban)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Series_ban  $series_ban
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Series_ban $series_ban)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Series_ban  $series_ban
     * @return \Illuminate\Http\Response
     */
    public function destroy($series_ban_id)
    {
        $will_be_deleted = Series_ban::where('id', $series_ban_id)
        ->where('user_id', Auth::id())->first();
        
        if($will_be_deleted){
            $will_be_deleted->delete();
        }
        
        return Response(null, Response::HTTP_NO_CONTENT);
    }
}
