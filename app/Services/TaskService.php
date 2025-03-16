<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TaskService
{
    public function getUserTasks(int $userId, array $filters = []): mixed
    {
        $query = Task::where('user_id', $userId);

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['due_date'])) {
            $query->whereDate('due_date', $filters['due_date']);
        }

        return $query->get();
    }

    public function createTask(array $data, User $user): Task
    {
        return Task::create([...$data, 'user_id' => $user->id]);
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function deleteTask(Task $task): void
    {
        $task->delete();
    }

    public function generateAccessToken(Task $task): string
    {
        $task->access_token = Str::random(32);
        $task->access_token_expires_at = Carbon::now()->addHours(24);
        $task->save();
        return $task->access_token;
    }

    public function getTaskByToken(string $token): ?Task
    {
        $task = Task::where('access_token', $token)->first();
        return $task && $task->isAccessTokenValid() ? $task : null;
    }
}
