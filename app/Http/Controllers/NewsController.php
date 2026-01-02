<?php

namespace App\Http\Controllers;

use App\Models\News;
use Carbon\Carbon;
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
        // Fetch the news article with author relationship
        $news = News::with('author')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment views count
        $news->increment('views_count');

        // Format the news data with human-readable date
        $formattedNews = [
            'id' => $news->id,
            'title' => $news->title,
            'slug' => $news->slug,
            'excerpt' => $news->excerpt,
            'content' => $news->content,
            'image' => $news->image,
            'image_url' => $news->image_url,
            'image_caption' => $news->image_caption ?? null,
            'category' => $news->category,
            'tags' => $news->tags ?? [],
            'is_headline' => $news->is_headline,
            'is_trending' => $news->is_trending,
            'views_count' => $news->views_count,
            'published_at' => $news->published_at?->toISOString(),
            'published_at_formatted' => $news->published_at
                ? Carbon::parse($news->published_at)->locale('id')->translatedFormat('d F Y')
                : null,
            'created_at' => $news->created_at->toISOString(),
            'author' => $news->author ? [
                'id' => $news->author->id,
                'name' => $news->author->name,
                'avatar' => $news->author->avatar ?? null,
            ] : null,
        ];

        // Fetch 4 related news articles from the same category
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category', $news->category)
            ->with('author')
            ->latest('published_at')
            ->take(4)
            ->get()
            ->map(function ($related) {
                return [
                    'id' => $related->id,
                    'title' => $related->title,
                    'slug' => $related->slug,
                    'image' => $related->image,
                    'image_url' => $related->image_url,
                    'category' => $related->category,
                    'published_at' => $related->published_at?->toISOString(),
                    'published_at_formatted' => $related->published_at
                        ? Carbon::parse($related->published_at)->locale('id')->translatedFormat('d M Y')
                        : null,
                ];
            });

        return Inertia::render('News/Show', [
            'news' => $formattedNews,
            'relatedNews' => $relatedNews,
        ]);
    }
}
