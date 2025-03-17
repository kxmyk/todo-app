@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Edytuj Zadanie</h2>

@if(session('success'))
<div class="bg-green-500 text-white p-2 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="block">Nazwa:</label>
        <input type="text" name="name" value="{{ $task->name }}" required class="w-full border p-2 rounded">
    </div>
    <div class="mb-3">
        <label class="block">Priorytet:</label>
        <select name="priority" class="w-full border p-2 rounded">
            <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Niski</option>
            <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Średni</option>
            <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>Wysoki</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="block">Status:</label>
        <select name="status" class="w-full border p-2 rounded">
            <option value="to-do" {{ $task->status == 'to-do' ? 'selected' : '' }}>Do zrobienia</option>
            <option value="in-progress" {{ $task->status == 'in-progress' ? 'selected' : '' }}>W trakcie</option>
            <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Zakończone</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="block">Termin:</label>
        <input type="date" name="due_date" value="{{ $task->due_date }}" required class="w-full border p-2 rounded">
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Zapisz zmiany</button>
</form>

<a href="{{ route('tasks.index') }}" class="text-blue-500">Powrót do listy</a>
@endsection
