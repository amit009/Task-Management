<div>
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-xl font-bold mb-4">Tasks for: {{ $project->name }}</h1>

        <form wire:submit.prevent="addTask" class="space-y-2 mb-4">
            <input wire:model="title" type="text" class="border w-full p-2 rounded @error('title') border-red-600 @enderror" placeholder="Task title">
            <p>@error('title')<small class="error">{{$message}}</small>@enderror</p>
            <input wire:model="description" type="text" class="border w-full p-2 rounded" placeholder="Description">
            <input wire:model="due_date" type="date" class="border w-full p-2 rounded">
            <button class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">Add Task</button>
        </form>

        @foreach($tasks as $task)
            <div class="flex justify-between items-center bg-white p-4 shadow rounded mb-2">
                <div>
                    <p class="{{ $task->status === 'completed' ? 'line-through text-gray-500' : '' }}">{{ $task->title }}</p>
                    <p class="text-sm text-gray-400">{{ $task->due_date }}</p>
                </div>
                <div class="flex gap-2">
                    <button wire:click="toggleStatus({{ $task->id }})"
                            class="text-sm {{ $task->status === 'completed' ? 'bg-green-600' : 'bg-gray-300' }} text-white px-2 py-1 rounded">
                        {{ ucfirst($task->status) }}
                    </button>
                    <button wire:click="deleteTask({{ $task->id }})" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Delete</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
