<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>{{ config('app.name', 'Laravel') }}</title>

   <!-- Fonts -->
   <link rel="preconnect" href="https://fonts.bunny.net">
   <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

   <!-- Scripts -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased"
   style="
      min-height: 100vh;
      background: linear-gradient(135deg, #f8f6f2 0%, #f3ede4 25%, #e7d7c2 50%, #f3c98b 75%, #e7d7c2 100%);
      background-size: cover;
      background-repeat: no-repeat;
      position: relative;
      overflow: hidden;
   ">
   <div class="min-h-screen flex flex-col justify-center items-center">
      {{ $slot }}
   </div>
   <!-- efeito de textura removido para um visual mais limpo e próximo do gradiente da madeira clara -->
</body>

</html>
