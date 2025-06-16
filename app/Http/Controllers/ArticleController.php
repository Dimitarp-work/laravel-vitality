<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use App\Models\ViewLog;

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

        if (isset($validated['tags'])) {
            $article->tags()->sync($validated['tags']);
        } else {
            $article->tags()->detach();
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Article "' . $article->title . '" was created.',
            'loggable_type' => Article::class,
            'loggable_id' => $article->id,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully!');
    }

    public function show(Article $article)
    {
        $article->increment('views');

        ViewLog::create([
            'article_id' => $article->id,
        ]);

        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $tags = Tag::all();
        $articleTags = $article->tags->pluck('id')->toArray();
        return view('articles.edit', compact('article', 'tags', 'articleTags'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:4096',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:8096',
            'clear_image' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $originalTitle = $article->title;

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
            $article->image = $imagePath;
        } elseif (isset($validated['clear_image']) && $validated['clear_image']) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
                $article->image = null;
            }
        }

        $article->title = $validated['title'];
        $article->content = $validated['content'];
        $article->save();

        if (isset($validated['tags'])) {
            $article->tags()->sync($validated['tags']);
        } else {
            $article->tags()->detach();
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Article "' . $originalTitle . '" was updated.',
            'loggable_type' => Article::class,
            'loggable_id' => $article->id,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article)
    {
        $articleTitle = $article->title;
        $articleId = $article->id;

        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Article "' . $articleTitle . '" was deleted.',
            'loggable_type' => Article::class,
            'loggable_id' => $articleId,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully!');
    }

    public function manageArticles()
    {
        $articles = Article::latest()->paginate(10);
        return view('articles.manage', compact('articles'));
    }
}
