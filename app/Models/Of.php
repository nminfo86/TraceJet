<?php

namespace App\Models;

use App\Enums\OfStatusEnum;
use App\Models\SerialNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Of extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['caliber_id', 'user_id', 'of_number', 'of_code', 'status', 'quantity', 'created_by', 'updated_by'];


    protected $casts = [
        'status' => OfStatusEnum::class,
    ];
    /* -------------------------------------------------------------------------- */
    /*                                RelationShips                               */
    /* -------------------------------------------------------------------------- */

    /**
     * Get all of the calibers for the Of
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function caliber()
    {
        return $this->belongsTo(Caliber::class);
    }

    /**
     * Get the serialNumber that owns the Of
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serialNumber()
    {
        return $this->hasMany(SerialNumber::class);
    }





    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {

            $author = Auth::user()->name ??  'BlmDev';
            $model->created_by = $author;
            $model->updated_by = NULL;
        });
        self::updating(function ($model) {

            $author = Auth::user()->name ??  'BlmDev';
            $model->updated_by = $author;
        });
    }
}