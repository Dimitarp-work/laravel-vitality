<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\XPLog;

class DashboardController extends Controller
{
    public function index()
    {
        $logs = XPLog::with('user')->latest()->limit(10)->get();
        return view('admin.dashboard', compact('logs'));
    }
}
