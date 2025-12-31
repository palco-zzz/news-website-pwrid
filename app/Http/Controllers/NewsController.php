<?php

namespace App\Http\Controllers;

use App\Models\News;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    /**
     * Display the trending news page.
     */
    public function trending(): Response
    {
        $trendingNews = News::published()
            ->trending()
            ->latest()
            ->paginate(12);

        $topStories = News::published()
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        return Inertia::render('News/Trending', [
            'trendingNews' => $trendingNews,
            'topStories' => $topStories,
        ]);
    }

    /**
     * Display a single news article.
     */
    public function show(string $slug): Response
    {
        $news = News::where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment views count
        $news->increment('views_count');

        // Get related articles
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category', $news->category)
            ->latest()
            ->take(4)
            ->get();

        return Inertia::render('News/Show', [
            'news' => $news,
            'relatedNews' => $relatedNews,
        ]);
    }
}
