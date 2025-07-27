<header class="bg-[#1A3D3F] text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        {{-- Left: Logo & Site Title --}}
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <img src="/uploads/posts/blog.png" alt="Logo" class="h-12 w-auto">
            <span class="text-2xl font-semibold tracking-wide text-[#BCE4E0]">The Soft Horizon</span>
        </a>

        @php $route = Route::currentRouteName(); @endphp

        {{-- Center: Desktop Nav --}}
        <nav class="hidden md:flex space-x-6 text-sm font-medium">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-[#BCE4E0] border-b-2 border-[#BCE4E0] pb-1' : 'hover:text-[#BCE4E0]' }}">Home</a>
           @auth
            <div 
                x-data="{ open: false }"
                @mouseenter="open = true"
                @mouseleave="open = false"
                class="relative"
            >
                <div 
                    @click="open = !open"
                    class="cursor-pointer flex items-center space-x-1 hover:text-[#BCE4E0] {{ request()->is('blogs') || $route === 'blogpost.show' || request()->is('your-posts') ? 'text-[#BCE4E0] border-b-2 border-[#BCE4E0] pb-1' : '' }}"
                >
                    <span>Blogs</span>
                    <svg class="w-4 h-4 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </div>

                <div 
                    x-show="open"
                    x-transition
                    @click.away="open = false"
                    class="absolute bg-white text-[#1A3D3F] rounded shadow-md mt-2 min-w-[160px] z-50"
                    style="display: none;"
                >
                    <a href="{{ url('/blogs') }}" class="block px-4 py-2 hover:bg-[#BCE4E0] hover:text-[#1A3D3F]">All Blog Posts</a>
                    <a href="{{ url('/your-posts') }}" class="block px-4 py-2 hover:bg-[#BCE4E0] hover:text-[#1A3D3F]">Your Posts</a>
                </div>
            </div>
            @else
                <a href="{{ url('/blogs') }}" class="{{ request()->is('blogs') || $route === 'blogpost.show' ? 'text-[#BCE4E0] border-b-2 border-[#BCE4E0] pb-1' : 'hover:text-[#BCE4E0]' }}">Blogs</a>
            @endauth
            <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'text-[#BCE4E0] border-b-2 border-[#BCE4E0] pb-1' : 'hover:text-[#BCE4E0]' }}">About</a>
            <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'text-[#BCE4E0] border-b-2 border-[#BCE4E0] pb-1' : 'hover:text-[#BCE4E0]' }}">Contact</a>
        </nav>

        {{-- Right: Auth Area --}}
        <div class="flex items-center space-x-3 text-sm">
            @auth
                <span class="text-[#BCE4E0] font-medium"> Welcome, {{ Auth::user()->name }} !</span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="border border-[#BCE4E0] text-[#BCE4E0] px-4 py-2 rounded hover:bg-[#BCE4E0] hover:text-[#1A3D3F] transition">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'bg-[#BCE4E0] text-[#1A3D3F]' : 'border border-[#BCE4E0] text-[#BCE4E0]' }} px-4 py-2 rounded hover:bg-[#BCE4E0] hover:text-[#1A3D3F] transition">Login</a>
                <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'bg-[#BCE4E0] text-[#1A3D3F]' : 'border border-[#BCE4E0] text-[#BCE4E0]' }} px-4 py-2 rounded hover:bg-[#BCE4E0] hover:text-[#1A3D3F] transition">Sign Up</a>
            @endauth
        </div>
    </div>

    {{-- Mobile Menu Toggle --}}
    <div class="md:hidden px-4 pb-3 flex justify-end">
        <button id="menuToggle" class="text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    {{-- Mobile Nav --}}
    <div id="mobileMenu" class="hidden md:hidden bg-[#1A3D3F] px-4 pb-4 space-y-2 text-sm">
        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-[#BCE4E0]' : 'hover:text-[#BCE4E0]' }} block">Home</a>
        @auth
            <div>
                <span class="block text-[#BCE4E0] font-semibold">Blogs</span>
                <a href="{{ url('/blogs') }}" class="ml-4 block hover:text-[#BCE4E0]">All Blog Posts</a>
                <a href="{{ url('/your-posts') }}" class="ml-4 block hover:text-[#BCE4E0]">Your Posts</a>
            </div>
        @else
            <a href="{{ url('/blogs') }}" class="{{ request()->is('blogs') || $route === 'blogpost.show' ? 'text-[#BCE4E0]' : 'hover:text-[#BCE4E0]' }} block">Blogs</a>
        @endauth
        <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'text-[#BCE4E0]' : 'hover:text-[#BCE4E0]' }} block">About</a>
        <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'text-[#BCE4E0]' : 'hover:text-[#BCE4E0]' }} block">Contact</a>

        @guest
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'text-[#BCE4E0]' : 'hover:text-[#BCE4E0]' }} block">Login</a>
            <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'text-[#BCE4E0]' : 'hover:text-[#BCE4E0]' }} block">Sign Up</a>
        @endguest
    </div>
</header>

{{-- Mobile Toggle Script --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('menuToggle').addEventListener('click', () => {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    });
</script>
