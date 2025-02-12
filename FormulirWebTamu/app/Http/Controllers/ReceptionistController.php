{{--

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class ReceptionistController extends Controller
{
public function dashboard()
{
$forms = Form::all();
return view('receptionist.dashboard', compact('forms'));
}

public function showForm()
{
return view('receptionist.buatform');
}

private function generateInvoiceNumber($category)
{
$incrementNumber = Form::max('id') + 1;
$categoryCode = match ($category) {
'Business' => 'BNS',
'Government' => 'GOV',
'Enterprise' => 'ENT',
};
return 'INV' . $incrementNumber . now()->format('Ymd') . $categoryCode;
}

public function createForm(Request $request)
{
$request->validate([
'guest_name' => 'required|string',
'guest_phone' => 'required|string',
'guest_address' => 'required|string',
'institution' => 'required|string',
'category' => 'required|string',
'pdf_file' => 'required|file|mimes:pdf|max:2048',
]);


if ($request->hasFile('pdf_file')) {
$pdfPath = $request->file('pdf_file')->store('pdfs', 'public');
} else {
return redirect()->back()->with('error', 'PDF file upload failed.');
}

$form = Form::create([
'guest_name' => $request->input('guest_name'),
'guest_phone' => $request->input('guest_phone'),
'guest_address' => $request->input('guest_address'),
'institution' => $request->input('institution'),
'date' => now()->format('Y-m-d'),
'purpose' => $request->input('purpose'),
'pdf_file' => $pdfPath,
'category' => $request->input('category'),
'invoice_number' => $this->generateInvoiceNumber($request->input('category'))
]);
return redirect()->route('receptionist.dashboard')->with('success', 'Form submitted successfully!');
}
}
--}}