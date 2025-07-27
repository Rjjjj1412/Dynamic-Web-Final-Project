<footer class="bg-[#1A3D3F] text-white py-12 mt-16">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-10">
        
        {{-- Branding --}}
        <div>
            <div class="flex items-center mb-4">
                <img src="/uploads/posts/blog.png" alt="Logo" class="w-14 h-14 mr-3" />
                <span class="text-2xl font-bold text-[#BCE4E0]">The Soft Horizon</span>
            </div>
            <p class="text-sm text-gray-300 leading-relaxed mb-4">
                Journey through destinations, culture, and hidden wonders. Let every scroll inspire your next adventure.
            </p>
            <div class="flex space-x-3 mt-4">
                <a href="https://facebook.com" target="_blank" class="hover:text-[#BCE4E0]">
                    <img src="https://img.icons8.com/ios-filled/30/ffffff/facebook-new.png" alt="Facebook" />
                </a>
                <a href="https://instagram.com" target="_blank" class="hover:text-[#BCE4E0]">
                    <img src="https://img.icons8.com/ios-filled/30/ffffff/instagram-new--v1.png" alt="Instagram" />
                </a>
                <a href="https://tiktok.com" target="_blank" class="hover:text-[#BCE4E0]">
                    <img src="https://img.icons8.com/ios-filled/30/ffffff/tiktok--v1.png" alt="Tiktok" />
                </a>
                <a href="https://youtube.com" target="_blank" class="hover:text-[#BCE4E0]">
                    <img src="https://img.icons8.com/ios-filled/30/ffffff/youtube-play--v1.png" alt="Youtube" />
                </a>
            </div>
        </div>

        {{-- Tags --}}
        <div>
            <h4 class="text-lg font-semibold text-[#BCE4E0] mb-4">Popular Tags</h4>
            <div class="flex flex-wrap gap-2 text-sm">
                @foreach (\App\Models\Tag::take(12)->get() as $tag)
                    <a href="{{ url('/blogs?tag=' . urlencode($tag->tag_name)) }}"
                    class="bg-[#BCE4E0] text-[#1A3D3F] px-3 py-1 rounded-full hover:bg-[#a9d4cd] transition">
                        {{ $tag->tag_name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Navigation --}}
        <div class="md:text-left text-center">
            <h4 class="text-lg font-semibold text-[#BCE4E0] mb-4">Navigation</h4>
            <ul class="space-y-2 text-sm text-gray-300 text-left">
                <li><a href="/" class="hover:text-[#BCE4E0]">Home</a></li>
                <li><a href="/blogs" class="hover:text-[#BCE4E0]">Blogs</a></li>
                <li><a href="/about" class="hover:text-[#BCE4E0]">About</a></li>
                <li><a href="/contact" class="hover:text-[#BCE4E0]">Contact</a></li>
            </ul>
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="mt-10 border-t border-gray-700 pt-6 text-center text-sm text-gray-400">
        &copy; {{ date('Y') }} The Soft Horizon. All rights reserved.
    </div>
</footer>
