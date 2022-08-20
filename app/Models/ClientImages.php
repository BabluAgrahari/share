<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModal;
use Illuminate\Notifications\Notifiable;

class ClientImages extends BaseModal
{
    use HasFactory, Notifiable;
    public $table = "client_images";

}
