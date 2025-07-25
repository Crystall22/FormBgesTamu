<?php
namespace App\Http\Controllers;

use App\Models\CallCenter;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CallCenterExport;

class CallCenterController extends Controller
{
    public function index()
    {
        $calls = CallCenter::all();
        return view('customerservice.call-center.index', compact('calls'));
    }

    public function create()
    {
        return view('customerservice.call-center.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone_number' => 'required|numeric',
            'connection_type' => 'required|numeric',
            'category' => 'required|string',
            'purpose' => 'required|string',
        ]);

        CallCenter::create($request->all());

        return redirect()->route('customerservice.call-center.index')->with('success', 'Data panggilan berhasil disimpan.');
    }

    public function destroy($id)
    {
        $call = CallCenter::findOrFail($id);
        $call->delete();

        return redirect()->route('customerservice.call-center.index')->with('success', 'Data panggilan berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new CallCenterExport, 'call_center_data.xlsx');
    }
}
