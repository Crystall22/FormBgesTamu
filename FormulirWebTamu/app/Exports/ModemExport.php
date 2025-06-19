<?php
namespace App\Exports;

use App\Models\Modem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ModemExport implements FromCollection, WithHeadings
{
    /**
     * Ambil data untuk diexport.
     */
    public function collection()
    {
        return Modem::select('tanggal_terima', 'tanggal_keluar', 'id_pelanggan', 'provider_modem', 'serial_number_modem', 'stb_id')->get();
    }

    /**
     * Tambahkan heading pada file Excel.
     */
    public function headings(): array
    {
        return [
            'Tanggal Terima',
            'Tanggal Keluar',
            'ID Pelanggan',
            'Provider Modem',
            'Serial Number Modem',
            'Set Top Box ID',
        ];
    }
}
