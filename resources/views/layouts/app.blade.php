<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Medical App' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto py-6">
        {{ $slot }}
    </div>
    @livewireScripts
    
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-dicom-viewer', (data) => {
                console.log("DEBUG EVENT DATA:", data);
                alert("✅ Opening DICOM Viewer: " + data.url);
                window.open(data.url, '_blank');
            });

            Livewire.on('dicom-error', (data) => {
                alert("❌ DICOM Error: " + data.message);
            });
        });
    </script>


</body>
</html>
