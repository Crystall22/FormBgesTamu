<?php
namespace App\Exports;

use App\Models\Form;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Form::where('is_archived', true)
            ->get()
            ->map(function ($form) {
                return [
                    'No' => $form->id,
                    'Nama Tamu' => $form->guest_name,
                    'No HP' => $form->guest_phone,
                    'Institusi' => $form->institution,
                    'Tujuan' => $form->purpose,
                    'Petugas' => $form->taken,
                    'Tanggal Arsip' => $form->updated_at ? $form->updated_at->format('d-m-Y H:i') : '',
                    'Status' => $form->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Tamu',
            'No HP',
            'Institusi',
            'Tujuan',
            'Petugas',
            'Tanggal Arsip',
            'Status',
        ];
    }
}
