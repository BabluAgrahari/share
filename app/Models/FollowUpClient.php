<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModal;

class FollowUpClient extends BaseModal
{
    use HasFactory;
    public $table = "client_follow_up";

    public function Client()
    {
        return $this->hasOne('App\Models\Client', 'id', 'client_id')->select('id', 'share_holder');
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
}
