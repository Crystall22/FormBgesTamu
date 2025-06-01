<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function dashboard(Request $request, $type = 'business')
    {
        $validTypes = ['business', 'government', 'enterprise'];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $search = $request->input('search');
        $sortOrder = $request->input('sort', 'desc');

        $formsUnderReview = Form::where('forwarded_to_management', true)
            ->where('forwarded_to_management_type', $type)
            ->whereNull('status')
            ->when($search, function ($query, $search) {
                return $query->where('guest_name', 'like', "%{$search}%")
                    ->orWhere('receptionist_name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', $sortOrder)
            ->paginate(10, ['*'], 'underReviewPage');

        $formsHistory = Form::where('forwarded_to_management', true)
            ->where('forwarded_to_management_type', $type)
            ->whereIn('status', ['approved', 'rejected'])
            ->when($search, function ($query, $search) {
                return $query->where('guest_name', 'like', "%{$search}%")
                    ->orWhere('receptionist_name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', $sortOrder)
            ->paginate(10, ['*'], 'historyPage');

        return view('management.dashboard', compact('formsUnderReview', 'formsHistory', 'type'));
    }


    public function approve($id)
    {
        $form = Form::findOrFail($id);
        $form->status = 'approved';
        $form->save();

        return redirect()->back()->with('success', 'Form approved successfully.');
    }

    public function reject($id)
    {
        $form = Form::findOrFail($id);
        $form->status = 'rejected';
        $form->save();

        return redirect()->back()->with('success', 'Form rejected successfully.');
    }
}
