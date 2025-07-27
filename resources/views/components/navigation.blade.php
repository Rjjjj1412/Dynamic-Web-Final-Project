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
            <a href="{{ url('/blogs') }}" class="{{ request()->is('blogs') || $route === 'blogpost.show' ? 'text-[#BCE4E0] border-b-2 border-[#BCE4E0] pb-1' : 'hover:text-[#BCE4E0]' }}">Blogs</a>
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
        <a href="{{ url('/blogs') }}" class="{{ request()->is('blogs') || $route === 'blogpost.show' ? 'text-[#BCE4E0]' : 'hover:text-[#BCE4E0]' }} block">Blogs</a>
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
