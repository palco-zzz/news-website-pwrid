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
            'slug',
            'reporter_name',
            'category',
            'status',
            'is_anonymous',
            'is_published',
            'created_at',
        ])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get the 5 most recent news articles
        $recentNews = News::select([
            'id',
            'title',
            'slug',
            'category',
            'is_published',
            'is_headline',
            'is_trending',
            'created_at',
        ])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentReports' => $recentReports,
            'recentNews' => $recentNews,
        ]);
    }
}
