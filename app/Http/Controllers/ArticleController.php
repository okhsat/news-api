<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a paginated list of articles with optional filters.
     */
    public function index(Request $request)
    {
        $query = Article::with(['source', 'category']);

        // Filtering
        $query->when($request->source_id, fn($q) => $q->where('source_id', $request->source_id));
        $query->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id));
        $query->when($request->author, fn($q) => $q->where('author', 'like', "%{$request->author}%"));
        $query->when($request->date_from, fn($q) => $q->whereDate('published_at', '>=', $request->date_from));
        $query->when($request->date_to, fn($q) => $q->whereDate('published_at', '<=', $request->date_to));

        // Full-text search (title & description)
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $query->orderBy('published_at', 'desc');

        // Pagination
        $perPage = $request->get('per_page', 20);

        return $query->paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'source_id'    => 'required|exists:sources,id',
            'category_id'  => 'nullable|exists:categories,id',
            'title'        => 'required|string',
            'description'  => 'nullable|string',
            'content'      => 'nullable|string',
            'author'       => 'nullable|string|max:255',
            'url'          => 'required|url|unique:articles,url',
            'image_url'    => 'nullable|url',
            'published_at' => 'nullable|date',
        ]);

        return Article::create($data);
    }

    public function show(Article $article)
    {
        return $article->load(['source', 'category']);
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'source_id'    => 'sometimes|exists:sources,id',
            'category_id'  => 'nullable|exists:categories,id',
            'title'        => 'sometimes|string',
            'description'  => 'nullable|string',
            'content'      => 'nullable|string',
            'author'       => 'nullable|string|max:255',
            'url'          => "sometimes|url|unique:articles,url,{$article->id}",
            'image_url'    => 'nullable|url',
            'published_at' => 'nullable|date',
        ]);

        $article->update($data);

        return $article;
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return response()->noContent();
    }
}