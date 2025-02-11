<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function dashboard()
    {
        $forms = Form::where('status', 'reviewed')
            ->where('category', auth()->user()->department) // Match category with management department
            ->get();

        return view('management.dashboard', compact('forms'));
    }

    public function updateStatus(Request $request, $id)
    {
        $form = Form::find($id);
        $form->status = $request->input('status');
        $form->save();

        return redirect()->route('management.dashboard')->with('success', 'Form status updated.');
    }

}
