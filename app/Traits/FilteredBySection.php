<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait FilteredBySection
{
    public static function filterBySection()
    {
        // TODO::change later roles_name replace id with name
        $user = Auth::user();
        $role = $user->roles_name;
        $section_id = $user->section_id;
        // dd($role[0] . "/" . $section_id);
        // dd(Session::all());
        if ($role == "super_admin") {
            return self::query(); // Retrieve all records
        } else {
            return self::inSection($section_id); // Retrieve records based on section
        }
    }
}
