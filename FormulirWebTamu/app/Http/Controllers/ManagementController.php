<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function dashboard()
    {
        $forms = Form::where('status', '!=', 'Pending')->get();
        return view('management.dashboard', compact('forms'));
    }

    public function approve(Form $form)
    {
        $form->update(['status' => 'Approved']);
        return redirect()->route('management.dashboard');
    }

    public function reject(Form $form)
    {
        $form->update(['status' => 'Rejected']);
        return redirect()->route('management.dashboard');
    }
}
