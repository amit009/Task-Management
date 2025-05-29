@foreach($tasks as $index => $task)
    <tr class="border-b hover:bg-gray-50 text-sm" style="background-color: {{ $index % 2 === 0 ? '#c2d9ff' : '#c2ffef' }};">
        <td class="px-4 py-2">
            <strong>{{ $task->title }}</strong>                        
        </td>
        <td class="px-4 py-2">
            {{ $task->project->name }}
        </td>
        <td class="px-4 py-2">
            {{ $task->description }}
        </td>
        <td class="px-4 py-2">
            <button wire:click="toggleStatus2({{ $task->id }})"
                class="text-sm {{ $task->status === 'completed' ? 'bg-green-600' : 'bg-gray-300' }} text-white px-2 py-1 rounded cursor-pointer">
            {{ ucfirst($task->status) }}
        </button>
        </td>
        <td class="px-4 py-2">
            {{ $task->due_date ? $task->due_date : 'No due date' }}
        </td>
        <td class="px-4 py-2">
            <a href="{{ route('tasks.edit', [$task->id]) }}" class="bg-blue-500 text-white px-2 py-1 rounded text-sm">Edit</a>
            <a wire:click="deleteTask({{ $task->id }})" class="bg-red-500 text-white px-2 py-1 rounded text-sm cursor-pointer">Delete</a>
        </td>
    </tr>
@endforeach
@if($tasks->isEmpty())
    <tr>
        <td class="text-center text-gray-500">No tasks available.</td>
    </tr>
@endif