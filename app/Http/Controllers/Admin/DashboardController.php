<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\XPLog;
use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalArticles = Article::count();
        $totalUsers = User::count();

        $startOfLastArticleWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastArticleWeek = Carbon::now()->subWeek()->endOfWeek();
        $startOfThisArticleWeek = Carbon::now()->startOfWeek();
        $endOfThisArticleWeek = Carbon::now()->endOfWeek();

        $articlesLastWeek = Article::whereBetween('created_at', [$startOfLastArticleWeek, $endOfLastArticleWeek])->count();
        $articlesThisWeek = Article::whereBetween('created_at', [$startOfThisArticleWeek, $endOfThisArticleWeek])->count();
        $articlesWeeklyGrowth = $this->calculateGrowthPercentage($articlesThisWeek, $articlesLastWeek);

        $startOfLastArticleMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastArticleMonth = Carbon::now()->subMonth()->endOfMonth();
        $startOfThisArticleMonth = Carbon::now()->startOfMonth();
        $endOfThisArticleMonth = Carbon::now()->endOfMonth();

        $articlesLastMonth = Article::whereBetween('created_at', [$startOfLastArticleMonth, $endOfLastArticleMonth])->count();
        $articlesThisMonth = Article::whereBetween('created_at', [$startOfThisArticleMonth, $endOfThisArticleMonth])->count();
        $articlesMonthlyGrowth = $this->calculateGrowthPercentage($articlesThisMonth, $articlesLastMonth);

        $startOfLastUserWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastUserWeek = Carbon::now()->subWeek()->endOfWeek();
        $startOfThisUserWeek = Carbon::now()->startOfWeek();
        $endOfThisUserWeek = Carbon::now()->endOfWeek();

        $usersLastWeek = User::whereBetween('created_at', [$startOfLastUserWeek, $endOfLastUserWeek])->count();
        $usersThisWeek = User::whereBetween('created_at', [$startOfThisUserWeek, $endOfThisUserWeek])->count();
        $usersWeeklyGrowth = $this->calculateGrowthPercentage($usersThisWeek, $usersLastWeek);

        $startOfLastUserMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastUserMonth = Carbon::now()->subMonth()->endOfMonth();
        $startOfThisUserMonth = Carbon::now()->startOfMonth();
        $endOfThisUserMonth = Carbon::now()->endOfMonth();

        $usersLastMonth = User::whereBetween('created_at', [$startOfLastUserMonth, $endOfLastUserMonth])->count();
        $usersThisMonth = User::whereBetween('created_at', [$startOfThisUserMonth, $endOfThisUserMonth])->count();
        $usersMonthlyGrowth = $this->calculateGrowthPercentage($usersThisMonth, $usersLastMonth);

        $totalViews = Article::sum('views');

        $viewsLastWeek = Article::whereBetween('created_at', [$startOfLastArticleWeek, $endOfLastArticleWeek])->sum('views');
        $viewsThisWeek = Article::whereBetween('created_at', [$startOfThisArticleWeek, $endOfThisArticleWeek])->sum('views');
        $viewsWeeklyGrowth = $this->calculateGrowthPercentage($viewsThisWeek, $viewsLastWeek);

        $viewsLastMonth = Article::whereBetween('created_at', [$startOfLastArticleMonth, $endOfLastArticleMonth])->sum('views');
        $viewsThisMonth = Article::whereBetween('created_at', [$startOfThisArticleMonth, $endOfThisArticleMonth])->sum('views');
        $viewsMonthlyGrowth = $this->calculateGrowthPercentage($viewsThisMonth, $viewsLastMonth);

        $totalEngagementRate = ($totalUsers > 0) ? ($totalViews / $totalUsers) * 100 : 0;

        $engagementRateThisWeek = ($usersThisWeek > 0) ? ($viewsThisWeek / $usersThisWeek) : 0;
        $engagementRateLastWeek = ($usersLastWeek > 0) ? ($viewsLastWeek / $usersLastWeek) : 0;
        $engagementRateWeeklyGrowth = $this->calculateGrowthPercentage($engagementRateThisWeek, $engagementRateLastWeek);

        $engagementRateThisMonth = ($usersThisMonth > 0) ? ($viewsThisMonth / $usersThisMonth) : 0;
        $engagementRateLastMonth = ($usersLastMonth > 0) ? ($viewsLastMonth / $usersLastMonth) : 0;
        $engagementRateMonthlyGrowth = $this->calculateGrowthPercentage($engagementRateThisMonth, $engagementRateLastMonth);


        $query = Article::latest();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $recentArticles = $query->paginate(6);

        $logs = XPLog::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact(
            'totalArticles',
            'totalUsers',
            'articlesWeeklyGrowth',
            'articlesMonthlyGrowth',
            'usersWeeklyGrowth',
            'usersMonthlyGrowth',
            'totalViews',
            'viewsWeeklyGrowth',
            'viewsMonthlyGrowth',
            'totalEngagementRate',
            'engagementRateWeeklyGrowth',
            'engagementRateMonthlyGrowth',
            'recentArticles',
            'logs',
            'search'
        ));
    }

    private function calculateGrowthPercentage($current, $previous)
    {
        if ($previous == 0) {
            return $current == 0 ? 0 : null;
        }
        return (($current - $previous) / $previous) * 100;
    }
}
