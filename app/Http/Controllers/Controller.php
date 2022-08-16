<?php

namespace App\Http\Controllers;

use App\Http\Traits\ContactPerson;
use App\Models\FollowUpClient;
use App\Notifications\CourtNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Notifications\Notifiable;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ContactPerson;

    public $perPage;
    public $start_date;
    public $end_date;

    function __construct()
    {
        $this->perPage = config('global.perPage');
        $this->start_date = strtotime(trim(date("d-m-Y", strtotime('-30 days', strtotime(date('Y-m-d'))))) . " 00:00:00");
        $this->end_date   = strtotime(trim(date('Y-m-d')) . " 23:59:59");
    }
}
