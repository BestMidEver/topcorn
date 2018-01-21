<?php

namespace App\Http\Resources\Movie;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Auth;

class SearchResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $user_id = Auth::user()->id;
        return [
            'movie_id' => $this->id,
            'rated_id' => count($this->rated->where('user_id', $user_id)) > 0 ? (count($this->rated[0]->id) > 0 ? $this->rated[0]->id : null) : null,
            'rate_code' => count($this->rated->where('user_id', $user_id)) > 0 ? (count($this->rated[0]->rate) > 0 ? $this->rated[0]->rate : null) : null,
            'later_id' => count($this->later->where('user_id', $user_id)) > 0 ? (count($this->later[0]->id) > 0 ? $this->later[0]->id : null) : null,
            'ban_id' => count($this->ban->where('user_id', $user_id)) > 0 ? (count($this->ban[0]->id) > 0 ? $this->ban[0]->id : null) : null,
        ];
    }
}
