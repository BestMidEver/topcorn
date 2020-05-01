<?php

namespace App\Jobs;

use App\User;
use App\Model\Liste;
use App\Model\Recent_list;
use App\Model\Recent_user;
use App\Model\Recent_movie;
use App\Model\Recent_person;
use App\Model\Recent_series;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateRecentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $objId;
    protected $userId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $objId, $userId)
    {
        $this->type = $type;
        $this->objId = $objId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->type === 'movie') {
            $recent = Recent_movie::updateOrCreate(array('user_id' => $this->userId, 'movie_id' => $this->objId));
            $recent->touch();
            Recent_movie::where('user_id', $this->userId)->latest('updated_at')->skip(config('constants.recently_viewed.latest_n'))->take(2)->get()->each(function($row){ $row->delete(); });
        } else if($this->type === 'series') {
            $recent = Recent_series::updateOrCreate(array('user_id' => $this->userId, 'series_id' => $this->objId));
            $recent->touch();
            Recent_series::where('user_id', $this->userId)->latest('updated_at')->skip(config('constants.recently_viewed.latest_n'))->take(2)->get()->each(function($row){ $row->delete(); });
        } else if($this->type === 'person') {
            $recent = Recent_person::updateOrCreate(array('user_id' => $this->userId, 'person_id' => $this->objId));
            $recent->touch();
            Recent_person::where('user_id', $this->userId)->latest('updated_at')->skip(config('constants.recently_viewed.latest_n'))->take(2)->get()->each(function($row){ $row->delete(); });
        } else if($this->type === 'user') {
            $user = User::where(['id' => $this->userId]);
            if(!$user->count() > 0) return;
            $recent = Recent_user::updateOrCreate(array('user_id' => $this->userId, 'subject_id' => $this->objId));
            $recent->touch();
            Recent_user::where('user_id', $this->userId)->latest('updated_at')->skip(config('constants.recently_viewed.latest_n'))->take(2)->get()->each(function($row){ $row->delete(); });
        } else if($this->type === 'list') {
            $list = Liste::where(['id' => $this->userId]);
            if(!$list->count() > 0) return;
            $recent = Recent_list::updateOrCreate(array('user_id' => $this->userId, 'list_id' => $this->objId));
            $recent->touch();
            Recent_list::where('user_id', $this->userId)->latest('updated_at')->skip(config('constants.recently_viewed.latest_n'))->take(2)->get()->each(function($row){ $row->delete(); });
        }
    }
}
