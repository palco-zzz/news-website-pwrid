<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Umkm;
use App\Models\CitizenReport;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Display the home page with latest news, UMKM, and citizen reports.
     */
    public function index(): Response
    {
        // Get the headline article
        $headline = News::published()
            ->headline()
            ->latest()
            ->first();

        // Get latest articles (excluding headline)
        $articles = News::published()
            ->where('is_headline', false)
            ->latest()
            ->take(6)
            ->get();

        // Get featured UMKM
        $featuredUmkm = Umkm::active()
            ->featured()
            ->take(5)
            ->get();

        // Get latest citizen reports
        $citizenReports = CitizenReport::published()
            ->latest()
            ->take(4)
            ->get();

        return Inertia::render('Home', [
            'headline' => $headline,
            'articles' => $articles,
            'featuredUmkm' => $featuredUmkm,
            'citizenReports' => $citizenReports,
        ]);
    }
}
