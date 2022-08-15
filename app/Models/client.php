<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModal;

class Client extends BaseModal
{
    use HasFactory;

    public function Company()
    {
        return $this->hasMany('App\Models\ClientToCompany', 'client_id', 'id',);
    }

    public function Court()
    {
        return $this->hasMany('App\Models\Court', 'id', 'court_id',)->select('id','court_name');
    }
}
