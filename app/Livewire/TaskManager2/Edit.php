<?php

namespace App\Livewire\TaskManager2;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;

class Edit extends Component
{
    public $projects = [];
    public $task;
    public $project_id, $title, $description, $due_date;

    public function mount(Project $project, Task $task)
    {
        $this->projects = Project::all();
        $this->task = $task;

        $this->project_id = $task->project_id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->due_date = $task->due_date??null;
    }

    public function update()
    {
        $this->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required',
            'description' => 'nullable',
            'due_date' => 'nullable|date'
        ]);

        $this->task->update([
            'project_id' => $this->project_id,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date
        ]);

        session()->flash('success', 'Task created successfully.');
        return redirect()->route('tasks.index', $this->project_id);
    }

    public function render()
    {
        $projects = Project::all();
        return view('livewire.task-manager2.edit', compact('projects'));
    }
}
