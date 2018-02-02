<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaterRequest;
use App\Http\Resources\Later\EnLaterResource;
use App\Http\Resources\Later\HuLaterResource;
use App\Http\Resources\Later\LaterResource;
use App\Http\Resources\Later\TrLaterResource;
use App\Jobs\SuckMovieJob;
use App\Model\Later;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LaterController extends Controller
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
        return LaterResource::collection(
            Later::where(['user_id' => Auth::user()->id])->get()
        );
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
        $later = Later::updateOrCreate(array('user_id' => Auth::id(), 'movie_id' => $request->movie_id));
        //$later->save();
        SuckMovieJob::dispatch($request->movie_id, false, true)->onQueue("high");
        return Response([
            'data' => new LaterResource($later),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Later  $later
     * @return \Illuminate\Http\Response
     */
    public function show(Later $later)
    {
        return new LaterResource($later);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Later  $later
     * @return \Illuminate\Http\Response
     */
    public function edit(Later $later)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Later  $later
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Later $later)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Later  $later
     * @return \Illuminate\Http\Response
     */
    public function destroy($movie)
    {
        $will_be_deleted = Later::where('id', $movie)
        ->where('user_id', Auth::id())->first();

        if($will_be_deleted){
            $will_be_deleted->delete();
        }
        
        return Response(null, Response::HTTP_NO_CONTENT);
    }
}
