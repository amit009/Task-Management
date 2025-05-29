<?php

namespace App\Livewire\TaskManager2;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Helpers\ActivityLogger;

class Index extends Component
{
    public $project;
    public $search = '';

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function toggleStatus2($id) {
        $task = Task::find($id);
        if (!$task) return;

        $task->status = $task->status === 'pending' ? 'completed' : 'pending';
        $task->save();
    }

    public function deleteTask($id) {
        Task::find($id)->delete();
    }    
    
    public function render()
    {
        
        $tasks = Task::with('project')->latest()->get();
        
        
        /* $tasks = Task::with('project')
        ->where('title', 'like', '%' . $this->search . '%')
        ->latest()
        ->get();  */   

         
        return view('livewire.task-manager2.index', compact('tasks'));
    }
}
