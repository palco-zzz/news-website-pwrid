<?php

namespace App\Http\Controllers;

use App\Models\CitizenReport;
use Inertia\Inertia;
use Inertia\Response;

class CitizenReportController extends Controller
{
    /**
     * Display the citizen reports listing page (Info Warga).
     */
    public function index(): Response
    {
        $reports = CitizenReport::published()
            ->latest()
            ->paginate(12);

        $popularReports = CitizenReport::published()
            ->popular()
            ->take(5)
            ->get();

        $categories = [
            'Umum',
            'Infrastruktur',
            'Keamanan',
            'Kesehatan',
            'Lingkungan',
            'Sosial',
        ];

        return Inertia::render('CitizenReport/Index', [
            'reports' => $reports,
            'popularReports' => $popularReports,
            'categories' => $categories,
        ]);
    }

    /**
     * Display a single citizen report.
     */
    public function show(string $slug): Response
    {
        $report = CitizenReport::where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Get related reports from same category
        $relatedReports = CitizenReport::published()
            ->where('id', '!=', $report->id)
            ->where('category', $report->category)
            ->latest()
            ->take(4)
            ->get();

        return Inertia::render('CitizenReport/Show', [
            'report' => $report,
            'relatedReports' => $relatedReports,
        ]);
    }
}
