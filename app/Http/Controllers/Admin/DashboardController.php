<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitizenReport;
use App\Models\News;
use App\Models\Umkm;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): Response
    {
        $stats = [
            'totalNews' => News::count(),
            'totalUmkm' => Umkm::count(),
            'totalReports' => CitizenReport::where('status', 'pending')->count(),
            'totalAgenda' => 0, // TODO: Add Agenda model when created
        ];

        // Get the 5 most recent citizen reports
        $recentReports = CitizenReport::select([
            'id',
            'title',
            'reporter_name',
            'category',
            'status',
            'is_anonymous',
            'created_at',
        ])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentReports' => $recentReports,
        ]);
    }
}
