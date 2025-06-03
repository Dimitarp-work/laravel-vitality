<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Tag;
use Carbon\Carbon;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $tags = Tag::all();

        $query = Article::with('tags');

        if ($request->has('tag') && filled($request->tag)) {
            $query->whereHas('tags', fn($q) => $q->where('tags.id', $request->tag));
        }

        $articles = $query->latest()->paginate(10);

        $trendingArticles = collect();

        $allTrendingArticles = collect();

        if (Article::where('views', '>', 0)->exists()) {
            $trendingArticles = Article::where('created_at', '>=', Carbon::now()->subDays(7))
                ->where('views', '>', 0)
                ->orderByRaw('views DESC, created_at DESC')
                ->take(3)
                ->get();
        }

        if (Article::where('views', '>', 0)->exists()) {
            $allTrendingArticles = Article::where('views', '>', '0')
            ->orderByRaw('views DESC, created_at DESC')
            ->take(3)
                ->get();
        }

        return view('articles.index', compact('articles', 'tags', 'trendingArticles', 'allTrendingArticles'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('articles.create', compact('tags'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:4096',
            'image' => 'nullable|image|max:4096',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $article = new Article();
        $article->title = $validated['title'];
        $article->content = $validated['content'];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $article->image = $imagePath;
        }

        $article->save();
        $article->tags()->sync($request->input('tags', []));


        return redirect()->route('articles.index')->with('success', 'Article added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->increment('views');
        return view('articles.show', compact('article'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $tags = Tag::all();
        return view('articles.edit', compact('article', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:4096',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $article->update($validatedData);
        $article->tags()->sync($request->input('tags', []));
        return redirect()->route('articles.index')->with('success', 'Article updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::delete('public/' . $article->image);
        }
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully');
    }
}
