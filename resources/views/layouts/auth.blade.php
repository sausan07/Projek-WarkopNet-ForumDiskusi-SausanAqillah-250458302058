<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login - WarkopNet' }}</title>
    <link rel="icon" href="{{ asset('images/favicon.png')}}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;700&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .font-utama { font-family: 'Quicksand', sans-serif; } h2 { font-family: 'Fredoka', sans-serif; font-weight:700; } input::placeholder { font-weight: 400; }
    </style>

    

    @livewireStyles
</head>
<body class="bg-[#FCE7C8] min-h-screen flex items-center justify-center p-4">
    
   {{ $slot }}
    
    @livewireScripts
</body>
</html>
