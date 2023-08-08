<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait FilteredBySection
{
    public static function filterBySection()
    {
        $user = Auth::user();
        // $role = $user->roles_name[0];
        $role = $user->roles_name;
        $section_id = $user->section_id;
        if ($role === "super_admin") {
            return self::query(); // Retrieve all records
        } else {
            return self::inSection($section_id); // Retrieve records based on section
        }
    }
}
