<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task · Personal Task Manager</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #0b2b45;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #ddd;
            padding: 18px 40px;
            font-size: 18px;
            font-weight: bold;
        }

        .container {
            max-width: 920px;
            margin: 35px auto;
            padding: 0 20px;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #607084;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border: 1px solid #d5dde5;
            border-radius: 10px;
            padding: 24px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 13px;
            border: 1px solid #b9c7d5;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            min-height: 140px;
            resize: vertical;
        }

        .field {
            margin-bottom: 24px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .required {
            font-weight: normal;
            color: #607084;
            font-size: 13px;
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        .save {
            background: #126b57;
            color: white;
            border: none;
            border-radius: 7px;
            padding: 12px 18px;
            font-weight: bold;
            cursor: pointer;
        }

        .cancel {
            border: 1px solid #c5d0da;
            color: #0b2b45;
            text-decoration: none;
            border-radius: 7px;
            padding: 11px 18px;
            font-weight: bold;
            background: white;
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 7px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="navbar">
    Personal Task Manager
</div>

<div class="container">

    <h1>Add Task</h1>
    <p class="subtitle">
        Give your task a name and a due date.
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

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="field">
                <label>
                    Task name
                    <span class="required">(required)</span>
                </label>

                <input
                    type="text"
                    name="task_name"
                    value="{{ old('task_name') }}"
                    required>
            </div>

            <div class="field">
                <label>
                    Description
                    <span class="required">(optional)</span>
                </label>

                <textarea name="description">{{ old('description') }}</textarea>
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
                            {{ old('status', 'Pending') === 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option
                            value="Completed"
                            {{ old('status') === 'Completed' ? 'selected' : '' }}>
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
                        value="{{ old('due_date') }}"
                        required>
                </div>

            </div>

            <div class="buttons">

                <button type="submit" class="save">
                    Add Task
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
