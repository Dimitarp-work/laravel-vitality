<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Server Error</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-5xl mx-auto flex flex-col items-center justify-center min-h-screen px-6 py-8">
        <div class="text-center">
            <div class="mb-6">
                <span class="material-icons text-pink-400 text-8xl">warning</span>
            </div>
            <h1 class="text-4xl font-bold text-pink-900 mb-4">500</h1>
            <h2 class="text-2xl font-semibold text-pink-700 mb-6">Server Error</h2>
            <p class="text-pink-600 mb-8 max-w-md mx-auto">
                Oops! Something went wrong on our end. We're working to fix it.
            </p>
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                <span class="material-icons">home</span>
                Back to Home
            </a>
        </div>
    </div>
</body>
</html>
