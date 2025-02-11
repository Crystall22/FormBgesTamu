<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

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
        // Retrieve all forms from the database to show on the dashboard
        $forms = Form::all();
        return view('receptionist.dashboard', compact('forms'));
    }

    public function showForm()
    {
        return view('receptionist.buatform');
    }

    public function createForm(Request $request)
    {
        // Validate the request data (you can add more validations as needed)
        $request->validate([
            'guest_name' => 'required|string',
            'guest_phone' => 'required|string',
            'guest_address' => 'required|string',
            'institution' => 'required|string',
            'pdf_file' => 'required|file|mimes:pdf|max:2048', // Ensure it's a PDF
            'category' => 'required|string',
        ]);

        // Create the form record in the database
        $form = Form::create([
            'guest_name' => $request->input('guest_name'),
            'guest_phone' => $request->input('guest_phone'),
            'guest_address' => $request->input('guest_address'),
            'institution' => $request->input('institution'),
            'date' => now()->format('Y-m-d'), // Automatically set the current date
            'purpose' => $request->input('purpose'),
            'pdf_file' => $request->file('pdf_file')->store('pdfs'),
            'category' => $request->input('category'),
            'invoice_number' => 'INV'(Form::count() + 1) . now()->format('Ymd') . strtoupper(substr($request->input('category'), 0, 3))
        ]);

        // Redirect to the dashboard with a success message
        return redirect()->route('receptionist.dashboard')->with('success', 'Form submitted successfully!');
    }
}
