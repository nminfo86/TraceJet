<?php

namespace App\Models;

use App\Models\Of;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SerialNumber extends Model
{
    use HasFactory;
    public $timestamps = false;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['of_id', 'box_id', 'valid', 'serial_number', 'qr'];

    /**
     * Get all of the ofs  for the SerialNumber
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function of()
    {
        return $this->belongsTo(Of::class);
    }

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

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {

            $generate_qr = SerialNumber::join('ofs', 'serial_numbers.of_id', '=', 'ofs.id')
                ->join('calibers', 'ofs.caliber_id', '=', 'calibers.id')
                ->join('products', 'calibers.product_id', '=', 'products.id')
                ->join('sections', 'products.section_id', '=', 'sections.id')
                ->where('serial_numbers.of_id', $model->of_id)
                ->select(DB::raw("CONCAT_WS('#',ofs.of_code,calibers.caliber_name,serial_number, NOW()) as qr"))->orderBy('serial_numbers.id', 'desc')->first();
            $model->qr = $generate_qr->qr;
            $model->save();
        });
    }
}