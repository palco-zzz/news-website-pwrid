<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Inertia\Inertia;
use Inertia\Response;

class UmkmController extends Controller
{
    /**
     * Display the UMKM listing page.
     */
    public function index(): Response
    {
        $umkmList = Umkm::active()
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $featuredUmkm = Umkm::active()
            ->featured()
            ->take(3)
            ->get();

        $categories = [
            'Kuliner',
            'Fashion',
            'Kerajinan',
            'Jasa',
            'Pertanian',
            'Lainnya',
        ];

        return Inertia::render('Umkm/Index', [
            'umkmList' => $umkmList,
            'featuredUmkm' => $featuredUmkm,
            'categories' => $categories,
        ]);
    }

    /**
     * Display a single UMKM detail.
     */
    public function show(string $slug): Response
    {
        $umkm = Umkm::where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Get related UMKM from same category
        $relatedUmkm = Umkm::active()
            ->where('id', '!=', $umkm->id)
            ->where('category', $umkm->category)
            ->take(4)
            ->get();

        return Inertia::render('Umkm/Show', [
            'umkm' => $umkm,
            'relatedUmkm' => $relatedUmkm,
        ]);
    }
}
