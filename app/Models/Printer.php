<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Printer extends Model
{
    use HasFactory;


    public $timestamps = false;

    public $fillable = ["section_id", "name", "port", "protocol", "label_size", "ip_address"];



    /* -------------------------------------------------------------------------- */
    /*                                RelationShip                                */
    /* -------------------------------------------------------------------------- */
    /**
     * Get the section that owns the Printer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
