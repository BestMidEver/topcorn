<?php

namespace App\Http\Resources\Movie;

use Illuminate\Http\Resources\Json\Resource;

class MovieResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $genre_ids=[];
        for ($i=0; $i < count($this->genre); $i++) { 
            array_push($genre_ids, $this->genre[$i]->genre_id);
        }
        return [
            'movie_id' => $this->id,
            'genre_ids' => $genre_ids,
        ];
    }
}
