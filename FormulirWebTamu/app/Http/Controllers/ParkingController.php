<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;

class ParkingController extends Controller
{
    // Tampilkan daftar parkir
    public function index()
    {
        $parkings = Parking::all();
        return view('parkings.index', compact('parkings'));
    }

    // Form peminjaman mobil
    public function pinjamForm()
    {
        $availableCars = Parking::where('status', 'available')->get();
        return view('parkings.pinjam', compact('availableCars'));
    }

    // Proses peminjaman mobil
    public function borrow(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:parkings,id',
            'borrower_name' => 'required|string|max:100',
            'borrower_position' => 'required|string',
            'custom_borrower_position' => 'nullable|string|max:100',
            'purpose' => 'required|string|max:255',
        ]);

        $parking = Parking::findOrFail($request->vehicle_id);

        // Pastikan slot mobil yang dipilih tidak null
        if (is_null($parking->slot)) {
            return back()->withErrors(['vehicle_id' => 'Slot parkir mobil ini belum diatur.'])->withInput();
        }

        $borrower_position = $request->borrower_position == 'Other'
            ? $request->custom_borrower_position
            : $request->borrower_position;

        $parking->update([
            'status' => 'vacant',
            'borrower_name' => $request->borrower_name,
            'borrower_position' => $borrower_position,
            'purpose' => $request->purpose,
            // slot tidak diubah saat peminjaman, tetap pakai slot mobil
        ]);

        return redirect()->route('parkings.index')->with('success', 'Mobil berhasil dipinjam.');
    }

    // Form pengembalian mobil
    public function returnForm()
    {
        $vacantCars = Parking::where('status', 'vacant')->get();
        return view('parkings.return', compact('vacantCars'));
    }

    // Proses pengembalian mobil
    public function return(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:parkings,id',
            'slot' => 'required|integer|min:1',
        ]);

        $conflict = Parking::where('slot', $request->slot)
            ->where('id', '!=', $request->vehicle_id)
            ->first();

        if ($conflict) {
            return back()->withErrors([
                'slot' => "Tempat Parkir sudah dipakai oleh {$conflict->vehicle_name} dengan nomor polisi ({$conflict->license_number})"
            ])->withInput();
        }

        $parking = Parking::findOrFail($request->vehicle_id);
        $parking->update([
            'status' => 'available',
            'slot' => $request->slot,
            'borrower_name' => null,
            'borrower_position' => null,
            'purpose' => null,
        ]);

        return redirect()->route('parkings.index')->with('success', 'Mobil berhasil dikembalikan.');
    }

    // CRUD default (create, store, edit, update, destroy) tetap seperti sebelumnya
    public function create()
    {
        return view('parkings.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'vehicle_name' => 'required|string|max:255',
            'license_number' => [
                'required',
                'regex:/^[A-Za-z]{1,2}\d{1,4}[A-Za-z]{0,4}$/'
            ],
            'slot' => 'required|integer|min:1',
        ]);

        $conflict = Parking::where('slot', $request->slot)->first();
        if ($conflict) {
            return back()->withErrors([
                'slot' => "Tempat Parkir sudah dipakai oleh {$conflict->vehicle_name} dengan nomor polisi ({$conflict->license_number})"

            ])->withInput();
        }

        $conflict = Parking::where('license_number', $request->license_number)->first();
        if ($conflict) {
            return back()->withErrors([
                'license_number' => "Kendaraan {$conflict->vehicle_name} sudah terdaftar dengan nomor polisi ({$conflict->license_number})"

            ])->withInput();
        }

        Parking::create([
            'vehicle_name' => $request->vehicle_name,
            'license_number' => $request->license_number,
            'slot' => $request->slot,
            'status' => 'available',
        ]);

        return redirect()->route('parkings.index')->with('success', 'Parking record added successfully.');
    }

    public function edit($id)
    {
        $parking = Parking::findOrFail($id);
        return view('parkings.edit', compact('parking'));
    }

    public function update(Request $request, $id)
    {
        $parking = Parking::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'borrower_name' => 'nullable',
            'parking_location' => 'nullable',
            'borrower_position' => 'nullable',
        ]);

        $borrower_position = $request->borrower_position;
        if ($borrower_position == 'Other') {
            $borrower_position = $request->custom_borrower_position;
        }

        $parking->update([
            'status' => $request->status,
            'borrower_name' => $request->borrower_name,
            'parking_location' => $request->parking_location,
            'borrower_position' => $borrower_position,
        ]);

        return redirect()->route('parkings.index')->with('success', 'Parking record updated successfully.');
    }

    public function destroy($id)
    {
        $parking = Parking::findOrFail($id);
        $parking->delete();

        return redirect()->route('parkings.index')->with('success', 'Parking record deleted successfully.');
    }
}
