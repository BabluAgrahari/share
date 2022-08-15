<?php


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
