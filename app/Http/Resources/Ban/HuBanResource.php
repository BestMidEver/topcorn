<?php

namespace App\Http\Resources\Ban;

use Illuminate\Http\Resources\Json\Resource;

class HuBanResource extends Resource
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
            'original_title' => $this->movie->original_title,
            'title' => $this->movie->hu_title,
            'release_date' => $this->movie->release_date,
            'poster_path' => $this->movie->hu_poster_path,
            'vote_average' => $this->movie->vote_average,
        ];
    }
}
