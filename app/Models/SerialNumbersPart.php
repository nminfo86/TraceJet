<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SerialNumbersPart extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['serial_number_id', 'part_id'];

    /**
     * Get all of the serial_numbers for the SerialNumbersPart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serial_numbers(): HasMany
    {
        return $this->hasMany(SerialNumber::class);
    }
}