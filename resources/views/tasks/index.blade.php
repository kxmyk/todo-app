@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <a href="{{ route('tasks.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Dodaj
        zadanie</a>

    <h2 class="text-2xl font-bold my-6">Lista zadań</h2>

    <div class="mb-4 flex space-x-2">
        <select id="filter-priority" class="border rounded p-2">
            <option value="">Wszystkie priorytety</option>
            <option value="low">Niski</option>
            <option value="medium">Średni</option>
            <option value="high">Wysoki</option>
        </select>
        <select id="filter-status" class="border rounded p-2">
            <option value="">Wszystkie statusy</option>
            <option value="to-do">Do zrobienia</option>
            <option value="in-progress">W trakcie</option>
            <option value="done">Zrobione</option>
        </select>
        <input type="date" id="filter-date" class="border rounded p-2">
    </div>

    @if(session('success'))
    <div class="bg-green-500 text-white p-2 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <ul id="task-list" class="list-disc pl-5 space-y-2"></ul>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
            function fetchTasks(filters = {}) {
                let query = new URLSearchParams(filters).toString();
                fetch(`/tasks?${query}`, {
                    headers: {
                        "Authorization": `Bearer ${localStorage.getItem("auth_token")}`,
                        "Accept": "application/json",
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const taskList = document.getElementById("task-list");
                    taskList.innerHTML = "";

                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(task => {
                            const li = document.createElement("li");

                            const statusColors = {
                                "to-do": "bg-gray-300",
                                "in-progress": "bg-yellow-300",
                                "done": "bg-green-300"
                            };

                            const priorityColors = {
                                "low": "text-green-500",
                                "medium": "text-orange-500",
                                "high": "text-red-500 font-bold"
                            };

                            li.innerHTML = `
                                <div class="flex items-center justify-between bg-white p-4 rounded shadow">
                                    <div>
                                        <p class="font-semibold">${task.name} - <span class="text-sm text-gray-600">${task.due_date}</span></p>
                                        <p class="text-sm ${priorityColors[task.priority]}">Priorytet: ${task.priority}</p>
                                        <p class="text-sm px-2 inline-block rounded ${statusColors[task.status]}">Status: ${task.status}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="/tasks/${task.id}/edit" class="bg-yellow-500 text-white px-2 py-1 rounded">Edytuj</a>
                                        <button onclick="deleteTask(${task.id})" class="bg-red-500 text-white px-2 py-1 rounded">Usuń</button>
                                        <button onclick="generateShareLink(${task.id})" class="bg-blue-500 text-white px-2 py-1 rounded">Udostępnij</button>
                                    </div>
                                </div>
                            `;
                            taskList.appendChild(li);
                        });
                    } else {
                        taskList.innerHTML = "<p class='text-gray-500'>Brak zadań do wyświetlenia.</p>";
                    }
                })
                .catch(error => console.error("Błąd pobierania zadań:", error));
            }

            window.deleteTask = function (taskId) {
                if (!confirm("Czy na pewno chcesz usunąć to zadanie?")) return;

                fetch(`/tasks/${taskId}`, {
                    method: "DELETE",
                    headers: {
                        "Authorization": `Bearer ${localStorage.getItem("auth_token")}`,
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                })
                .then(response => response.json())
                .then(data => {
                    alert("Zadanie usunięte");
                    fetchTasks();
                })
                .catch(error => console.error("Błąd usuwania zadania:", error));
            };

            window.generateShareLink = function (taskId) {
                fetch(`/tasks/${taskId}/generate-access-token`, {
                    method: "POST",
                    headers: {
                        "Authorization": `Bearer ${localStorage.getItem("auth_token")}`,
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.access_token) {
                        const shareLink = `${window.location.origin}/tasks/shared/${data.access_token}`;
                        alert("Udostępnij ten link:\n" + shareLink);
                    } else {
                        alert("Nie udało się wygenerować linku.");
                    }
                })
                .catch(error => console.error("Błąd generowania linku:", error));
            };

            function applyFilters() {
                const priority = document.getElementById("filter-priority").value;
                const status = document.getElementById("filter-status").value;
                const date = document.getElementById("filter-date").value;
                fetchTasks({ priority, status, due_date: date });
            }

            document.getElementById("filter-priority").addEventListener("change", applyFilters);
            document.getElementById("filter-status").addEventListener("change", applyFilters);
            document.getElementById("filter-date").addEventListener("change", applyFilters);

            fetchTasks();
        });
</script>
@endsection
