<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModal;
use Illuminate\Notifications\Notifiable;

class FollowUpWith extends BaseModal
{
    use HasFactory, Notifiable;
    public $table = "followup_with_to_followup";

    public function contactPerson()
    {
        return $this->hasOne('App\Models\ContactPerson', 'id', 'cp_id')->select('id', 'name');
    }

     public function User()
    {
        return $this->hasOne('App\Models\User', 'id', 'with_user_id')->select('id', 'name');
    }

}
