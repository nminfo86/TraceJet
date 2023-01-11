<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_code', 'product_name', 'section_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /* -------------------------------------------------------------------------- */
    /*                                relationShips                               */
    /* -------------------------------------------------------------------------- */

    // public function section()
    // {
    //     return $this->belongsTo(Section::class);
    // }
    // public function calibers()
    // {
    //     return $this->hasMany(calibers::class);
    // }
}