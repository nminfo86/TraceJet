<?php

namespace App\Models;

use App\Models\Of;
use App\Models\Product;
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
    protected $fillable = ['caliber_code', 'caliber_name', 'product_id', 'box_quantity'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;



    /**
     * Scope a query to only include product_id
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByProduct($query, $val)
    {
        return $query->where('product_id', $val);
    }



    /* -------------------------------------------------------------------------- */
    /*                                relationShips                               */
    /* -------------------------------------------------------------------------- */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // public function ofs()
    // {
    //     return $this->hasMany(Of::class);
    // }
}