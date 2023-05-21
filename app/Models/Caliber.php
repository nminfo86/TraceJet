<?php

namespace App\Models;

use App\Models\Of;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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


    // protected $with = ["product"];



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

    public function ofs()
    {
        return $this->hasMany(Of::class);
    }

    /**
     * The posts that belong to the Caliber
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class)->select("posts.id", "post_name");
    }


    /* -------------------------------------------------------------------------- */
    /*                                Local Scopes                                */
    /* -------------------------------------------------------------------------- */
    /**
     * Scope a query to only include sectionID
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProductBySection($query, $section_id)
    {
        // return $query->where("id", $section_id);
        return $query->whereHas('product', function ($query) use ($section_id) {
            $query->where('section_id', $section_id);
        });
    }
}