<?php

namespace App\Models;

use App\Models\Of;
use App\Models\Post;
use App\Models\Caliber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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


    public function scopeInSection($query)
    {
        // List of roles that can access all sections
        $roles_list = ["owner", "super_admin"];

        // Get the authenticated user
        $user = Auth::user();

        // Get the user's role
        $role = $user->roles_name[0];

        // Check if the user's role is in the roles list
        // If so, the user can access all sections
        if (in_array($role, $roles_list)) {
            return $query;
        }

        // Get the section ID based on the user's role and host IP address
        $section_id = Post::where("ip_address", request()->ip())->first()->section_id;

        // Filter the query to include only products in the user's section
        return $query->whereHas('section', function ($query) use ($section_id) {
            $query->where('section_id', $section_id);
        });
    }
}
