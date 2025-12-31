<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AgendaController extends Controller
{
    /**
     * Display a listing of the agendas.
     */
    public function index(Request $request)
    {
        // Placeholder data - replace with actual model when created
        $agendaList = [
            [
                'id' => 1,
                'title' => 'Rapat Koordinasi Desa',
                'slug' => 'rapat-koordinasi-desa',
                'date' => '2026-01-15',
                'time' => '09:00',
                'location' => 'Balai Desa Purworejo',
                'category' => 'Pemerintahan',
                'status' => 'published',
                'created_at' => '2026-01-01',
            ],
            [
                'id' => 2,
                'title' => 'Festival Budaya Purworejo',
                'slug' => 'festival-budaya-purworejo',
                'date' => '2026-01-20',
                'time' => '08:00',
                'location' => 'Alun-alun Purworejo',
                'category' => 'Budaya',
                'status' => 'published',
                'created_at' => '2026-01-02',
            ],
            [
                'id' => 3,
                'title' => 'Bazar UMKM Mingguan',
                'slug' => 'bazar-umkm-mingguan',
                'date' => '2026-01-22',
                'time' => '07:00',
                'location' => 'Pasar Baledono',
                'category' => 'Ekonomi',
                'status' => 'draft',
                'created_at' => '2026-01-03',
            ],
        ];

        return Inertia::render('Admin/Agenda/Index', [
            'agendaList' => [
                'data' => $agendaList,
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 15,
                'total' => count($agendaList),
                'from' => 1,
                'to' => count($agendaList),
                'links' => [],
            ],
            'filters' => $request->only(['search', 'status']),
            'stats' => [
                'total' => count($agendaList),
                'upcoming' => 2,
                'completed' => 1,
            ],
        ]);
    }

    /**
     * Store a newly created agenda in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,published',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);

        // TODO: Save to database when Agenda model is created
        // Agenda::create($validated);

        return back()->with('success', 'Agenda berhasil dibuat.');
    }

    /**
     * Display the specified agenda.
     */
    public function show(int $id)
    {
        // TODO: Fetch from database when Agenda model is created
        return Inertia::render('Admin/Agenda/Show', [
            'agenda' => [
                'id' => $id,
                'title' => 'Sample Agenda',
                'slug' => 'sample-agenda',
                'date' => '2026-01-15',
                'time' => '09:00',
                'location' => 'Balai Desa Purworejo',
                'category' => 'Pemerintahan',
                'description' => 'Sample description',
                'status' => 'published',
            ],
        ]);
    }

    /**
     * Show the form for editing the specified agenda.
     */
    public function edit(int $id)
    {
        // TODO: Fetch from database when Agenda model is created
        return Inertia::render('Admin/Agenda/Edit', [
            'agenda' => [
                'id' => $id,
                'title' => 'Sample Agenda',
                'slug' => 'sample-agenda',
                'date' => '2026-01-15',
                'time' => '09:00',
                'location' => 'Balai Desa Purworejo',
                'category' => 'Pemerintahan',
                'description' => 'Sample description',
                'status' => 'published',
            ],
        ]);
    }

    /**
     * Update the specified agenda in storage.
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,published',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);

        // TODO: Update in database when Agenda model is created
        // Agenda::findOrFail($id)->update($validated);

        return back()->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Remove the specified agenda from storage.
     */
    public function destroy(int $id)
    {
        // TODO: Delete from database when Agenda model is created
        // Agenda::findOrFail($id)->delete();

        return back()->with('success', 'Agenda berhasil dihapus.');
    }
}
