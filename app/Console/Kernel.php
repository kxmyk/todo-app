<?php

namespace App\Console;

use Carbon\Carbon;

use App\Models\Task;
use App\Notifications\TaskReminder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('queue:work --stop-when-empty')->everyMinute();

        $schedule->call(function () {
            $tasks = Task::whereDate('due_date', Carbon::tomorrow())->get();
            foreach ($tasks as $task) {
                Notification::send($task->user, new TaskReminder($task));
            }
        })->dailyAt('08:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
