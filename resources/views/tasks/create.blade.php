@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Dodaj Zadanie</h2>

@if(session('success'))
<div class="bg-green-500 text-white p-2 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="block">Nazwa:</label>
        <input type="text" name="name" required class="w-full border p-2 rounded">
    </div>
    <div class="mb-3">
        <label class="block">Priorytet:</label>
        <select name="priority" class="w-full border p-2 rounded">
            <option value="low">Niski</option>
            <option value="medium">Średni</option>
            <option value="high">Wysoki</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="block">Status:</label>
        <select name="status" class="w-full border p-2 rounded">
            <option value="to-do">Do zrobienia</option>
            <option value="in-progress">W trakcie</option>
            <option value="done">Zakończone</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="block">Termin:</label>
        <input type="date" name="due_date" required class="w-full border p-2 rounded">
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Dodaj</button>
</form>

<a href="{{ route('tasks.index') }}" class="text-blue-500">Powrót do listy</a>
@endsection
