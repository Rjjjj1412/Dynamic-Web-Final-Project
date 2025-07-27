<div id="recent-posts-wrapper">
    {{-- Posts List --}}
    <div id="recent-posts-list">
        @foreach ($recentPosts as $post)
            <div class="bg-[#BCE4E0] rounded-lg shadow-lg p-6 mb-6 text-[#1A3D3F]">
                <div class="flex items-center space-x-6">
                    {{-- Post Image --}}
                    <div class="w-32 h-32 rounded-lg overflow-hidden border border-[#3B7D75] flex-shrink-0">
                        <img src="{{ $post->featured_image_url ?? asset('images/default.jpg') }}"
                             alt="{{ $post->title }}"
                             class="w-full h-full object-cover">
                    </div>

                    {{-- Post Content --}}
                    <div class="flex flex-col justify-between w-full prose">
                        {{-- Date and Category --}}
                        <p class="text-sm text-[#3B7D75]">
                            {{ \Carbon\Carbon::parse($post->publication_date)->format('F j, Y') }}
                            @if ($post->categories()->exists())
                                · {{ $post->categories()->first()->category_name }}
                            @endif
                        </p>

                        {{-- Title --}}
                        <h4 class="text-xl font-semibold mt-1 hover:text-[#3B7D75] transition">
                            {{ $post->title }}
                        </h4>

                        {{-- Excerpt (2 sentences) --}}
                        <div class="text-gray-700 text-sm mt-2 space-y-1">
                            @php
                                $sentences = preg_split('/(?<=[.?!])\s+/', strip_tags($post->content));
                                $preview = array_slice($sentences, 0, 2);
                            @endphp
                            @foreach ($preview as $sentence)
                                <p>{{ $sentence }}</p>
                            @endforeach
                        </div>

                        {{-- Read More --}}
                        <a href="/posts/{{ $post->slug }}"
                           class="mt-3 text-[#3B7D75] text-sm font-medium hover:underline w-fit">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div id="recent-posts-pagination" class="mt-6">
        {{ $recentPosts->withPath(request()->url())->links('pagination::tailwind') }}
    </div>
</div>

{{-- AJAX Pagination Script --}}
<script>
    document.addEventListener('click', function (e) {
        const link = e.target.closest('#recent-posts-pagination a');
        if (link) {
            e.preventDefault();
            fetch(link.href, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('recent-posts-list').innerHTML = data.html;
                document.getElementById('recent-posts-pagination').innerHTML = data.pagination;
                window.scrollTo({
                    top: document.getElementById('recent-posts-wrapper').offsetTop - 100,
                    behavior: 'smooth'
                });
            });
        }
    });
</script>
