<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Post;
use DateTimeInterface;
use App\Models\SerialNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['serial_number_id', 'movement_post_id', 'result', 'observation', 'updated_by'];

    /**
     * Get the created_at
     *
     * @param  string  $value
     * @return string
     */
    // protected function createdAt(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => Carbon::parse($value)->format('d-m-Y H:i:s'),

    //     );
    // }

    /**
     * Get the serialnumber that owns the Movement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serialNumber()
    {
        return $this->belongsTo(SerialNumber::class);
    }

    /**
     * Get all of the posts for the Movement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts() #HasMany
    {
        return $this->belongsTo(Post::class, "movement_post_id", "id");
    }


    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    // [x]::change later
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {

            $author = Auth::user()->username ??  'BlmDev';
            $model->created_by = $author;
            $model->updated_by = $author;
        });
    }
}
