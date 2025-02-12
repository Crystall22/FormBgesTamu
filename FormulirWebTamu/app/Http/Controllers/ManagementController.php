<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    // Menampilkan dashboard untuk management
    public function dashboard()
    {
        // Mengambil form yang diteruskan ke manajemen dan belum di-approve/reject
        $formsUnderReview = Form::where('forwarded_to_management', true)
            ->whereNull('status')
            ->get();

        // Mengambil form yang sudah di-approve atau ditolak
        $formsHistory = Form::where('forwarded_to_management', true)
            ->whereIn('status', ['approved', 'rejected'])
            ->get();

        // Menampilkan ke view management.dashboard dengan kedua variabel
        return view('management.dashboard', compact('formsUnderReview', 'formsHistory'));
    }

    // Fungsi untuk approve form
    public function approve($id)
    {
        $form = Form::find($id);
        $form->status = 'approved';
        $form->save();

        return redirect()->route('management.dashboard')->with('success', 'Form approved successfully.');
    }

    // Fungsi untuk reject form
    public function reject($id)
    {
        $form = Form::find($id);
        $form->status = 'rejected';
        $form->save();

        return redirect()->route('management.dashboard')->with('success', 'Form rejected successfully.');
    }
}
