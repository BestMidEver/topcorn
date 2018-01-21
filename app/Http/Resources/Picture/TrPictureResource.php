<?php

namespace App\Http\Resources\Picture;

use Illuminate\Http\Resources\Json\Resource;

class TrPictureResource extends Resource
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
            'title' => $this->movie->tr_title,
            'cover_path' => $this->movie->tr_cover_path,
            'movie_id' => $this->movie->id,
        ];
    }
}
