@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Logowanie</h2>

    <div id="error-message" class="mb-4 text-red-500 hidden"></div>
    @if (session('success'))
    <div class="bg-green-500 text-white p-2 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif


    <form id="login-form">
        @csrf
        <div class="mb-4">
            <label class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Hasło</label>
            <input type="password" name="password" id="password" class="w-full border p-2 rounded" required>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Zaloguj się</button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        Nie masz jeszcze konta? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Utwórz je
            tutaj</a>
    </p>
</div>

<script>
    document.getElementById("login-form").addEventListener("submit", function (event) {
        event.preventDefault();

        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        const errorMessage = document.getElementById("error-message");

        fetch("{{ route('api.login') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({email, password})
        })
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    localStorage.setItem("auth_token", data.token);
                    window.location.href = "{{ route('tasks.index') }}";
                } else {
                    errorMessage.innerText = data.message || "Nieprawidłowe dane logowania.";
                    errorMessage.classList.remove("hidden");
                }
            })
            .catch(error => console.error("Błąd logowania:", error));
    });

    document.addEventListener("DOMContentLoaded", function () {
        if (window.location.search.includes("logout=true")) {
            localStorage.removeItem("auth_token");
        }
    });
</script>
@endsection
