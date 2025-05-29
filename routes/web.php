<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\ProjectManager;
use App\Livewire\TaskManager;

use App\Livewire\TaskManager2\Index;
use App\Livewire\TaskManager2\Create;
use App\Livewire\TaskManager2\Edit;

use App\Http\Controllers\TaskController;

/* Route::get('/', function () {
    return view('welcome');
})->name('home'); */

Route::middleware('guest')->group(function () {
    Volt::route('/', 'auth.login')
        ->name('home');
}); 

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');


    Route::get('/projects', ProjectManager::class)->name('projects');
    Route::get('/projects/{project}', TaskManager::class)->name('project.tasks');
    //Route::get('/tasks', TaskManager::class, 'listTasks')->name('tasks');


    Route::get('tasks', Index::class)->name('tasks.index');
    Route::get('tasks/create', Create::class)->name('tasks.create');
    Route::get('tasks/{task}/edit', Edit::class)->name('tasks.edit');
    Route::delete('tasks/{task}/delete', Edit::class)->name('tasks.delete');
   // Route::post('tasks/{task}/update', [Edit::class, 'update'])->name('tasks.update');
   // Route::post('tasks/create', [Create::class, 'save'])->name('tasks.store');

   Route::get('/ajax/tasks', [TaskController::class, 'search'])->name('ajax.tasks');
});

require __DIR__.'/auth.php';
