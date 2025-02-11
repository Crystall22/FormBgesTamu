<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_name',
        'guest_phone',
        'guest_address',
        'institution',
        'date',
        'purpose',
        'pdf_file',
        'category',
        'secretary_note',
        'status',
        'invoice_number'
    ];
}
