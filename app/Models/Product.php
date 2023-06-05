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

    // public function scopeInSection($query, $host_id)
    // {
    //     // List of roles that can access all sections
    //     $roles_list = ["owner", "super_admin"];

    //     // Get the authenticated user
    //     $user = Auth::user();

    //     // Get the user's role
    //     $role = $user->roles_name[0];

    //     // Check if the user's role is in the roles list
    //     // If so, the user can access all sections
    //     if (in_array($role, $roles_list)) {
    //         return $query;
    //     }

    //     // Get the section ID based on the user's role and host IP address
    //     // $section_id = Post::where("ip_address", request()->ip())->first()->section_id;

    //     // Filter the query to include only products in the user's section
    //     return $query->whereHas('section', function ($query) use ($host_id) {
    //         $query->where('section_id', $host_id);
    //     });
    // }


    /**
     * Boot the model.
     */
    // TODO::make that on separate file
    // public static function boot()
    // {
    //     parent::boot();

    //     // Add the scope as a global scope
    //     static::addGlobalScope('inSection', function ($query) {
    //         // List of roles that can access all sections
    //         $roles_list = ["owner", "super_admin"];

    //         // Get the authenticated user
    //         $user = Auth::user();

    //         // Get the user's role
    //         $role = $user->roles_name[0];

    //         // Check if the user's role is in the roles list
    //         // If so, the user can access all sections
    //         if (in_array($role, $roles_list)) {
    //             return $query;
    //         }

    //         // Get the section ID based on the user's role and host IP address
    //         $post = Post::where('ip_address', request()->ip())->first();
    //         $host_id = $post ? $post->section_id : null;

    //         // Filter the query to include only products in the user's section
    //         if ($host_id) {
    //             $query->where('section_id', $host_id);
    //         } else {
    //             $query->where('id', 0); // Make sure the query returns no results if there's no section ID
    //         }
    //     });
    // }
}
