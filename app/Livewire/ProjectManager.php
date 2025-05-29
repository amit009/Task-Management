<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ActivityLogger;
use Livewire\WithPagination;

/**
 * Livewire component for managing projects.
 * Allows creating projects, viewing project details, and logging activities.
 */
class ProjectManager extends Component
{
    public $name, $description;
    public $projects;
    public $isEditing = false;
    protected $paginationTheme = 'tailwind';

    public function mount() {
        $this->loadProjects();
    }

    public function loadProjects() {
        $this->projects = Project::withCount([
            'tasks',
            'tasks as completed_tasks_count' => fn($q) => $q->where('status', 'completed')
        ])->get()->sortByDesc('created_at');
    }

    public function createProject() {
        $this->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $project = Project::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        //return redirect()->back()->with('success', 'Successs! Project created successfully.');

        $this->reset(['name', 'description']);
        $this->loadProjects();

        ActivityLogger::log('Create Project', "Created project '{$project->name}'");
    }

    public function delete($id) {
        Project::findOrFail($id)->delete();
        $this->loadProjects();
    }
    
    public function render() {
        //$this->projects = Project::latest()->get();
        return view('livewire.project-manager');
    }
}
