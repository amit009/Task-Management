<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index() {
        $projects = Project::withCount([
            'tasks',
            'tasks as completed_tasks_count' => function ($query) {
                $query->where('status', 'completed');
            }
        ])->get();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project) {
        $tasks = $project->tasks()->latest()->get();
        return view('projects.show', compact('project', 'tasks'));
    }


}
