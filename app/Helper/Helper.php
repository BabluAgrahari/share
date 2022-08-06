<?php


function dateRange()
{
    $start_date = (trim(date("m/d/Y", strtotime('-30 days', strtotime(date('Y-m-d'))))) . " 00:00:00");
    $end_date   = (trim(date('m/d/Y')) . " 23:59:59");
    // 07/01/2022 - 08/31/2022
    return $start_date . ' - ' . $end_date;
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
