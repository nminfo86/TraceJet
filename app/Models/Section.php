<?php

namespace App\Models;

use App\Models\Post;
use App\Scopes\BySectionScope;
use App\Traits\FilteredBySection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory, FilteredBySection;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['section_name', 'section_code'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /* -------------------------------------------------------------------------- */
    /*                                relationShips                               */
    /* -------------------------------------------------------------------------- */

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function scopeInSection($query, $sectionId)
    {
        return $query->where('id', $sectionId);
    }


    // protected static function booted()
    // {
    //     static::addGlobalScope(new BySectionScope(request()->post_section_id));
    // }
}
