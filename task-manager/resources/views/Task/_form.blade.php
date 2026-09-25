@csrf
<div class="field">
    <label for="task_name">Task name <span>(required)</span></label>
    <input id="task_name" name="task_name" type="text" value="{{ old('task_name', $task->task_name) }}" maxlength="255" required @error('task_name') aria-invalid="true" aria-describedby="task_name-error" @enderror>
    @error('task_name') <p class="field-error" id="task_name-error">{{ $message }}</p> @enderror
</div>
<div class="field">
    <label for="description">Description <span>(optional)</span></label>
    <textarea id="description" name="description" rows="5" maxlength="5000" @error('description') aria-invalid="true" aria-describedby="description-error" @enderror>{{ old('description', $task->description) }}</textarea>
    @error('description') <p class="field-error" id="description-error">{{ $message }}</p> @enderror
</div>
<div class="form-row">
    <div class="field">
        <label for="status">Status <span>(required)</span></label>
        <select id="status" name="status" required @error('status') aria-invalid="true" aria-describedby="status-error" @enderror>
            @foreach (\App\Models\Task::STATUSES as $status)
                <option value="{{ $status }}" @selected(old('status', $task->status) === $status)>{{ $status }}</option>
            @endforeach
        </select>
        @error('status') <p class="field-error" id="status-error">{{ $message }}</p> @enderror
    </div>
    <div class="field">
        <label for="due_date">Due date <span>(required)</span></label>
        <input id="due_date" name="due_date" type="date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}" required @error('due_date') aria-invalid="true" aria-describedby="due_date-error" @enderror>
        @error('due_date') <p class="field-error" id="due_date-error">{{ $message }}</p> @enderror
    </div>
</div>
<div class="actions form-actions">
    <button class="button" type="submit">{{ $submitLabel }}</button>
    <a class="button secondary" href="{{ route('tasks.index') }}">Cancel</a>
</div>
