<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;

class FormController extends Controller
{
    public function create()
    {
        return view('receptionist.buatform');
    }
    public function dashboard()
    {
        $forms = Form::all();
        return view('dashboard', compact('forms'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'guest_name' => 'required|string',
            'guest_phone' => 'required|string',
            'guest_address' => 'required|string',
            'institution' => 'required|string',
            'purpose' => 'required|string',
            'category' => 'required|string',
            'pdf_file' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Store the uploaded PDF file and save its path
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('pdfs', 'public');
        } else {
            return redirect()->back()->with('error', 'PDF file upload failed.');
        }
        $form = new Form();
        $form->guest_name = $request->guest_name;
        $form->guest_phone = $request->guest_phone;
        $form->guest_address = $request->guest_address;
        $form->institution = $request->institution;
        $form->purpose = $request->purpose;
        $form->category = $request->category;
        $form->invoice_number = $this->generateInvoiceNumber($request->category);
        $form->date = now()->format('Y-m-d');
        $form->pdf_file = $pdfPath; // SavePDF
        $form->save();
        return redirect()->route('dashboard')->with('success', 'Form successfully submitted!');
    }
    private function generateInvoiceNumber($category)
    {
        // Mengambil increment number dari id terbesar di database
        $incrementNumber = Form::max('id') + 1;

        $categoryCode = match ($category) {
            'Business' => 'BNS',
            'Government' => 'GOV',
            'Enterprise' => 'ENT',
        };
        return 'INV' . $incrementNumber . now()->format('Ymd') . $categoryCode;
    }
}
