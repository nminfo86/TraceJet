<?php

namespace App\Models;

use App\Models\Of;
use App\Enums\BoxStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Box extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['of_id', 'box_qr', 'status'];

    protected $casts = [
        'status' => BoxStatusEnum::class,
    ];


    /* -------------------------------------------------------------------------- */
    /*                                RelationShips                               */
    /* -------------------------------------------------------------------------- */

    /**
     * Get the of that owns the Box
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function of()
    {
        return $this->belongsTo(Of::class);
    }






    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {

            $author = Auth::user()->name ??  'BlmDev';
            $model->created_by = $author;
            $model->updated_by = NULL;

            // generate box SN
            // $new_box_code = Box::count() + 1;
            // $of_code = Of::findOrFail($model->of_id)->of_code;
            // $model->box_qr = "$of_code#$new_box_code";


            $new_box_number = Box::count() + 1;
            $of_code = Of::findOrFail($model->of_id)->of_code;
            $model->box_qr = $of_code . '-' . $new_box_number;
        });

        self::updating(function ($model) {

            $author = Auth::user()->name ??  'BlmDev';
            $model->updated_by = $author;
        });
    }
}
