<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class UmkmController extends Controller
{
    /**
     * Display a listing of UMKM.
     */
    public function index(Request $request): Response
    {
        $query = Umkm::query();

        // Search filter
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Status filter
        if ($status = $request->input('status')) {
            if ($status === 'verified') {
                $query->where('is_verified', true);
            } elseif ($status === 'pending') {
                $query->where('is_verified', false);
            }
        }

        // Category filter
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $umkmList = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Get distinct categories
        $categories = Umkm::distinct()->pluck('category')->filter()->values()->toArray();

        return Inertia::render('Admin/Umkm/Index', [
            'umkmList' => $umkmList,
            'filters' => [
                'search' => $request->input('search'),
                'status' => $request->input('status'),
                'category' => $request->input('category'),
            ],
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new UMKM.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Umkm/Create', [
            'categories' => ['Kuliner', 'Fashion', 'Kerajinan', 'Jasa', 'Pertanian', 'Lainnya'],
        ]);
    }

    /**
     * Store a newly created UMKM.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,webp,gif|max:5120',
            'category' => 'required|string|max:100',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('umkm', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        $validated['is_active'] = true;
        $validated['is_verified'] = false;

        Umkm::create($validated);

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified UMKM.
     */
    public function edit(Umkm $umkm): Response
    {
        return Inertia::render('Admin/Umkm/Edit', [
            'umkm' => $umkm,
            'categories' => ['Kuliner', 'Fashion', 'Kerajinan', 'Jasa', 'Pertanian', 'Lainnya'],
        ]);
    }

    /**
     * Update the specified UMKM.
     */
    public function update(Request $request, Umkm $umkm): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,webp,gif|max:5120',
            'category' => 'required|string|max:100',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($umkm->image && Storage::disk('public')->exists($umkm->image)) {
                Storage::disk('public')->delete($umkm->image);
            }
            $validated['image'] = $request->file('image')->store('umkm', 'public');
        } else {
            // Keep existing image if no new file uploaded
            unset($validated['image']);
        }

        $umkm->update($validated);

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil diperbarui.');
    }

    /**
     * Verify the specified UMKM.
     */
    public function verify(Umkm $umkm): RedirectResponse
    {
        $umkm->update(['is_verified' => true]);

        return redirect()
            ->back()
            ->with('success', 'UMKM berhasil diverifikasi.');
    }

    /**
     * Remove the specified UMKM.
     */
    public function destroy(Umkm $umkm): RedirectResponse
    {
        $umkm->delete();

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil dihapus.');
    }
}
