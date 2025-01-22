<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Vite Setup</title>
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-100">
    <h1 class="text-4xl text-center py-10">Test Setup</h1>

    <div x-data="{ open: false }">
        <button @click="open = !open" class="bg-blue-500 text-white px-4 py-2">
            Toggle
        </button>
        <div x-show="open" class="mt-4 bg-green-200 p-4">
            Test Alpine
        </div>
    </div>
</body>

</html>
