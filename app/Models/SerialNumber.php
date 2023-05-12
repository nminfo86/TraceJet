<?php

namespace App\Models;

use App\Models\Of;
use Carbon\Carbon;
use App\Models\Part;
use DateTimeInterface;
use App\Models\Movement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SerialNumber extends Model
{
    use HasFactory;


    // public $timestamps = false;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['of_id', 'box_id', 'valid', 'serial_number', 'qr'];


    // /**
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
    //  */
    // protected $hidden = ['pivot'];


    /* -------------------------------------------------------------------------- */
    /*                                RelationShips                               */
    /* -------------------------------------------------------------------------- */
    /**
     * Get all of the ofs  for the SerialNumber
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function of(): BelongsTo
    {
        return $this->belongsTo(Of::class);
    }

    /**
     * Get the movement that owns the SerialNumber
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }

    /**
     * The parts that belong to the SerialNumber
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parts(): BelongsToMany
    {
        return $this->belongsToMany(Part::class)->withPivot(['quantity'])->select(["part_id", "quantity"]);
    }

    /* -------------------------------------------------------------------------- */
    /*                                   Scoops                                   */
    /* -------------------------------------------------------------------------- */
    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValid($query, $value)
    {
        return $query->where('valid', $value);
    }


    /**
     * Get the updated_at
     *
     * @param  string  $value
     * @return string
     */
    // protected function updatedAt(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
    //     );
    // }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i:s');
    }


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {

            $generate_qr = SerialNumber::join('ofs', 'serial_numbers.of_id', '=', 'ofs.id')
                ->join('calibers', 'ofs.caliber_id', '=', 'calibers.id')
                ->join('products', 'calibers.product_id', '=', 'products.id')
                ->join('sections', 'products.section_id', '=', 'sections.id')
                ->where('serial_numbers.of_id', $model->of_id)
                ->select(DB::raw("CONCAT_WS('#',ofs.of_code,ofs.of_number,calibers.caliber_name,serial_number, NOW()) as qr"))->orderBy('serial_numbers.id', 'desc')->first();
            $model->qr = $generate_qr->qr;
            $model->created_by = Auth::user()->name;
            $model->save();
        });
    }
}
