<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\OfStatusEnum;
use App\Models\SerialNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Of extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['caliber_id', 'user_id', 'of_number', 'of_name', 'of_code', 'status', 'quantity', 'new_quantity', 'created_by', 'updated_by'];


    protected $casts = [
        'status' => OfStatusEnum::class,
    ];

    /**
     * Get the created_at
     *
     * @param  string  $value
     * @return string
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y H:m:s'),

        );
    }
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
            // Set new_quantity value
            $model->new_quantity = $model->quantity;
            $model->created_by = $author;
            $model->updated_by = NULL;
        });
        self::updating(function ($model) {

            $author = Auth::user()->name ??  'BlmDev';
            $model->updated_by = $author;
        });
    }
}