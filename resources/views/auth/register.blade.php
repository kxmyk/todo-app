@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Rejestracja</h2>

    <form method="POST" action="{{ route('api.register') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Nazwa użytkownika</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Hasło</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Potwierdź hasło</label>
            <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
        </div>

        <button type="submit" class="w-full bg-green-500 text-white py-2 rounded">Zarejestruj się</button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        Masz już konto? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Zaloguj się tutaj</a>
    </p>
</div>
@endsection
