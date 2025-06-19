<?php
namespace App\Http\Controllers;

use App\Models\Modem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ModemExport;

class CustomerServiceController extends Controller
{
    public function index()
    {
        $modems = Modem::orderBy('created_at', 'desc')->get();
        return view('customerservice.index', compact('modems'));
    }

    public function create()
    {
        return view('customerservice.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_terima' => 'required|date',
            'id_pelanggan' => 'required|string',
            'provider_modem' => 'required|in:huawei,zte,fiberhome,other',
            'serial_number_modem' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    $provider = $request->provider_modem;
                    $length = strlen($value);

                    if ($provider === 'huawei' && $length !== 16) {
                        $fail('Serial Number Modem untuk Huawei harus 16 digit.');
                    } elseif (($provider === 'zte' || $provider === 'fiberhome') && $length !== 12) {
                        $fail('Serial Number Modem untuk ZTE atau Fiberhome harus 12 digit.');
                    } elseif ($provider === 'other' && $length > 18) {
                        $fail('Serial Number Modem untuk Other maksimal 18 digit.');
                    }
                },
            ],
            'stb_id' => 'required|string|max:16',
        ]);

        Modem::create($request->all());
        return redirect()->route('customerservice.modem.index')->with('success', 'Data modem berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $modem = Modem::findOrFail($id);
        return view('customerservice.edit', compact('modem'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_terima' => 'required|date',
            'id_pelanggan' => 'required|string',
            'serial_number_modem' => 'required|string',
            'stb_id' => 'required|string',
        ]);
        $modem = Modem::findOrFail($id);
        $modem->update($request->all());
        return redirect()->route('customerservice.modem.index')->with('success', 'Data modem berhasil diupdate.');
    }

    public function destroy($id)
    {
        $modem = Modem::findOrFail($id);
        $modem->delete();
        return redirect()->route('customerservice.modem.index')->with('success', 'Data modem berhasil dihapus.');
    }



    public function export()
    {
        return Excel::download(new ModemExport, 'modems.xlsx');
    }
}
