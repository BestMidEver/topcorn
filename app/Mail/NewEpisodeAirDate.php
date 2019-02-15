<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewEpisodeAirDate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($series_id, $name, $next_episode_air_date, $day_difference_next)
    {
        $this->series_id = $series_id;
        $this->name = $name;
        $this->next_episode_air_date = $next_episode_air_date;
        $this->day_difference_next = $day_difference_next;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new_episode_air_date')
        ->with('notification', $this->notification);
    }
}
