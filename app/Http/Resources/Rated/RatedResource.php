<?php

namespace App\Http\Resources\Rated;

use Illuminate\Http\Resources\Json\Resource;

class RatedResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'movie_id' => $this->movie_id,
            'user_id' => $this->user_id,
            'rate' => $this->rate,
            'rated_id' => $this->id,
        ];
    }
}
