<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_name',
        'license_number',
        'status',
        'borrower_name',
        'parking_location',
        'borrower_position',
    ];
}
