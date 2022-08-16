<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactPerson;
use App\Models\FollowUpClient;
use App\Models\User;
use App\Notifications\CourtNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $after_three_days = strtotime(trim(date("d-m-Y", strtotime('+3 days', strtotime(date('Y-m-d'))))) . " 01:00:00");
        $today_date = strtotime(trim(date('Y-m-d')) . " 23:59:59");

        $followUp = FollowUpClient::where('type', 'court')->where('follow_up_date', '>', $today_date)->where('follow_up_date', '<', $after_three_days)->where('notify_status', 0)->get();

        foreach ($followUp as $follow) {

            $res = Auth::user()->notify(new CourtNotification($follow));
            pr($res);
            $followU = FollowUpClient::find($follow->id);
            $followU->notify_status = 1;
            $followU->save();
        }
    }

    public function makeAsRead($id)
    {
        if ($id) {
            auth()->user()->notifications->where('id', $id)->markAsRead();
        }
        return response(['status' => 'success']);
    }
}
