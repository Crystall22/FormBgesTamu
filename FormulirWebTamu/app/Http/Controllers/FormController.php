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
    public function dashboard(Request $request)
    {
        return $this->showForms($request);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'guest_name' => 'required|string|max_digits:75',
            'guest_phone' => 'required|numeric|between:10,14',
            'guest_address' => 'required|string|max_digits:200',
            'institution' => 'required|string|max_digits:100',
            'purpose' => 'required|string|max_digits:300',
            'category' => 'required|string',
            'pdf_file' => 'required|file|mimes:pdf|max:2048',
        ]);

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

    public function showForms(Request $request)
    {
        $searchQuery = $request->input('search');
        $forms = Form::query();
        if ($searchQuery) {
            $forms = $forms->where('guest_name', 'LIKE', '%' . $searchQuery . '%');
        }

        $forms = $forms->orderBy('created_at', 'desc')->paginate(5);

        // AJAX request, partial view dan pagination
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.tabel', compact('forms'))->render(),
                'pagination' => (string) $forms->links()
            ]);
        }

        return view('dashboard', compact('forms', 'searchQuery'));
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

        // Generate the invoice number
        return 'INV' . now()->format('Ymd') . $incrementNumber . $categoryCode;
    }
}
