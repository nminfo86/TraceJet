<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['serial_number_id', 'previous_post_id', 'previous_post_name', 'result', 'observation'];




    // [x]::change later
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->updated_at = NULL;
        });
    }
}