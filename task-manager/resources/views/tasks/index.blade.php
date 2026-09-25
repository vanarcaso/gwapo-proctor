<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Personal Task Manager</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #2f3640;
    color: #222;
}

        .navbar {
    background: #39424e;
    color: #f1f3f5;
    border-bottom: 1px solid #4b5563;
    padding: 18px 40px;
    font-size: 20px;
    font-weight: bold;
}

        .container {
            max-width: 1100px;
            margin: 45px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

     h1 {
    color: #f3f4f6;
}

.subtitle {
    color: #cbd5e1;
}

        .add-button {
            background: #2563eb;
            color: white;
            padding: 11px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .table-box {
    background: #39424e;
    border: 1px solid #4b5563;
    border-radius: 8px;
    overflow: hidden;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #414b57;
    color: #f1f3f5;
    padding: 16px;
    text-align: left;
    border-bottom: 1px solid #56606c;
}

td {
    background: #39424e;
    color: #f1f3f5;
    padding: 16px;
    border-bottom: 1px solid #4b5563;
}

        .empty {
            padding: 40px;
            text-align: center;
            color: #777;
        }

        form {
            margin: 0;
        }

        button,
        .edit-button {
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .status-button {
            background: #f59e0b;
            color: white;
        }

        .edit-button {
            background: #2563eb;
            color: white;
        }

        .delete-button {
            background: #dc2626;
            color: white;
        }
    </style>
</head>

<body>

<div class="navbar">
    Personal Task Manager
</div>

<div class="container">

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="header">

        <div>
            <h1>My Tasks</h1>

            <p class="subtitle">
                Keep track of what needs to get done.
            </p>
        </div>

        <a href="{{ route('tasks.create') }}"
           class="add-button">
            + Add Task
        </a>

    </div>

    <div class="table-box">

        @if($tasks->isEmpty())

            <div class="empty">
                No tasks yet.
            </div>

        @else

            <table>

                <thead>
                <tr>
                    <th>Task</th>
                    <th>Completed</th>
                    <th>Status Action</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>

                <tbody>

                @foreach($tasks as $task)

                    <tr>

                        {{-- TASK NAME --}}
                        <td>
                            {{ $task->task_name }}
                        </td>

                        {{-- COMPLETED YES / NO --}}
                        <td>
                            {{ $task->status === 'Completed' ? 'Yes' : 'No' }}
                        </td>

                        {{-- MARK COMPLETED / MARK PENDING --}}
                        <td>

                            <form
                                action="{{ route('tasks.status', $task) }}"
                                method="POST">

                                @csrf
                                @method('PATCH')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="{{ $task->status === 'Completed'
                                        ? 'Pending'
                                        : 'Completed' }}">

                                <button
                                    type="submit"
                                    class="status-button">

                                    {{ $task->status === 'Completed'
                                        ? 'Mark Pending'
                                        : 'Mark Completed' }}

                                </button>

                            </form>

                        </td>

                        {{-- EDIT --}}
                        <td>

                            <a
                                href="{{ route('tasks.edit', $task) }}"
                                class="edit-button">

                                Edit

                            </a>

                        </td>

                        {{-- DELETE --}}
                        <td>

                            <form
                                action="{{ route('tasks.destroy', $task) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="delete-button">

                                    Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        @endif

    </div>

</div>

</body>
</html>
