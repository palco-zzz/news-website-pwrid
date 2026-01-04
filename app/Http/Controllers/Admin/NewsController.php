<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    /**
     * Display a listing of news articles.
     */
    public function index(Request $request): Response
    {
        $query = News::query()->with('author:id,name');

        // Search filter
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        // Status filter
        if ($status = $request->input('status')) {
            if ($status === 'published') {
                $query->where('is_published', true);
            } elseif ($status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Category filter
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $newsList = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Get distinct categories
        $categories = News::distinct()->pluck('category')->filter()->values()->toArray();

        // Get current headline (for featured management)
        $currentHeadline = News::where('is_headline', true)->first();

        // Get trending news (for featured management)
        $trendingNews = News::where('is_trending', true)->get();

        // Get all published news (for select dropdowns)
        $allPublishedNews = News::where('is_published', true)
            ->select('id', 'title', 'slug', 'is_headline', 'is_trending')
            ->orderBy('title')
            ->get();

        return Inertia::render('Admin/News/Index', [
            'newsList' => $newsList,
            'filters' => [
                'search' => $request->input('search'),
                'status' => $request->input('status'),
                'category' => $request->input('category'),
            ],
            'categories' => $categories,
            'currentHeadline' => $currentHeadline,
            'trendingNews' => $trendingNews,
            'allPublishedNews' => $allPublishedNews,
        ]);
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/News/Editor', [
            'isEditing' => false,
            'categories' => ['Berita', 'Politik', 'Ekonomi', 'Olahraga', 'Hiburan', 'Teknologi', 'Kesehatan', 'Pendidikan'],
        ]);
    }

    /**
     * Store a newly created news article.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,webp,gif|max:5120',
            'category' => 'required|string|max:100',
            'is_headline' => 'nullable',
            'is_trending' => 'nullable',
            'is_published' => 'nullable',
            'published_at' => 'nullable|date',
        ]);

        // Convert checkbox values to booleans (handles missing values when unchecked)
        $validated['is_headline'] = $request->boolean('is_headline');
        $validated['is_trending'] = $request->boolean('is_trending');
        $validated['is_published'] = $request->boolean('is_published');

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        }

        // Set author
        $validated['author_id'] = $request->user()->id;

        // Set publish date if publishing
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        News::create($validated);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit(News $news): Response
    {
        return Inertia::render('Admin/News/Editor', [
            'news' => $news,
            'isEditing' => true,
            'categories' => ['Berita', 'Politik', 'Ekonomi', 'Olahraga', 'Hiburan', 'Teknologi', 'Kesehatan', 'Pendidikan'],
        ]);
    }

    /**
     * Update the specified news article.
     */
    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug,' . $news->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,webp,gif|max:5120',
            'category' => 'required|string|max:100',
            'is_headline' => 'nullable',
            'is_trending' => 'nullable',
            'is_published' => 'nullable',
            'published_at' => 'nullable|date',
        ]);

        // Convert checkbox values to booleans (handles missing values when unchecked)
        $validated['is_headline'] = $request->boolean('is_headline');
        $validated['is_trending'] = $request->boolean('is_trending');
        $validated['is_published'] = $request->boolean('is_published');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', 'public');
        } else {
            // Keep existing image if no new file uploaded
            unset($validated['image']);
        }

        // Generate slug if not provided or if title changed
        if (empty($validated['slug']) || $validated['title'] !== $news->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        }

        // Set publish date if publishing for first time
        if ($validated['is_published'] && !$news->is_published && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $news->update($validated);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified news article.
     */
    public function destroy(News $news): RedirectResponse
    {
        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Toggle a boolean status field on a news article.
     */
    public function toggleStatus(News $news, string $field): RedirectResponse
    {
        if (!in_array($field, ['is_headline', 'is_trending', 'is_published'])) {
            return back()->with('error', 'Field tidak valid.');
        }

        $news->forceFill([
            $field => !$news->{$field},
        ])->save();

        $labels = [
            'is_headline' => 'Headline',
            'is_trending' => 'Trending',
            'is_published' => 'Publish',
        ];

        $status = $news->{$field} ? 'aktif' : 'nonaktif';

        return back()->with('success', "{$labels[$field]} berhasil di{$status}kan.");
    }

    /**
     * Set a specific news as the headline (only one can be headline at a time).
     */
    public function setHeadline(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'news_id' => 'nullable|exists:news,id',
        ]);

        // Remove headline from all news
        News::where('is_headline', true)->update(['is_headline' => false]);

        // Set new headline if provided
        if (!empty($validated['news_id'])) {
            News::where('id', $validated['news_id'])->update(['is_headline' => true]);
        }

        return back()->with('success', 'Headline berhasil diperbarui.');
    }

    /**
     * Update trending news (multiple can be trending).
     */
    public function setTrending(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'news_ids' => 'array',
            'news_ids.*' => 'exists:news,id',
        ]);

        // Remove trending from all news
        News::where('is_trending', true)->update(['is_trending' => false]);

        // Set new trending news
        if (!empty($validated['news_ids'])) {
            News::whereIn('id', $validated['news_ids'])->update(['is_trending' => true]);
        }

        return back()->with('success', 'Trending berhasil diperbarui.');
    }
}
