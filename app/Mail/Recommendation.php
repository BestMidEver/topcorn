<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Recommendation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $mode, $movie_id, $users)
    {
        $this->title = $title;
        $this->mode = $mode;
        $this->movie_id = $movie_id;
        $this->users = $users;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.recommendation')
        ->with('title', $this->title)
        ->with('mode', $this->mode)
        ->with('movie_id', $this->movie_id)
        ->with('users', $this->users);
    }
}
