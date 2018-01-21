<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BanRequest;
use App\Http\Resources\Ban\BanResource;
use App\Http\Resources\Ban\EnBanResource;
use App\Http\Resources\Ban\HuBanResource;
use App\Http\Resources\Ban\TrBanResource;
use App\Jobs\SuckMovieJob;
use App\Model\Ban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BanController extends Controller
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
        return BanResource::collection(
            Ban::where(['user_id' => Auth::user()->id])->get()
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
    public function store(BanRequest $request)
    {
        $ban = Ban::updateOrCreate(array('user_id' => Auth::id(), 'movie_id' => $request->movie_id));
        SuckMovieJob::dispatch($request->movie_id, false)->onQueue("high");
        return Response([
            'data' => new BanResource($ban),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function show(Ban $ban)
    {
        return new BanResource($ban);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function edit(Ban $ban)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ban $ban)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function destroy($movie)
    {
        $will_be_deleted = Ban::where('id', $movie)
        ->where('user_id', Auth::id())->first();
        
        if($will_be_deleted){
            $will_be_deleted->delete();
        }
        
        return Response(null, Response::HTTP_NO_CONTENT);
    }
}
