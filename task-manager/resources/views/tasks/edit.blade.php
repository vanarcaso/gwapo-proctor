<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Task · Personal Task Manager</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #2f3640;
            color: #f1f3f5;
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

        h1 {
            margin: 0 0 8px;
            font-size: 32px;
            color: #f1f3f5;
        }

        .subtitle {
            margin: 0 0 25px;
            color: #cbd5e1;
        }

        .card {
            background: #39424e;
            border: 1px solid #4b5563;
            border-radius: 8px;
            padding: 24px;
        }

        .field {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #f1f3f5;
        }

        .required {
            color: #aeb4bc;
            font-size: 13px;
            font-weight: normal;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #56606c;
            border-radius: 6px;
            background: #414b57;
            color: #f1f3f5;
            font-size: 15px;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #7c8a99;
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 5px;
        }

        .save {
            background: #0f766e;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 11px 18px;
            font-weight: bold;
            cursor: pointer;
        }

        .save:hover {
            background: #115e59;
        }

        .cancel {
            background: #4b5563;
            color: white;
            border: 1px solid #64748b;
            border-radius: 6px;
            padding: 10px 18px;
            text-decoration: none;
            font-weight: bold;
        }

        .cancel:hover {
            background: #56606c;
        }

        .error-box {
            background: #7f1d1d;
            color: #fee2e2;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        @media (max-width: 700px) {
            .row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="navbar">
    Personal Task Manager
</div>

<div class="container">

    <h1>Edit Task</h1>

    <p class="subtitle">
        Update your task information.
    </p>

    <div class="card">

        @if ($errors->any())
            <div class="error-box">
                <strong>Please fix the following:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.update', $task) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="field">
                <label>
                    Task name
                    <span class="required">(required)</span>
                </label>

                <input
                    type="text"
                    name="task_name"
                    value="{{ old('task_name', $task->task_name) }}"
                    required>
            </div>

            <div class="field">
                <label>
                    Description
                    <span class="required">(optional)</span>
                </label>

                <textarea name="description">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="row">

                <div class="field">
                    <label>
                        Status
                        <span class="required">(required)</span>
                    </label>

                    <select name="status" required>

                        <option
                            value="Pending"
                            {{ old('status', $task->status) === 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option
                            value="Completed"
                            {{ old('status', $task->status) === 'Completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                    </select>
                </div>

                <div class="field">
                    <label>
                        Due date
                        <span class="required">(required)</span>
                    </label>

                    <input
                        type="date"
                        name="due_date"
                        value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
                        required>
                </div>

            </div>

            <div class="buttons">

                <button type="submit" class="save">
                    Update Task
                </button>

                <a href="{{ route('tasks.index') }}" class="cancel">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>