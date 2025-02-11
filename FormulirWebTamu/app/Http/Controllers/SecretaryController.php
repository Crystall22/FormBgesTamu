<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    public function dashboard()
    {
        $forms = Form::where('status', 'Pending')->get();
        return view('secretary.dashboard', compact('forms'));
    }

    public function addNoteAndForward(Request $request, Form $form)
    {
        $form->update([
            'secretary_note' => $request->input('note')
        ]);

        return redirect()->route('secretary.dashboard');
    }
}

