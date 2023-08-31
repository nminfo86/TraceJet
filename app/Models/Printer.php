<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;


    public $timestamps = false;

    public $fillable = ["name", "port", "protocol", "label_size", "ip_address"];
}
