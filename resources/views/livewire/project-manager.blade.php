<div>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Projects</h1>

        <form wire:submit.prevent="createProject" class="flex space-x-2 mb-6">
            <input wire:model="name" type="text" placeholder="Project Name" class="border p-2 rounded w-1/3 @error('name') border-red-600 @enderror">
            <input wire:model="description" type="text" placeholder="Description" class="border p-2 rounded w-1/2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">Add</button>
        </form>

        @foreach($projects as $project)
            @php
                $taskCount = $project->tasks_count;
                $completed = $project->completed_tasks_count;
                $percent = $taskCount ? round(($completed / $taskCount) * 100) : 0;
            @endphp

            <div class="bg-white shadow rounded p-4 mb-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">{{ $project->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $project->description }}</p>
                    </div>
                    <div class="button-actions flex space-x-4">
                        <a wire:click="delete({{ $project->id }})" class="text-red-500 hover:underline cursor-pointer">Delete</a>
                        <a href="{{ route('project.tasks', $project) }}" class="text-blue-500 hover:underline">Manage Tasks</a>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
                        <div class="bg-green-500 h-2" style="width: {{ $percent }}%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ $percent }}% completed ({{ $completed }}/{{ $taskCount }})</p>
                </div>
            </div>
        @endforeach
    </div>

</div>
