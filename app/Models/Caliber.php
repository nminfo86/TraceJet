<?php

namespace App\Models;

use App\Models\Of;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caliber extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['caliber_code', 'caliber_name', 'product_id', 'box_quantity', 'observation'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /* -------------------------------------------------------------------------- */
    /*                                relationShips                               */
    /* -------------------------------------------------------------------------- */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function ofs()
    {
        return $this->hasMany(Of::class);
    }
}