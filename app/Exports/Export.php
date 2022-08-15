<?php

namespace App\Exports;

class Export
{
    public $start_date;
    public $end_date;

    function __construct()
    {
        $this->start_date = strtotime(trim(date("d-m-Y", strtotime('-30 days', strtotime(date('Y-m-d'))))) . " 00:00:00");
        $this->end_date   = strtotime(trim(date('Y-m-d')) . " 23:59:59");
    }
}
