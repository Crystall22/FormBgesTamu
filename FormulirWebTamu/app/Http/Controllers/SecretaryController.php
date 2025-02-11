<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    public function dashboard()
    {
        $forms = Form::where('status', 'under_review')->get();
        return view('secretary.dashboard', compact('forms'));
    }

    public function addNote(Request $request, $id)
    {
        $form = Form::find($id);
        $form->note = $request->input('note');
        $form->status = 'reviewed';
        $form->save();

        return redirect()->route('secretary.dashboard')->with('success', 'Form has been forwarded to management.');
    }

}

