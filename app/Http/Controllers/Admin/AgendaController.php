<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
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
        $query = Agenda::orderBy('date', 'desc');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $agendaList = $query->paginate(15)->withQueryString();

        // Get stats
        $stats = [
            'total' => Agenda::count(),
            'upcoming' => Agenda::published()->upcoming()->count(),
            'completed' => Agenda::published()->past()->count(),
        ];

        return Inertia::render('Admin/Agenda/Index', [
            'agendaList' => $agendaList,
            'filters' => $request->only(['search', 'status']),
            'stats' => $stats,
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
            'end_time' => 'nullable|string',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:5120',
        ]);

        // Generate unique slug
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('agendas', 'public');
        }

        // Set creator
        $validated['created_by'] = $request->user()->id;

        Agenda::create($validated);

        return back()->with('success', 'Agenda berhasil dibuat.');
    }

    /**
     * Display the specified agenda.
     */
    public function show(Agenda $agenda)
    {
        return Inertia::render('Admin/Agenda/Show', [
            'agenda' => $agenda,
        ]);
    }

    /**
     * Show the form for editing the specified agenda.
     */
    public function edit(Agenda $agenda)
    {
        return Inertia::render('Admin/Agenda/Edit', [
            'agenda' => $agenda,
        ]);
    }

    /**
     * Update the specified agenda in storage.
     */
    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:5120',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('agendas', 'public');
        }

        $agenda->update($validated);

        return back()->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Remove the specified agenda from storage.
     */
    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return back()->with('success', 'Agenda berhasil dihapus.');
    }
}
