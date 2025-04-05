<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $tasks = Task::where('user_id', Auth::id())->orderBy('priority', 'ASC')->get();
        $projects = Project::where('user_id', Auth::id())->get();

        return view('home', [
            'tasks' => $tasks,
            'projects' => $projects
        ]);
    }
}
