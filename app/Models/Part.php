<?php

namespace App\Models;

use App\Models\SerialNumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Part extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['pivot'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['part', 'observation'];



    /**
     * Get all of the serial_numbers for the Part
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serial_numbers()
    {
        return $this->belongsToMany(SerialNumber::class);
    }
}