<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Register</title>
    @vite('resources/css/app.css')  {{-- Tailwind --}}
    @livewireStyles
</head>
<body class="bg-gray-950 text-white flex justify-center items-center min-h-screen">
    
    <livewire:register-patient/>

    @livewireScripts
</body>
</html>
