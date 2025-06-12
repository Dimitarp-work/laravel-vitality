<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Tag;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['index', 'show']);
    }

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

    public function create()
    {
        $tags = Tag::all();
        return view('articles.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:4096',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:8096',
            'tags' => 'required|array|min:1',
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

    public function show(Article $article)
    {
        $article->increment('views');
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        // Removed passing $tags and $articleTags since they are no longer needed in the view
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:8096',
        ]);

        $article->title = $validatedData['title'];
        $article->content = $validatedData['content'];

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
            $article->image = $imagePath;
        }

        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article updated successfully');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::delete('public/' . $article->image);
        }
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully');
    }
}
