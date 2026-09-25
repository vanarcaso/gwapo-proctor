<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        return view('tasks.index', ['tasks' => Task::orderByDesc('id')->get()]);
    }

    public function create(): View
    {
        return view('tasks.create', ['task' => new Task(['status' => 'Pending'])]);
    }

    public function store(Request $request): RedirectResponse
    {
        Task::create($this->validatedTask($request));

        return to_route('tasks.index')->with('success', 'Task added successfully.');
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', ['task' => $task]);
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $task->update($this->validatedTask($request));

        return to_route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return to_route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Task::STATUSES)],
        ]);
        $task->update($validated);

        return to_route('tasks.index')->with('success', 'Task status updated successfully.');
    }

    private function validatedTask(Request $request): array
    {
        return $request->validate([
            'task_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', Rule::in(Task::STATUSES)],
            'due_date' => ['required', 'date_format:Y-m-d'],
        ]);
    }
}