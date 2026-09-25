@extends('layouts.app')
@section('title', 'Edit Task')
@section('content')
    <div class="page-heading"><div><h1>Edit Task</h1><p>Update the details below, then save your changes.</p></div></div>
    <form class="panel task-form" action="{{ route('tasks.update', $task) }}" method="POST">
        @method('PUT')
        @include('tasks._form', ['submitLabel' => 'Save Changes'])
    </form>
@endsection
