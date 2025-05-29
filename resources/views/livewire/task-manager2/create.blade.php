<div class="p-6 bg-white shadow rounded max-w-2xl mx-auto">
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-2xl font-semibold mb-4">Add New Task</h2>
    <form wire:submit.prevent="save">
        <input type="text" wire:model.defer="title" placeholder="Title" class="border p-1 mb-2 w-full">
        <textarea wire:model.defer="description" placeholder="Description" class="border p-1 mb-2 w-full"></textarea>
        <select wire:model.defer="project_id" class="border p-2 mb-2 w-full rounded">
            <option value="">Select Project</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
        <input type="date" wire:model.defer="due_date" class="border p-1 mb-2 w-full">
        <button type="submit" class="bg-green-500 text-white px-4 py-2">Create</button>
    </form>
</div>
