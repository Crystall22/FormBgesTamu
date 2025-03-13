<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;

class ParkingController extends Controller
{
    // Display the list of parkings
    public function index()
    {
        $parkings = Parking::all(); // Fetch all parking records from the database
        return view('parkings.index', data: compact('parkings'));
    }
    public function create()
    {
        return view('parkings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_name' => 'required',
            'license_number' => [
                'required',
                'regex:/^[A-Za-z]{1,2}\d{1,4}[A-Za-z]{0,4}$/'
            ],
        ]);

        Parking::create([
            'vehicle_name' => $request->vehicle_name,
            'license_number' => $request->license_number,
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
