<div class="max-w-4xl mx-auto py-6">
    <h1 class="text-3xl font-bold mb-6">Projects</h1>

    <a href="{{ route('projects.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">+ New Project</a>

    @foreach($projects as $project)
        @php
            $taskCount = $project->tasks_count;
            $completedCount = $project->completed_tasks_count;
            $percent = $taskCount > 0 ? round(($completedCount / $taskCount) * 100) : 0;
        @endphp

        <div class="bg-white shadow p-4 mb-4 rounded">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">{{ $project->name }}</h2>
                <span class="text-sm text-gray-500">{{ $taskCount }} Tasks</span>
            </div>
            <p class="text-gray-700">{{ $project->description }}</p>

            <div class="mt-2">
                <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
                    <div class="bg-green-500 h-3" style="width: {{ $percent }}%"></div>
                </div>
                <p class="text-sm text-gray-600 mt-1">{{ $percent }}% Completed</p>
            </div>

            <a href="{{ route('projects.show', $project) }}" class="mt-2 inline-block text-blue-600 hover:underline">View Tasks</a>
        </div>
    @endforeach
</div>
