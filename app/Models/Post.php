<?php

namespace App\Models;

use App\Enums\ColorEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
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
    protected $fillable = ['posts_type_id', 'post_name', 'previous_post_id', "ip_address", "section_id", "code", "color"];


    // protected $casts = [
    //     'color' => ColorEnum::class,
    // ];


    /* -------------------------------------------------------------------------- */
    /*                                relationShips                               */
    /* -------------------------------------------------------------------------- */

    public function posts_type()
    {
        return $this->belongsTo(PostsType::class);
    }

    /**
     * Get all of the movements for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class, 'movement_post_id', 'id');
    }


    /**
     * The calibers that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    // public function calibers(): BelongsToMany
    // {
    //     return $this->belongsToMany(Caliber::class);
    // }



    public function sections()
    {
        return $this->belongsTo(Section::class);
    }
}