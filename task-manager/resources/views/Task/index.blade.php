@extends('layouts.app')
@section('title', 'My Tasks')
@section('content')
    <div class="page-heading">
        <div>
            <h1>My Tasks</h1>
            <p>Keep track of what needs to get done.</p>
        </div>
        <a class="button" href="{{ route('tasks.create') }}">+ Add Task</a>
    </div>
    @if ($tasks->isEmpty())
        <section class="panel empty-state">
            <h2>No tasks yet</h2>
            <p>Add your first task to get started.</p>
            <a class="button" href="{{ route('tasks.create') }}">Add Task</a>
        </section>
    @else
        <p class="task-count">{{ $tasks->count() }} {{ $tasks->count() === 1 ? 'task' : 'tasks' }} · {{ $tasks->where('status', 'Completed')->count() }} completed</p>
        <div class="task-list">
            @foreach ($tasks as $task)
                <article class="panel task-card">
                    <div class="task-top">
                        <h2>{{ $task->task_name }}</h2>
                        <span class="badge {{ $task->status === 'Completed' ? 'completed' : 'pending' }}">{{ $task->status }}</span>
                    </div>
                    @if ($task->description)
                        <p class="description">{{ $task->description }}</p>
                    @endif
                    <p class="due-date">Due <time datetime="{{ $task->due_date->format('Y-m-d') }}">{{ $task->due_date->format('M j, Y') }}</time></p>
                    <div class="actions">
                        <form action="{{ route('tasks.status', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $task->status === 'Pending' ? 'Completed' : 'Pending' }}">
                            <button class="button secondary" type="submit">{{ $task->status === 'Pending' ? 'Mark Completed' : 'Mark Pending' }}</button>
                        </form>
                        <a class="button secondary" href="{{ route('tasks.edit', $task) }}">Edit</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="button danger" type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
