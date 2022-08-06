<?php

namespace App\Http\Controllers;

use App\Http\Traits\ContactPerson;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ContactPerson;

    public $perPage;

    function __construct()
    {
        $this->perPage = config('global.perPage');
    }
}
