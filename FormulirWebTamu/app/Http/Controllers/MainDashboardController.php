<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Form;
use App\Models\CallCenter;
use App\Models\Queue; // Jika ada model Queue, jika tidak, abaikan

class MainDashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::count();
        $totalForms = Form::count();
        $todayForms = Form::whereDate('created_at', now()->toDateString())->count();
        $unreadNotifs = auth()->user()->unreadNotifications()->count();

        // --- Pengaduan dari CallCenter ---
        $callQuery = CallCenter::query();
        if ($request->filled('complaint_range')) {
            $dates = explode(' - ', $request->complaint_range);
            $start = trim($dates[0]);
            $end = isset($dates[1]) ? trim($dates[1]) : $start;
            $callQuery->whereBetween('created_at', [$start, $end]);
        }
        $totalComplaints = $callQuery->count();
        $complaintByCategory = $callQuery->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')->pluck('total', 'category')->toArray();

        $todayQueues = class_exists(Queue::class)
            ? Queue::whereDate('created_at', now()->toDateString())->count()
            : 0;
        $queuePerDay = class_exists(Queue::class)
            ? Queue::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->whereBetween('created_at', [
                    now()->subDays(14)->startOfDay(),
                    now()->endOfDay()
                ])
                ->groupBy('date')->orderBy('date')->pluck('total', 'date')->toArray()
            : [];

        $recentActivities = Form::orderBy('created_at', 'desc')->take(5)->get()->map(function ($form) {
            return [
                'title' => 'Form dari ' . ($form->guest_name ?? 'Tamu') . ' (' . ($form->institution ?? '-') . ')',
                'time' => $form->created_at->format('d-m-Y H:i')
            ];
        });

        return view('main-dashboard', compact(
            'totalUsers',
            'totalForms',
            'unreadNotifs',
            'todayForms',
            'recentActivities',
            'totalComplaints',
            'complaintByCategory',
            'todayQueues',
            'queuePerDay'
        ));
    }
}
