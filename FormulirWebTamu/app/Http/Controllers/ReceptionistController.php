<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class ReceptionistController extends Controller
{
    public function dashboard()
    {
        return view('receptionist.dashboard');
    }

    public function showForm()
    {
        return view('receptionist.buatform');
    }

    public function createForm(Request $request)
    {
        $form = Form::create([
            'guest_name' => $request->input('guest_name'),
            'guest_phone' => $request->input('guest_phone'),
            'guest_address' => $request->input('guest_address'),
            'institution' => $request->input('institution'),
            'date' => now()->format('Y-m-d'), // Automatically set the current date
            'purpose' => $request->input('purpose'),
            'pdf_file' => $request->file('pdf_file')->store('pdfs'),
            'category' => $request->input('category'),
            'invoice_number' => 'INV' . now()->format('Ymd') . ',' . (Form::count() + 1) . ',' . strtoupper(substr($request->input('category'), 0, 3))
        ]);

        return redirect()->route('receptionist.dashboard');
    }
}
