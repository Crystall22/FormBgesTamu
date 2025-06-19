<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modem extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_terima',
        'tanggal_keluar',
        'id_pelanggan',
        'provider_modem',
        'serial_number_modem',
        'stb_id',
    ];
}
