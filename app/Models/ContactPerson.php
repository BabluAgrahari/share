<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPerson extends BaseModal
{
    use HasFactory;
    public $table = "contact_persons";
}
