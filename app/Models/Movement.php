<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
     * Get the created_at
     *
     * @param  string  $value
     * @return string
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y H:i:s'),

        );
    }

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
