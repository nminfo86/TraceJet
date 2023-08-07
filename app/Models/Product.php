<?php

namespace App\Models;

use App\Models\Of;
use App\Models\Post;
use App\Models\Caliber;
use App\Scopes\BySectionScope;
use App\Traits\FilteredBySection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    use HasFactory, FilteredBySection;
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

    protected $with = ["section"];
    /* -------------------------------------------------------------------------- */
    /*                                relationShips                               */
    /* -------------------------------------------------------------------------- */

    // public function section()
    // {
    //     return $this->belongsTo(Section::class);
    // }

    //use in of view
    public function calibers()
    {
        return $this->hasMany(caliber::class);
    }

    /**
     * Get the section that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class)->select("id", "section_name");
    }


    // Define the relationship to the Post model
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function scopeInSection($query, $sectionId)
    {
        return $query->where('section_id', $sectionId);
    }
}
