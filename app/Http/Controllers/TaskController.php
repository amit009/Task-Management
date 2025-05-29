<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Helpers\ActivityLogger;

class TaskController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('search');

        $tasks = Task::with('project')
            ->where('title', 'like', "%{$query}%")
            ->orWhere('status', $query)
            ->latest()->get();

        ActivityLogger::log('Task', "Search term: {$query}");        

        return response()->json($tasks);
    }
}
