<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="flex flex-col items-center space-y-6">

    <div class="bg-white shadow-md rounded-xl p-8 max-w-xl text-center">
        <h1 class="text-4xl font-bold text-pink-400 mb-4">Page not found! (404)</h1>
        <p class="text-pink-400">
            The page you are looking for does not exist.<br>
            Please check the address once again!<br>
            If you did enter the correct address, see below:
        </p>
    </div>

        <button
            onclick="window.history.back();"
            class="text-white text-2xl font-semibold px-6 py-3 bg-pink-300 hover:bg-pink-700 transition rounded-xl">
            Go back to the previous page!
        </button>


</div>

</body>
</html>
