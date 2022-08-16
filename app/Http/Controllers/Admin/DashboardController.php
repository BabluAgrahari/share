<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FollowUpClient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        notify();

        $query = FollowUpClient::selectRaw('id,
        COUNT(id) as all_follow_up,
        SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as follow_up,
        SUM(CASE WHEN status="competed" THEN 1 ELSE 0 END) as completed ,
        SUM(CASE WHEN status="rejected" THEN 1 ELSE 0 END) as rejected ,
        SUM(CASE WHEN status="on_hole" THEN 1 ELSE 0 END) as on_hold ,
        SUM(CASE WHEN status="revert" THEN 1 ELSE 0 END) as revert');

        if (Auth::user()->role == 'staff' || Auth::user()->role == 'supervisor') {
            $client_ids = !empty(Auth::user()->client_id) ? json_decode(Auth::user()->client_id) : array();
            $query->whereIn('client_id', $client_ids);
        }
        $data['followUp'] = $query->first();

        return view('dashboard', $data);
    }
}
