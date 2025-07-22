<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Notifications\FormForwardedNotification;

class SecretaryController extends Controller
{
    public function dashboard(Request $request)
    {
        $forms = Form::whereNull('note')->paginate(6);

        $historyQuery = Form::where('forwarded_to_management', true);

        if ($request->management_type) {
            $historyQuery->where('forwarded_to_management_type', $request->management_type);
        }
        if ($request->start_date) {
            $historyQuery->whereDate('updated_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $historyQuery->whereDate('updated_at', '<=', $request->end_date);
        }
        if ($request->search) {
            $historyQuery->where(function ($q) use ($request) {
                $q->where('guest_name', 'like', '%' . $request->search . '%')
                    ->orWhere('institution', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filter_date) {
            $historyQuery->whereDate('updated_at', $request->filter_date);
        }

        $history = $historyQuery->orderByDesc('updated_at')->paginate(6);

        // Jika AJAX, return partial
        if ($request->ajax()) {
            return view('.partials.history_list', compact('history'))->render();
        }

        return view('secretary.dashboard', compact('forms', 'history'));
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
            'management_type' => 'required|in:business,government,enterprise',
        ]);

        $form = Form::findOrFail($id);
        $form->note = $request->note;
        $form->forwarded_to_management = true;
        $form->forwarded_to_management_type = $request->management_type;
        $form->save();

        // Ambil semua user management sesuai variant
        $managements = User::where('role', 'management-' . $request->management_type)->get();
        foreach ($managements as $mgmt) {
            $mgmt->notify(new FormForwardedNotification(
                $form,
                "Ada form baru telah diteruskan ke management {$request->management_type} oleh " . auth()->user()->name . "."
            ));
        }

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

    public function checkNewForm()
    {
        $lastChecked = session('secretary_last_checked', now()->subMinutes(10));
        $form = Form::where('status', 'under review')->where('created_at', '>', $lastChecked)->latest()->first();
        session(['secretary_last_checked' => now()]);
        if ($form) {
            return response()->json([
                'new' => true,
                'name' => $form->guest_name,
            ]);
        }
        return response()->json(['new' => false]);
    }


}
