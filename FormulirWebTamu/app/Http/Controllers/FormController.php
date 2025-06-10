<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

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
            'guest_name' => 'required|string|max:75',
            'guest_phone' => 'required|numeric|digits_between:10,14',
            'guest_address' => 'required|string|max:200',
            'institution' => 'required|string|max:100',
            'purpose' => 'required|string|max:300',
            'taken' => 'required|string',
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
        $form->taken = $request->taken;
        $form->invoice_number = $this->generateInvoiceNumber($request->taken);
        $form->date = now()->format('Y-m-d');
        $form->pdf_file = $pdfPath;
        $form->save();

        // Generate QR code setelah form disimpan (pakai ID form) dengan driver default (GD jika imagick tidak ada)
        $qrUrl = route('form.qr', $form->id);
        $qrImage = QrCode::format('png')->size(300)->generate($qrUrl);
        $qrPath = 'qrcodes/form_' . $form->id . '.png';
        Storage::disk('public')->put($qrPath, $qrImage);

        // Simpan path QR ke database
        $form->qr_code = $qrPath;
        $form->save();

        return redirect()->route('dashboard')->with('success', 'Form successfully submitted!');
    }

    public function showForms(Request $request)
    {
        $searchQuery = $request->input('search');
        $sortOrder = $request->input('sort', 'desc');

        $forms = Form::query()
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query->where('guest_name', 'like', "%{$searchQuery}%")
                    ->orWhere('taken', 'like', "%{$searchQuery}%");
            })
            ->orderBy('created_at', $sortOrder)
            ->paginate(5)
            ->appends(['search' => $searchQuery, 'sort' => $sortOrder]);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.tabel', compact('forms'))->render(),
                'pagination' => (string) $forms->links(),
            ]);
        }

        return view('dashboard', compact('forms', 'searchQuery', 'sortOrder'));
    }

    public function deleteScreen(Request $request)
    {
        $searchQuery = $request->input('search');
        $sortOrder = $request->input('sort', 'desc');

        $forms = Form::query()
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query->where('guest_name', 'like', "%{$searchQuery}%")
                    ->orWhere('taken', 'like', "%{$searchQuery}%");
            })
            ->orderBy('created_at', $sortOrder)
            ->paginate(5)
            ->appends(['search' => $searchQuery, 'sort' => $sortOrder]);

        // Check if the request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.delete-tabel', compact('forms'))->render(),
                'pagination' => (string) $forms->links(),
            ]);
        }

        return view('receptionist.deleteform', compact('forms', 'searchQuery', 'sortOrder'));
    }

    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->delete();

        return redirect()->route('form.deleteScreen')->with('success', 'Form successfully deleted.');
    }

    private function generateInvoiceNumber($taken)
    {
        // Mengambil increment number dari id terbesar di database
        $incrementNumber = Form::max('id') + 1;
        $takenCode = match ($taken) {
            'Sule' => 'SUL',
            'Ardi' => 'ARD',
            'Hutri' => 'HUT',
        };

        // Generate the invoice number
        return 'INV' . now()->format('Ymd') . $incrementNumber . $takenCode;
    }

    public function showDetail($id)
    {
        $form = Form::findOrFail($id);
        return view('receptionist.detail', compact('form'));
    }

    public function showQrDetail($id)
    {
        $form = Form::findOrFail($id);
        return view('form.qr-detail', compact('form'));
    }
}
