<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferAgent extends BaseModal
{
    use HasFactory;

    public function Company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }
}
