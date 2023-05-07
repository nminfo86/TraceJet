<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
<<<<<<< HEAD
    protected $fillable = ['posts_type_id', 'post_name', 'previous_post', "ip_address", "section_id", "code"];
=======
    protected $fillable = ['posts_type_id', 'post_name', 'previous_post', "ip_address","section_id","code"];
>>>>>>> fa3c6559cba32a7910608f6196b04e6498d02d6c


    /* -------------------------------------------------------------------------- */
    /*                                relationShips                               */
    /* -------------------------------------------------------------------------- */

    public function posts_type()
    {
        return $this->belongsTo(PostsType::class);
    }
<<<<<<< HEAD

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
    public function calibers(): BelongsToMany
    {
        return $this->belongsToMany(Caliber::class);
=======
    public function sections()
    {
        return $this->belongsTo(Section::class);
>>>>>>> fa3c6559cba32a7910608f6196b04e6498d02d6c
    }
}
