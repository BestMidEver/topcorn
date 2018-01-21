<?php

namespace App\Http\Resources\Later;

use Illuminate\Http\Resources\Json\Resource;

class LaterResource extends Resource
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
            'later_id' => $this->id,
        ];
    }
}
