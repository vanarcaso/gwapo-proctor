<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'My Tasks') · Personal Task Manager</title>
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="{{ route('tasks.index') }}">Personal Task Manager</a>
            <span class="project-label">WST21-PM-2026-SF</span>
        </div>
    </header>
    <main class="container">
        @if (session('success'))
            <div class="notice success" role="status">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="notice error" role="alert">
                <strong>Please correct the following:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
