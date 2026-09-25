@extends('layouts.app')
@section('title', 'Add Task')
@section('content')
    <div class="page-heading"><div><h1>Add Task</h1><p>Give your task a name and a due date.</p></div></div>
    <form class="panel task-form" action="{{ route('tasks.store') }}" method="POST">
        @include('tasks._form', ['submitLabel' => 'Add Task'])
    </form>
@endsection
