<?php

namespace App\Livewire\TaskManager2;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;

class Create extends Component
{
    public $projects;
    public $project_id, $title, $description, $due_date;

    public function mount()
    {         
        $this->projects = Project::all();
    }

    public function save()
    {
        $this->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required',
            'description' => 'nullable',
            'due_date' => 'nullable|date'
        ]);

        Task::create([
            'project_id' => $this->project_id,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'status' => 'pending'
        ]);

        session()->flash('success', 'Task created successfully.');
        return redirect()->route('tasks.index', $this->project_id);
    }
    
    public function render()
    {
        $projects = Project::all();         
        return view('livewire.task-manager2.create', compact('projects'));
    }
}
