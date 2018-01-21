<?php

namespace App\Http\Resources\Movie;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Auth;

class AllMovieResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $user_id = Auth::user() ? Auth::user()->id : -1;
        return [
            'movie_id' => $this->id,
            'title' => $this->tr_title,
            'rate' => count($this->rated->where('user_id', $user_id)) > 0 ? $this->rated->where('user_id', $user_id)->pluck('rate')[0] : 0,
            'original_title' => $this->original_title,
            'release_date' => $this->release_date,
            'poster_path' => $this->tr_poster_path,
            'vote_average' => $this->vote_average,
            'ban_id' => count($this->ban->where('user_id', $user_id)) > 0 ? $this->ban->where('user_id', $user_id)->pluck('id')[0] : 0,
            'later_id' => count($this->later->where('user_id', $user_id)) > 0 ? $this->later->where('user_id', $user_id)->pluck('id')[0] : 0,
            'rated_id' => count($this->rated->where('user_id', $user_id)) > 0 ? $this->rated->where('user_id', $user_id)->pluck('id')[0] : 0,
            'rate_code' => count($this->rated->where('user_id', $user_id)) > 0 ? $this->rated->where('user_id', $user_id)->pluck('rate')[0] : 0,
        ];
    }
}
