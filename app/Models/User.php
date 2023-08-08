<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\FilteredBySection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, FilteredBySection;
    protected $guard_name = 'sanctum';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'roles_name', 'section_id', 'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'roles_name' => 'array',
    ];


    /* -------------------------------------------------------------------------- */
    /*                                relationShips                               */
    /* -------------------------------------------------------------------------- */

    public function section()
    {
        return $this->belongsTo(Section::class);
    }


    public function scopeInSection($query, $sectionId)
    {
        return $query->where('section_id', $sectionId);
    }

    /* -------------------------------------------------------------------------- */
    /*                                Global scope                                */
    /* -------------------------------------------------------------------------- */

    // protected static function booted()
    // {
    //     // Retrieve all data from session
    //     // $value = Session::all();


    //     // dd($value);
    //     static::addGlobalScope(new BySectionScope());
    // }
}
