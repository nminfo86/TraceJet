<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['serial_number_id', 'movement_post_id', 'result', 'observation'];



    /**
     * Get the serialnumber that owns the Movement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serialnumber()
    {
        return $this->hasMany(SerialNumber::class);
    }

    // [x]::change later
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->updated_at = NULL;
        });
    }
}