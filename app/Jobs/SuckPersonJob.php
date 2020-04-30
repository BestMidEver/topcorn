<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Model\Person;
use Illuminate\Bus\Queueable;
use App\Jobs\UpdateRecentsJob;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SuckPersonJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $userId = 0)
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $is_recent = Person::where('id', $this->id)
        ->where('updated_at', '>', Carbon::now()->subHours(100)->toDateTimeString())
        ->first();
        if($is_recent) {
            if($this->userId > 0) UpdateRecentsJob::dispatch('person', $this->id, $this->userId)->onQueue("high");
            return;
        }

        $person = json_decode(file_get_contents('https://api.themoviedb.org/3/person/'.$this->id.'?api_key='.config('constants.api_key').'&language=en-US'), true);
        Person::updateOrCreate(
            ['id' => $person['id']],
            ['profile_path' => $person['profile_path'],
            'name' => $person['name'],
            'popularity' => $person['popularity'],
            'birthday' => $person['birthday']!=null ? new Carbon($person['birthday']) : null,
            'deathday' => $person['deathday']!=null ? new Carbon($person['deathday']) : null]
        );
        if($this->userId > 0) UpdateRecentsJob::dispatch('person', $this->id, $this->userId)->onQueue("high");
    }
}
