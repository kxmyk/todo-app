<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>To-Do List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        @auth
            <nav class="flex justify-between bg-white p-4 rounded shadow mb-4">
                <a href="{{ route('tasks.index') }}" class="text-lg font-bold">Moje Zadania</a>
                <form method="POST" action="{{ route('api.logout') }}">
                    @csrf
                    <button type="submit" class="text-red-500">Wyloguj</button>
                </form>
            </nav>
        @endauth

        <div class="bg-white p-6 rounded shadow">
            @yield('content')
        </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    if (!localStorage.getItem("auth_token") && window.location.pathname !== "/login") {
        window.location.href = "/login";
    }
});
</script>

</body>
</html>
