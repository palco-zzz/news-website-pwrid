<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitizenReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CitizenReportController extends Controller
{
    /**
     * Display a listing of the citizen reports.
     */
    public function index(Request $request)
    {
        $query = CitizenReport::with('reporter')
            ->orderBy('created_at', 'desc');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('reporter_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $reports = $query->paginate(15)->withQueryString();

        // Get unique categories for filter
        $categories = CitizenReport::distinct()->pluck('category')->filter()->values();

        return Inertia::render('Admin/CitizenReports/Index', [
            'reports' => $reports,
            'filters' => $request->only(['search', 'status', 'category']),
            'categories' => $categories,
        ]);
    }

    /**
     * Display the specified citizen report.
     */
    public function show(CitizenReport $citizenReport)
    {
        $citizenReport->load('reporter');

        return Inertia::render('Admin/CitizenReports/Show', [
            'report' => $citizenReport,
        ]);
    }

    /**
     * Update the status of the specified citizen report.
     */
    public function updateStatus(Request $request, CitizenReport $citizenReport)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,in_progress,resolved,rejected',
        ]);

        $citizenReport->update([
            'status' => $request->input('status'),
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    /**
     * Update the specified citizen report.
     */
    public function update(Request $request, CitizenReport $citizenReport)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,verified,in_progress,resolved,rejected',
            'admin_note' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        // Set published_at only when publishing and it's currently null
        if ($validated['is_published'] && empty($citizenReport->published_at)) {
            $validated['published_at'] = now();
        }

        $citizenReport->update($validated);

        return back()->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Toggle the published status of the specified citizen report.
     */
    public function togglePublish(CitizenReport $citizenReport)
    {
        $newPublishedState = !$citizenReport->is_published;

        $updateData = [
            'is_published' => $newPublishedState,
        ];

        // Set published_at only when publishing and it's currently null
        if ($newPublishedState && empty($citizenReport->published_at)) {
            $updateData['published_at'] = now();
        }

        $citizenReport->forceFill($updateData)->save();

        $message = $citizenReport->is_published
            ? 'Laporan berhasil dipublikasikan.'
            : 'Laporan berhasil di-unpublish.';

        return back()->with('success', $message);
    }

    /**
     * Remove the specified citizen report from storage.
     */
    public function destroy(CitizenReport $citizenReport)
    {
        $citizenReport->delete();

        return back()->with('success', 'Laporan berhasil dihapus.');
    }
}
