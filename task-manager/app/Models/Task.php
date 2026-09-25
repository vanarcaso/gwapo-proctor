<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['task_name', 'description', 'status', 'due_date'])]
class Task extends Model
{
    use HasFactory;

    public const STATUSES = ['Pending', 'Completed'];

    protected function casts(): array
    {
        return ['due_date' => 'date'];
    }
}