<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AuthorNameTrait
{
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $author =  Auth::user()->name ?? 'BlmDev';
            $model->created_by = $author;
            $model->updated_by = NULL;
        });
        self::updating(
            function ($model) {

                $author = Auth::user()->name ?? 'BlmDev';
                $model->updated_by = $author;
            }
        );
    }
}