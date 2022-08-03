<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModal;

class FollowUpClient extends BaseModal
{
    use HasFactory;
    public $table = "client_follow_up";

}
