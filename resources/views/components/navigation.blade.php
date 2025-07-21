<header class="bg-gray-900 text-white shadow">
    <div class="container mx-auto flex justify-between items-center p-4">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="w-10 h-10 rounded-full">
            <span class="text-xl font-bold">Blog</span>
        </div>
        <nav class="space-x-6">
            <a href="{{ route('home') }}" class="hover:text-yellow-400">Home</a>
            <a href="{{ route('blogs.index') }}" class="hover:text-yellow-400">Blogs</a>
            <a href="{{ route('contact') }}" class="hover:text-yellow-400">Contact</a>
            <a href="{{ route('login') }}" class="bg-yellow-500 px-4 py-2 rounded hover:bg-yellow-600 text-black font-semibold">Log In</a>
        </nav>
    </div>
</header>
