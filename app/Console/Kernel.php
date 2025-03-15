<?php

namespace App\Console;

use App\Models\Task;
use App\Notifications\TaskDueNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('queue:work --stop-when-empty')->everyMinute();

        $schedule->call(function () {
            Task::whereDate('due_date', now()->addDay()->toDateString())->each(
                fn($task) => $task->user?->notify(new TaskDueNotification($task))
            );
        })->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
