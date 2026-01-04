<?php

namespace App\Http\Controllers;

use App\Models\CitizenReport;
use Inertia\Inertia;
use Inertia\Response;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CitizenReportController extends Controller
{
    /**
     * Store a newly created citizen report.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:10240', // 10MB max
            'is_anonymous' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('citizen-reports', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        $validated['status'] = 'pending';
        $validated['is_published'] = false;
        
        // Handle reporter info
        if ($request->user()) {
            $validated['reporter_id'] = $request->user()->id;
            $validated['reporter_name'] = $request->user()->name;
        } else {
             $validated['reporter_name'] = $request->input('reporter_name', 'Warga Sipil');
        }

        // Handle boolean checkbox explicitly
        $validated['is_anonymous'] = $request->boolean('is_anonymous');

        CitizenReport::create($validated);

        return back()->with('success', 'Laporan berhasil dikirim dan menunggu verifikasi admin.');
    }
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
    public function show(Request $request, string $slug): Response
    {
        // Allow authenticated users to preview any report (for admins)
        // Regular visitors can only see published reports
        $query = CitizenReport::where('slug', $slug);

        if (!$request->user()) {
            $query->published();
        }

        $report = $query->firstOrFail();

        // Get related reports from same category (always published)
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
