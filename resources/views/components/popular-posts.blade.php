<div class="bg-[#E6F2F0] p-4 rounded-lg shadow-md">
    @foreach ($popularPosts as $post)
        <a href="{{ route('blogpost.show', $post->slug) }}"
           class="flex items-center mb-4 p-2 rounded-md hover:bg-[#D4EAE6] transition group">

            {{-- Thumbnail --}}
            <div class="w-16 h-16 flex-shrink-0 rounded-md overflow-hidden border border-[#3B7D75] mr-4">
                <img src="{{ isset($post['featured_image_url']) ? asset($post['featured_image_url']) : asset('images/default.jpg') }}"
                     alt="{{ $post->title }}"
                     class="w-full h-full object-cover">
            </div>

            {{-- Title & Meta --}}
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-[#1A3D3F] group-hover:text-[#3B7D75] transition line-clamp-2">
                    {{ $post->title }}
                </h4>
                <p class="text-xs text-[#1A3D3F] mt-1">
                    {{ \Carbon\Carbon::parse($post->publication_date)->format('M d, Y') }}
                    @if ($post->views_count)
                        · {{ number_format($post->views_count) }} views
                    @endif
                </p>
            </div>
        </a>
    @endforeach
</div>
