<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\XPLog;
use App\Models\Article;
use App\Models\User;    // Make sure User model is imported
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch total counts
        $totalArticles = Article::count();
        $totalUsers = User::count(); // This is total registered users, not necessarily 'active' in a session sense.

        // --- Article Growth Calculations ---
        // Weekly
        $startOfLastArticleWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastArticleWeek = Carbon::now()->subWeek()->endOfWeek();
        $startOfThisArticleWeek = Carbon::now()->startOfWeek();
        $endOfThisArticleWeek = Carbon::now()->endOfWeek();

        $articlesLastWeek = Article::whereBetween('created_at', [$startOfLastArticleWeek, $endOfLastArticleWeek])->count();
        $articlesThisWeek = Article::whereBetween('created_at', [$startOfThisArticleWeek, $endOfThisArticleWeek])->count();

        $articlesWeeklyGrowth = $this->calculateGrowthPercentage($articlesThisWeek, $articlesLastWeek);

        // Monthly
        $startOfLastArticleMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastArticleMonth = Carbon::now()->subMonth()->endOfMonth();
        $startOfThisArticleMonth = Carbon::now()->startOfMonth();
        $endOfThisArticleMonth = Carbon::now()->endOfMonth();

        $articlesLastMonth = Article::whereBetween('created_at', [$startOfLastArticleMonth, $endOfLastArticleMonth])->count();
        $articlesThisMonth = Article::whereBetween('created_at', [$startOfThisArticleMonth, $endOfThisArticleMonth])->count();

        $articlesMonthlyGrowth = $this->calculateGrowthPercentage($articlesThisMonth, $articlesLastMonth);


        // --- Active Users Growth Calculations ---
        // For "Active Users", if you mean newly registered users:
        // Adjust the `whereBetween` to look at 'created_at' on the User model.
        // If "Active Users" means users who logged in or performed an action:
        // You'll need a mechanism to track user activity (e.g., 'last_login_at' timestamp on User model, or a dedicated activity log).
        // For this example, I'll assume "Active Users" refers to *newly registered users* for simplicity,
        // using their `created_at` timestamp. If your definition of "active" is different,
        // you'll need to adjust the queries below accordingly.

        // Weekly New Users
        $startOfLastUserWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastUserWeek = Carbon::now()->subWeek()->endOfWeek();
        $startOfThisUserWeek = Carbon::now()->startOfWeek();
        $endOfThisUserWeek = Carbon::now()->endOfWeek();

        $usersLastWeek = User::whereBetween('created_at', [$startOfLastUserWeek, $endOfLastUserWeek])->count();
        $usersThisWeek = User::whereBetween('created_at', [$startOfThisUserWeek, $endOfThisUserWeek])->count();

        $usersWeeklyGrowth = $this->calculateGrowthPercentage($usersThisWeek, $usersLastWeek);

        // Monthly New Users
        $startOfLastUserMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastUserMonth = Carbon::now()->subMonth()->endOfMonth();
        $startOfThisUserMonth = Carbon::now()->startOfMonth();
        $endOfThisUserMonth = Carbon::now()->endOfMonth();

        $usersLastMonth = User::whereBetween('created_at', [$startOfLastUserMonth, $endOfLastUserMonth])->count();
        $usersThisMonth = User::whereBetween('created_at', [$startOfThisUserMonth, $endOfThisUserMonth])->count();

        $usersMonthlyGrowth = $this->calculateGrowthPercentage($usersThisMonth, $usersLastMonth);


        // Fetch recent articles (adjust limit as needed)
        $recentArticles = Article::latest()->take(5)->get();

        // Fetch XP & Credit logs
        $logs = XPLog::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact(
            'totalArticles',
            'totalUsers',
            'articlesWeeklyGrowth',
            'articlesMonthlyGrowth',
            'usersWeeklyGrowth', // New variable
            'usersMonthlyGrowth', // New variable
            'recentArticles',
            'logs'
        ));
    }

    /**
     * Calculates the percentage growth.
     * Returns null if previous count is 0 and current count is > 0 (to indicate 'New' growth).
     * Returns 0 if both are 0.
     * Returns percentage otherwise.
     */
    private function calculateGrowthPercentage($current, $previous)
    {
        if ($previous == 0) {
            return $current == 0 ? 0 : null; // Use null to signify "New" or infinite growth
        }
        return (($current - $previous) / $previous) * 100;
    }
}
