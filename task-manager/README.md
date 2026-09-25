# Personal Task Manager

A simple Laravel school project for creating and managing personal tasks. This practice repository is named **gwapo-proctor**; the application itself is Personal Task Manager. Laravel lives directly in the repository root.

| Item | Value |
| --- | --- |
| Project Code | WST21-PM-2026-SF |
| Student Name | [LEAVE PLACEHOLDER FOR ME TO FILL IN] |
| Course & Year | [LEAVE PLACEHOLDER FOR ME TO FILL IN] |
| Database Used | SQLite |

## Features

- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status between Pending and Completed

Task names and due dates are required. Descriptions are optional. Names are limited to 255 characters, descriptions to 5,000 characters, and status must be Pending or Completed. Past due dates are allowed. Laravel validates all changes on the server; forms use CSRF protection and Blade escapes displayed task text.

## Requirements

- PHP 8.5 recommended (the committed dependency lock requires PHP 8.4.1 or newer).
- Composer 2.
- PHP extensions: PDO, pdo_sqlite, sqlite3, mbstring, fileinfo, openssl, tokenizer, ctype, XML/DOM, session, filter and iconv. Enable curl and zip for dependency installation.
- Git for version control.

No MySQL, XAMPP, Node.js or npm build is needed for these pages. The original Laravel frontend scaffold remains available, but the task pages use `public/css/tasks.css` directly.

## First-time setup and run

Open a terminal in the repository root, where `artisan` and `composer.json` are located:

```bash
composer run setup
php artisan serve --host=0.0.0.0 --port=8000
```

The setup command installs the locked dependencies, copies `.env.example` to `.env` when needed, creates `database/database.sqlite` when needed, generates a missing application key and runs migrations. It preserves an existing key and database. Subsequent starts need only the `php artisan serve` command.

Local URL: **http://localhost:8000**

In **GitHub Codespaces**, open the **Ports** panel, find port **8000**, then click **Open in Browser**. The URL normally looks like:

```text
https://YOUR-CODESPACE-NAME-8000.app.github.dev
```

Use the actual forwarded URL from the Ports panel. Keep the port private: this assignment intentionally has no login or multi-user accounts. If PHP or Composer is missing or too old, use a PHP 8.5 development environment before setup.

## Database setup

The example environment sets `DB_CONNECTION=sqlite`. `DB_DATABASE` is intentionally unset so Laravel uses the portable default `database/database.sqlite` rather than a machine-specific absolute path. Sessions and cache use local files.

If dependencies are already installed, initialize the environment and database with:

```bash
php scripts/setup.php
php artisan migrate:status
```

The `tasks` migration creates `id`, `task_name`, `description`, `status`, `due_date`, and Laravel's `created_at` / `updated_at` timestamps. The starter migrations for users, cache and jobs are retained; this task manager does not require registration, queues or MySQL.

The database and `.env` are ignored by Git. A new clone creates its own empty SQLite file during setup. Do not commit `.env`, application keys, dependency folders, or your personal task data.

## Important routes

| Method | URL | Controller method | Purpose |
| --- | --- | --- | --- |
| GET | `/` or `/tasks` | `index` | View all saved tasks |
| GET | `/tasks/create` | `create` | Display Add Task form |
| POST | `/tasks` | `store` | Validate and save a new task |
| GET | `/tasks/{task}/edit` | `edit` | Display Edit Task form |
| PUT/PATCH | `/tasks/{task}` | `update` | Validate and save changes |
| DELETE | `/tasks/{task}` | `destroy` | Delete the selected task |
| PATCH | `/tasks/{task}/status` | `updateStatus` | Change Pending / Completed |

HTML forms send POST with Laravel's `@method('PUT')`, `@method('PATCH')` or `@method('DELETE')` when needed. Each modifying form contains `@csrf`. Route model binding finds the task by ID and returns 404 if it is missing.

## Laravel MVC flow

**Route → Controller → Model → Database → Blade**

1. **Route:** `routes/web.php` receives the browser request and sends it to the appropriate controller method.
2. **Controller:** `app/Http/Controllers/TaskController.php` handles application logic, validates input and communicates with the model.
3. **Model:** `app/Models/Task.php` represents Task data and communicates with the database using Eloquent. Its fillable list controls which fields may be assigned together, and its date cast makes due dates easy to format.
4. **Database:** SQLite stores the tasks in `database/database.sqlite`. The migration defines the table structure.
5. **Blade:** `resources/views/tasks/` displays task data and forms to the user. The controller supplies the data to these views.

For example, Add Task submits POST `/tasks`. The route calls `store`, the controller validates input, and `Task::create()` inserts a database row. The response redirects to `/tasks`; `index` loads the records and passes them to the list Blade view. Editing and deleting follow the same pattern and display a success message after redirecting.

## Tests and useful checks

```bash
php artisan test
php artisan route:list --except-vendor
php artisan migrate:status
composer validate
```

Feature tests use an isolated in-memory SQLite database, so they do not erase your saved tasks. Coverage includes the empty state, forms, create/list/edit/delete, both status changes, invalid and missing inputs, maximum lengths, missing records, escaped output and HTTP methods. The running app was also checked with actual browser forms. See `docs/DEMONSTRATION.md` for study notes and the verification report.

## Files to study first

1. `routes/web.php`
2. `app/Http/Controllers/TaskController.php`
3. `app/Models/Task.php`
4. `database/migrations/2026_09_25_000000_create_tasks_table.php`
5. `resources/views/tasks/index.blade.php`, `create.blade.php`, `edit.blade.php`, `_form.blade.php`
6. `tests/Feature/TaskManagerTest.php`

The original repository README is preserved in `docs/ORIGINAL-README.md`, and the original Laravel README is preserved in `docs/LARAVEL-README.md`.

## Commit when ready

After reviewing the changes and filling in your student information:

```bash
git status
git add -A
git diff --cached --stat
git commit -m "Build Personal Task Manager with SQLite"
git push
```

The relocation may appear as deletions under `task-manager/` plus new root files until staged; Git can detect the renames. Keep `.git` intact.
