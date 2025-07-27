<!DOCTYPE html>
<html 
  lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
  class="scroll-smooth"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title', 'The Soft Horizon')</title>
    
    <!-- SEO & Social -->
    <meta name="description" content="Discover inspiring travel stories, food, culture, and hidden gems around the world.">
    <meta name="author" content="The Soft Horizon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Open Graph for Social Sharing -->
    <meta property="og:title" content="@yield('title', 'The Soft Horizon')">
    <meta property="og:description" content="Explore breathtaking travel stories and cultural experiences.">
    <meta property="og:image" content="{{ asset('images/preview.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Tailwind via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    html {
        scroll-behavior: smooth;
    }
    </style>
</head>
<body class="antialiased leading-relaxed font-body bg-white text-gray-900">

    {{-- Header --}}
    @include('components.navigation')

    {{-- Main content --}}
    <main class="container mx-auto px-4 py-10">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    @yield('scripts')
</body>
</html>
