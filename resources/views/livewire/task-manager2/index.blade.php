<div class="p-6 bg-white shadow rounded">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Tasks </h2>
        <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add Task
        </a>
    </div>

    <div>
        <label for="">Filters:</label>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" id="search-input" placeholder="Search by title" class="border p-2 rounded w-full mb-4">
            <select id="search-status" class="border p-2 rounded w-full mb-4">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>     
            </div>
            <!-- <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button> -->
         
    </div> 
<div wire:key="tasks-table">
    <table class="min-w-full bg-white border border-gray-200 rounded shadow">
        <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
            <tr>
                <th class="px-4 py-2 border-b">Title</th>
                <th class="px-4 py-2 border-b">Project</th>
                <th class="px-4 py-2 border-b">Description</th>
                <th class="px-4 py-2 border-b">Status</th>
                <th class="px-4 py-2 border-b">Due Date</th>
                <th class="px-4 py-2 border-b">Actions</th>
            </tr>
        </thead>

        <tbody id="tasks-body" class="text-gray-700">
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
        </tbody>
    </table>

     
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#search-input').on('keyup', function () {
        let query = $(this).val();
        $.ajax({
            url: '{{ route('ajax.tasks') }}',
            data: { search: query },
            success: function (tasks) {
                let rows = '';
                if (tasks.length) {
                    tasks.forEach(task => {
                        rows += `<tr>
                            <td class="px-4 py-2">
                                <strong>${task.title}</strong>                        
                            </td>
                            <td class="px-4 py-2">
                                ${task.project.name}
                            </td>
                            <td class="px-4 py-2">
                                ${task.description}
                            </td>
                            <td class="px-4 py-2">
                            <button wire:click="toggleStatus2(${task.id})" class="text-sm ${task.status === 'completed' ? 'bg-green-600' : 'bg-gray-300'} text-white px-2 py-1 rounded cursor-pointer" onclick="Livewire.emit('toggleStatus2', ${task.id})">
                                ${task.status.charAt(0).toUpperCase() + task.status.slice(1)}
                            </button>
                            </td>                             
                            <td class="px-4 py-2">
                                ${task.due_date ? task.due_date : 'No due date'}
                            </td>
                            <td class="px-4 py-2">
                                <a href="/tasks/edit/${task.id}" class="bg-blue-500 text-white px-2 py-1 rounded text-sm">Edit</a>
                                <a href="#" onclick="Livewire.emit('deleteTask', ${task.id})" class="bg-red-500 text-white px-2 py-1 rounded text-sm cursor-pointer">Delete</a>
                            </td>
                        </tr>`;
                    });
                } else {
                    rows = `<tr><td colspan="3" class="text-center text-gray-500 py-2">No tasks found</td></tr>`;
                }
                $('#tasks-body').html(rows);
            }
        });
    });

    $('#search-status').on('change', function () {
        let query = $(this).val();
        $.ajax({
            url: '{{ route('ajax.tasks') }}',
            data: { search: query },
            success: function (tasks) {
                let rows = '';
                if (tasks.length) {
                    tasks.forEach(task => {
                        rows += `<tr>
                            <td class="px-4 py-2">
                                <strong>${task.title}</strong>                        
                            </td>
                            <td class="px-4 py-2">
                                ${task.project.name}
                            </td>
                            <td class="px-4 py-2">
                                ${task.description}
                            </td>
                            <td class="px-4 py-2">
                            <button wire:click="toggleStatus2(${task.id})" class="text-sm ${task.status === 'completed' ? 'bg-green-600' : 'bg-gray-300'} text-white px-2 py-1 rounded cursor-pointer" onclick="Livewire.emit('toggleStatus2', ${task.id})">
                                ${task.status.charAt(0).toUpperCase() + task.status.slice(1)}
                            </button>
                            </td>                             
                            <td class="px-4 py-2">
                                ${task.due_date ? task.due_date : 'No due date'}
                            </td>
                            <td class="px-4 py-2">
                                <a href="/tasks/edit/${task.id}" class="bg-blue-500 text-white px-2 py-1 rounded text-sm">Edit</a>
                                <a href="#" onclick="Livewire.emit('deleteTask', ${task.id})" class="bg-red-500 text-white px-2 py-1 rounded text-sm cursor-pointer">Delete</a>
                            </td>
                        </tr>`;
                    });
                } else {
                    rows = `<tr><td colspan="3" class="text-center text-gray-500 py-2">No tasks found</td></tr>`;
                }
                $('#tasks-body').html(rows);
            }
        });
    });
</script>