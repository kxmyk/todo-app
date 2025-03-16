<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use AuthorizesRequests;

    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request): View|JsonResponse
    {
        $tasks = $this->taskService->getUserTasks(Auth::id(), $request->all());

        if ($request->wantsJson()) {
            return response()->json($tasks);
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function edit(Task $task): View
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    public function store(TaskRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Task::class);
        $task = $this->taskService->createTask($request->validated(), Auth::user());

        if ($request->wantsJson()) {
            return response()->json($task, 201);
        }

        return redirect()->route('tasks.index')->with('success', 'Zadanie dodane!');
    }

    public function update(TaskRequest $request, Task $task): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $task);
        $task = $this->taskService->updateTask($task, $request->validated());

        if ($request->wantsJson()) {
            return response()->json($task);
        }

        return redirect()->route('tasks.index')->with('success', 'Zadanie zaktualizowane!');
    }

    public function destroy(Request $request, Task $task): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $task);
        $this->taskService->deleteTask($task);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Task deleted successfully']);
        }

        return redirect()->route('tasks.index')->with('success', 'Zadanie usunięte!');
    }

    public function generateAccessToken(Task $task): JsonResponse
    {
        $this->authorize('generateAccessToken', $task);
        return response()->json(['access_token' => $this->taskService->generateAccessToken($task)]);
    }

    public function showByToken(string $token): JsonResponse|View
    {
        $task = $this->taskService->getTaskByToken($token);

        if (!$task) {
            return response()->json(['message' => 'Invalid or expired token'], 404);
        }

        return view('tasks.shared', compact('task'));
    }
}
