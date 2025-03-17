@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold my-6 text-center">Udostępnione Zadanie</h2>

        @if ($task)
            <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold">{{ $task->name }}</h3>
                <p class="text-gray-600">Termin: {{ $task->due_date }}</p>

                <span class="inline-block mt-2 px-3 py-1 rounded-full text-white text-sm
                    @if($task->priority == 'low') bg-green-500
                    @elseif($task->priority == 'medium') bg-orange-500
                    @else bg-red-500
                    @endif">
                    Priorytet: {{ ucfirst($task->priority) }}
                </span>

                <span class="block mt-2 px-3 py-1 rounded text-sm
                    @if($task->status == 'to-do') bg-gray-300
                    @elseif($task->status == 'in-progress') bg-yellow-300
                    @else bg-green-300
                    @endif">
                    Status: {{ ucfirst(str_replace('-', ' ', $task->status)) }}
                </span>

                <p class="mt-4 text-gray-800">{{ $task->description }}</p>
            </div>
        @else
            <p class="text-center text-red-500">Nie znaleziono zadania lub link wygasł.</p>
        @endif
    </div>
@endsection
