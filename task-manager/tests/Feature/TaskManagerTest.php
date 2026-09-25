<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TaskManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_task_list_and_add_form_load(): void
    {
        $this->get('/')->assertOk()->assertSee('No tasks yet');
        $this->get('/tasks')->assertOk()->assertSee('Add Task');
        $this->get('/tasks/create')->assertOk()->assertSee('name="_token"', false);
    }

    public function test_task_is_saved_and_displayed(): void
    {
        $data = Task::factory()->raw(['task_name' => 'Prepare school demonstration']);
        $this->post('/tasks', $data)->assertRedirect(route('tasks.index'))->assertSessionHas('success');
        $this->assertDatabaseHas('tasks', [...$data, 'due_date' => '2026-10-01 00:00:00']);
        $this->get('/tasks')->assertOk()->assertSee('Prepare school demonstration')->assertSee('Pending');
    }

    public function test_task_can_be_edited(): void
    {
        $task = Task::factory()->create();
        $this->get('/tasks/'.$task->id.'/edit')->assertOk()->assertSee($task->task_name);
        $data = ['task_name' => 'Revised task', 'description' => 'Updated details', 'status' => 'Completed', 'due_date' => '2026-11-15'];
        $this->put('/tasks/'.$task->id, $data)->assertRedirect(route('tasks.index'))->assertSessionHas('success');
        $this->assertDatabaseHas('tasks', ['id' => $task->id, ...$data, 'due_date' => '2026-11-15 00:00:00']);
    }

    public function test_status_changes_both_ways_without_changing_other_fields(): void
    {
        $task = Task::factory()->create();
        foreach (['Completed', 'Pending'] as $status) {
            $this->patch('/tasks/'.$task->id.'/status', ['status' => $status, 'task_name' => 'Unwanted rename'])
                ->assertRedirect(route('tasks.index'))->assertSessionHas('success');
            $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => $status, 'task_name' => $task->task_name]);
        }
    }

    public function test_task_can_be_deleted(): void
    {
        $task = Task::factory()->create();
        $this->delete('/tasks/'.$task->id)->assertRedirect(route('tasks.index'))->assertSessionHas('success');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $this->get('/tasks')->assertSee('No tasks yet');
    }

    #[DataProvider('invalidInputs')]
    public function test_invalid_input_is_rejected_on_create_and_update(string $field, mixed $value): void
    {
        $data = Task::factory()->raw([$field => $value]);
        $this->from('/tasks/create')->post('/tasks', $data)
            ->assertRedirect('/tasks/create')->assertSessionHasErrors($field);
        $this->assertDatabaseCount('tasks', 0);

        $task = Task::factory()->create();
        $original = $task->getAttributes();
        $this->put('/tasks/'.$task->id, $data)->assertSessionHasErrors($field);
        $this->assertEquals($original, $task->fresh()->getAttributes());
    }

    public static function invalidInputs(): array
    {
        return [
            'missing name' => ['task_name', ''],
            'whitespace name' => ['task_name', '   '],
            'long name' => ['task_name', str_repeat('a', 256)],
            'long description' => ['description', str_repeat('a', 5001)],
            'missing status' => ['status', ''],
            'invalid status' => ['status', 'In Progress'],
            'missing date' => ['due_date', ''],
            'invalid date' => ['due_date', '2026-02-30'],
            'wrong date format' => ['due_date', '10/01/2026'],
        ];
    }

    public function test_invalid_status_update_is_rejected(): void
    {
        $task = Task::factory()->create();
        $this->patch('/tasks/'.$task->id.'/status', ['status' => 'Unknown'])->assertSessionHasErrors('status');
        $this->patch('/tasks/'.$task->id.'/status', [])->assertSessionHasErrors('status');
        $this->assertSame('Pending', $task->fresh()->status);
    }

    public function test_description_is_optional_and_past_dates_are_allowed(): void
    {
        $data = Task::factory()->raw(['description' => '', 'due_date' => '2020-01-01']);
        $this->post('/tasks', $data)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', ['description' => null, 'due_date' => '2020-01-01 00:00:00']);
    }

    public function test_task_content_is_escaped(): void
    {
        Task::factory()->create(['task_name' => '<script>alert(1)</script>', 'description' => '<img src=x onerror=alert(1)>']);
        $this->get('/tasks')->assertOk()->assertSee('&lt;script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('<img src=x onerror=alert(1)>', false);
    }

    public function test_missing_tasks_return_404(): void
    {
        $this->get('/tasks/999/edit')->assertNotFound();
        $this->put('/tasks/999', Task::factory()->raw())->assertNotFound();
        $this->patch('/tasks/999/status', ['status' => 'Completed'])->assertNotFound();
        $this->delete('/tasks/999')->assertNotFound();
    }

    public function test_get_requests_cannot_delete_or_change_status(): void
    {
        $task = Task::factory()->create();
        $this->get('/tasks/'.$task->id)->assertMethodNotAllowed();
        $this->get('/tasks/'.$task->id.'/status')->assertMethodNotAllowed();
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'Pending']);
    }
}
