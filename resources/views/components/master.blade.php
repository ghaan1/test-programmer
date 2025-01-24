<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMS Web App</title>
    @vite('resources/js/app.js')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        .sidebar-transition {
            transition: width 0.3s ease;
        }

        [x-cloak] {
            display: none;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100" x-data="sidebar" x-cloak x-init="init()">
    <div class="min-h-screen flex" x-show="isInitialized">
        <x-sidebar />
        <div class="flex-1 p-8">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
