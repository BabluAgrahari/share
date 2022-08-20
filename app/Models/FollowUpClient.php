<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModal;
use Illuminate\Notifications\Notifiable;

class FollowUpClient extends BaseModal
{
    use HasFactory, Notifiable;
    public $table = "client_follow_up";

    public function User()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->select('id', 'name');
    }

    public function Client()
    {
        return $this->hasOne('App\Models\Client', 'id', 'client_id')->select('*');
    }

    public function Company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id')->select('id', 'company_name');
    }

    public function Court()
    {
        return $this->hasOne('App\Models\Court', 'id', 'court_id')->select('id', 'court_name');
    }

    public function TransAgent()
    {
        return $this->hasOne('App\Models\TransferAgent', 'id', 'agent_id')->select('id', 'transfer_agent');
    }

    public function CpName()
    {
        return $this->hasOne('App\Models\ContactPerson', 'id', 'cp_id')->select('id', 'name');
    }

    public function followUpWith(){

        return $this->hasMany('App\Models\FollowUpWith','follow_up_id','id');
    }
}
