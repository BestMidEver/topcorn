<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\CustomNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomNotificationController extends Controller
{    
	public function create_notification($id = 'new')
    {
    	if(Auth::id()!=7) return 'You are unauthorized';

    	if($id == 'new'){
            $liste = '[]';
		}else{
            $temp = DB::table('custom_notifications')
            ->where('custom_notifications.id', '=', $id);

            if($temp->count()>0){
                $liste = $temp
                ->get()
                ->toArray();
            }else{
                return 'nothing_found';
            }
        }

        return view('createnotification', compact('id', 'liste'));
    }




    public function post_create_notification(Request $request)
    {
    	if(Auth::id()!=7) return 'You are unauthorized';

        $liste = CustomNotification::updateOrCreate(
            ['id' => $request->list_id],
            ['mode' => $request->mode,
            'icon' => $request->icon,
            'en_notification' => $request->en_notification,
            'tr_notification' => $request->tr_notification,
            'hu_notification' => $request->hu_notification,]
        );

        $request->session()->flash('status', __('general.list_updated'));


        return redirect('/createnotification/'.$liste->id);
    } 
}
