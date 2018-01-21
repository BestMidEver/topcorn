<?php

namespace App\Http\Resources\Ban;

use Illuminate\Http\Resources\Json\Resource;

class BanResource extends Resource
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
            'ban_id' => $this->id,
        ];
    }
}
