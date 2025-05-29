<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;

class TaskManager extends Component
{
    public $project;
    public $tasks, $title, $description, $due_date;
    public $taskId, $isEditing = false;

    public function mount(Project $project) {
        $this->project = $project;
        $this->loadTasks();
    }

    public function loadTasks() {
        $this->tasks = $this->project->tasks()->latest()->get();
    }

    public function addTask() {
        $this->validate([
            'title' => 'required',
            'description' => 'nullable',
            'due_date' => 'nullable|date'
        ]);

        Task::create([
            'project_id' => $this->project->id,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'status' => 'pending'
        ]);

        $this->reset(['title', 'description', 'due_date']);
        $this->loadTasks();
    }

    public function toggleStatus($id) {
        $task = Task::find($id);
        $task->status = $task->status === 'pending' ? 'completed' : 'pending';
        $task->save();

        $this->loadTasks();
    }

    public function deleteTask($id) {
        Task::find($id)->delete();
        $this->loadTasks();
    }

    public function editTask($id) {
        $task = Task::findOrFail($id);
        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->due_date = $task->due_date?->format('Y-m-d');
        $this->isEditing = true;
    }

    public function updateTask() {
        $this->validate([
            'title' => 'required',
            'description' => 'nullable',
            'due_date' => 'nullable|date'
        ]);

        $task = Task::findOrFail($this->taskId);
        $task->update([
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
        ]);

        $this->resetForm();
        $this->loadTasks();
    }

    public function cancelEdit() {
        $this->resetForm();
    }
    
    public function render()
    {
        return view('livewire.task-manager');
    }
}
