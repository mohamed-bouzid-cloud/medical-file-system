<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Medical File System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-900">

    <div class="min-h-screen flex items-center justify-center">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>