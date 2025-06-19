<?php
namespace App\Exports;

use App\Models\CallCenter;
use Maatwebsite\Excel\Concerns\FromCollection;

class CallCenterExport implements FromCollection
{
    public function collection()
    {
        return CallCenter::all();
    }
}
