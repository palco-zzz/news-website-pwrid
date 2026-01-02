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

        return Inertia::render('Admin/News/Index', [
            'newsList' => $newsList,
            'filters' => [
                'search' => $request->input('search'),
                'status' => $request->input('status'),
                'category' => $request->input('category'),
            ],
            'categories' => $categories,
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

        // Convert string boolean values to actual booleans
        $validated['is_headline'] = filter_var($request->input('is_headline', false), FILTER_VALIDATE_BOOLEAN);
        $validated['is_trending'] = filter_var($request->input('is_trending', false), FILTER_VALIDATE_BOOLEAN);
        $validated['is_published'] = filter_var($request->input('is_published', false), FILTER_VALIDATE_BOOLEAN);

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

        // Convert string boolean values to actual booleans
        $validated['is_headline'] = filter_var($request->input('is_headline', false), FILTER_VALIDATE_BOOLEAN);
        $validated['is_trending'] = filter_var($request->input('is_trending', false), FILTER_VALIDATE_BOOLEAN);
        $validated['is_published'] = filter_var($request->input('is_published', false), FILTER_VALIDATE_BOOLEAN);

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
}
