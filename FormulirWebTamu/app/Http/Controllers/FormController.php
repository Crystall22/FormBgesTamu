<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;

class FormController extends Controller
{
    // Fungsi untuk menampilkan form receptionist
    public function create()
    {
        // Mengembalikan view untuk form receptionist
        return view('receptionist.buatform');
    }

    // Fungsi untuk menampilkan dashboard dengan data form yang telah disubmit
    public function dashboard()
    {
        // Mengambil semua form yang ada di database
        $forms = Form::all();

        // Mengembalikan view untuk dashboard dengan data forms
        return view('dashboard', compact('forms'));
    }

    // Fungsi untuk menyimpan data form receptionist
    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'guest_name' => 'required',
            'guest_phone' => 'required',
            'guest_address' => 'required',
            'institution' => 'required',
            'purpose' => 'required',
            'pdf_file' => 'required|file|mimes:pdf|max:2048', // PDF-only validation with max size
            'category' => 'required',
        ]);

        // Menyimpan data form ke database
        $form = new Form();
        $form->guest_name = $request->guest_name;
        $form->guest_phone = $request->guest_phone;
        $form->guest_address = $request->guest_address;
        $form->institution = $request->institution;
        $form->purpose = $request->purpose;
        $form->category = $request->category;
        $form->invoice_number = $this->generateInvoiceNumber($request->category);
        $form->date = now(); // Menyimpan tanggal otomatis
        $form->pdf_file = $request->file('pdf_file')->store('pdfs'); // Menyimpan file PDF
        $form->save();

        // Redirect ke halaman dashboard setelah form berhasil disimpan
        return redirect()->route('dashboard')->with('success', 'Form berhasil disubmit!');
    }

    // Fungsi untuk menghasilkan nomor invoice berdasarkan kategori yang dipilih
    private function generateInvoiceNumber($category)
    {
        // Mengambil increment number dari id terbesar di database
        $incrementNumber = Form::max('id') + 1;

        // Menentukan kode kategori berdasarkan kategori yang dipilih
        $categoryCode = match ($category) {
            'Business' => 'BNS', // Kode untuk kategori Business
            'Government' => 'GOV', // Kode untuk kategori Government
            'Enterprise' => 'ENT', // Kode untuk kategori Enterprise
        };

        // Menghasilkan nomor invoice dengan format yang diinginkan
        return 'INV' . now()->format('Ymd') . ',' . $incrementNumber . ',' . $categoryCode;
    }
}
