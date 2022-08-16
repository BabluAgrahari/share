<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class BaseModal extends Model
{
    use SoftDeletes, Notifiable;

    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    const DELETED_AT = 'deleted';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->updated = time();

            $model->created = time();
        });

        self::created(function ($model) {
            // ... code here
        });

        self::updating(function ($model) {
            $model->updated = time();
        });

        self::updated(function ($model) {
            // ... code here
        });

        self::deleting(function ($model) {
            $model->deleted = time();
        });

        self::deleted(function ($model) {
            // ... code here
            $model->deleted = time();
        });
    }
    //

    public function dFormat($date)
    {
        if (empty($date))
            return false;

        return date('d M Y', $date);
    }
}
