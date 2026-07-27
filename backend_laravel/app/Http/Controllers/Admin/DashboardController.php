<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ModuleEducatif;
use App\Models\Conseil;
use App\Models\Quiz;
use App\Models\Score;
use App\Models\Progression;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalModules = ModuleEducatif::count();
        $totalConseils = Conseil::count();
        $totalQuizzes = Quiz::count();
        $totalScores = Score::count();
        $totalProgressions = Progression::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalModules',
            'totalConseils',
            'totalQuizzes',
            'totalScores',
            'totalProgressions'
        ));
    }
}
