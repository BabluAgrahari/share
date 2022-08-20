<?php

use App\Models\FollowUpClient;
use App\Models\FollowUpWith;
use App\Notifications\CourtNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function dateRange()
{
    $start_date = (trim(date("m/d/Y", strtotime('-30 days', strtotime(date('Y-m-d'))))) . " 00:00:00");
    $end_date   = (trim(date('m/d/Y')) . " 23:59:59");
    // 07/01/2022 - 08/31/2022
    return $start_date . ' - ' . $end_date;
}

if (!function_exists('singleFile')) {

    function singleFile($file, $folder)
    {
        if ($file) {
            if (!file_exists($folder))
                mkdir($folder, 0777, true);

            $filename = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/' . $folder, $filename);
            return $filename;
        }
        return false;
    }
}


if (!function_exists('multipleFile')) {

    function multipleFile($files, $folder)
    {
        $fileNames = [];
        foreach ($files as $key => $file) {
            if ($file) {
                if (!file_exists($folder))
                    mkdir($folder, 0777, true);

                $filename = date('YmdHis') . "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/' . $folder, $filename);
                $fileNames[$key] =  $filename;
            }
        }

        return $fileNames;
    }
}

if (!function_exists('pr')) {
    function pr($data)
    {
        echo "<pre>";
        print_r($data);
        echo '</pre>';
        die;
    }
}

if (!function_exists('notify')) {
    function notify()
    {
        $after_three_days = strtotime(trim(date("d-m-Y", strtotime('+3 days', strtotime(date('Y-m-d'))))) . " 01:00:00");
        $today_date = strtotime(trim(date('Y-m-d')) . " 23:59:59");

        // $followUp = FollowUpWith::where('type', 'court')->where('follow_up_date', '>', $today_date)->where('follow_up_date', '<', $after_three_days)->where('notify_status', 0)->get();

        $followUp = FollowUpWith::select('fu.*')->join('client_follow_up as fu', 'followup_with_to_followup.follow_up_id', '=', 'fu.id', 'left')
            ->where('followup_with_to_followup.type', 'client')->where('fu.follow_up_date', '>', $today_date)
            ->where('fu.follow_up_date', '<', $after_three_days)->where('fu.notify_status', 0)->get();

        foreach ($followUp as $follow) {

            $res = Auth::user()->notify(new CourtNotification($follow));
            $followU = FollowUpClient::find($follow->id);
            $followU->notify_status = 1;
            $followU->save();
        }
    }
}

if (!function_exists('markAsRead')) {

    function markAsRead($follow_up_id)
    {
        if ($follow_up_id) {
            $noti =  DB::table('notifications')->whereRaw("JSON_EXTRACT(data,'$.follow_up_id') = $follow_up_id")->first();
            if (empty($noti))
                return false;

            $id = $noti->id;
            auth()->user()->notifications->where('id', $id)->markAsRead();
        }
        return true;
    }
}
