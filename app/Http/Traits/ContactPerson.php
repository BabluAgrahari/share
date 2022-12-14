<?php

namespace App\Http\Traits;

use App\Models\ContactPerson as ModelsContactPerson;
use Illuminate\Support\Facades\Auth;

trait ContactPerson
{
    public function storeContactPerson($request, $ref_id = false, $ref_by = false)
    {
        if (empty($request) || !$ref_id || !$ref_by)
            return false;

        $request = (object)$request;
        $save = new ModelsContactPerson();
        $save->user_id     = Auth::user()->id;
        $save->name        = $request->cp_name;
        $save->email       = $request->cp_email;
        $save->mobile      = $request->cp_mobile;
        $save->designation = $request->cp_designation;
        $save->ref_id      = $ref_id;
        $save->ref_by      = $ref_by;
        if ($save->save())
            return true;

        return false;
    }

    public function updateContactPerson($request, $ref_id, $ref_by = false)
    {
        if (empty($request) || !$ref_id || !$ref_by)
            return false;

        $request = (object)$request;
        $save = ModelsContactPerson::where('ref_id', $ref_id)->first();
        $save->name        = $request->cp_name;
        $save->email       = $request->cp_email;
        $save->mobile      = $request->cp_mobile;
        $save->designation = $request->cp_designation;
        if ($save->save())
            return true;

        return false;
    }


    public function bulkUpdateContactPerson($request, $ref_id, $ref_by = false)
    {
        if (empty($request) || !$ref_id || !$ref_by)
            return false;

        $request = (object)$request;
        $save = ModelsContactPerson::where('ref_id', $ref_id)->first();
        $save->name        = $request->cp_name;
        $save->email       = $request->cp_email;
        $save->mobile      = $request->cp_mobile;
        $save->designation = $request->cp_designation;
        if ($save->save())
            return true;

        return false;
    }
}
