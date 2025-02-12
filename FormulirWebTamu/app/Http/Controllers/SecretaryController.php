<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Form;
use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    public function dashboard()
    {
        $forms = Form::whereNull('note')->get();
        return view('secretary.dashboard', compact('forms'));
    }

    public function showForm($id)
    {
        $form = Form::findOrFail($id);
        return view('secretary.form', compact('form'));
    }
    public function updateForm(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:255',
        ]);

        $form = Form::findOrFail($id);
        $form->note = $request->note;
        $form->forwarded_to_management = true;
        $form->save();

        return redirect()->route('secretary.dashboard')->with('success', 'Form successfully forwarded to management.');
    }

    public function downloadPdf($id)
    {
        $form = Form::findOrFail($id);
        $filePath = storage_path('app/public/' . $form->pdf_file);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect()->back()->with('error', 'File not found.');
    }
}
