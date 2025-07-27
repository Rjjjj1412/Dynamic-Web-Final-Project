<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
  @forelse ($posts as $post)
    <div class="bg-white rounded shadow-md overflow-hidden hover:shadow-lg transition">
      <img src="{{ asset($post->featured_image_url) }}" class="w-full h-48 object-cover">
      <div class="p-4 text-[#1A3D3F] prose">
        <h2 class="text-lg font-bold mb-1">
          <a href="{{ route('blogpost.show', $post->slug) }}" class="hover:underline">{{ $post->title }}</a>
        </h2>
        <p class="text-sm text-gray-600 mb-2">
        <span class="font-semibold text-[#1A3D3F]">By {{ $post->user->name ?? 'Unknown' }}</span> · 
        {{ \Carbon\Carbon::parse($post->publication_date)->format('M d, Y') }} · 
        {{ $post->views_count ?? 0 }} views
        </p>
        <p class="text-sm text-gray-700 mb-3">{{ Str::limit(strip_tags($post->content), 130) }}</p>
        <div class="flex flex-wrap gap-2">
          @foreach ($post->categories as $cat)
            <span class="bg-[#BCE4E0] text-[#1A3D3F] px-2 py-1 rounded text-xs">{{ $cat->category_name }}</span>
          @endforeach
          @foreach ($post->tags as $tag)
            <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs">#{{ $tag->tag_name }}</span>
          @endforeach
        </div>
      </div>
    </div>
  @empty
    <p class="col-span-2 text-center text-gray-500">No blog posts found.</p>
  @endforelse
</div>

@if ($posts->hasPages())
  <div class="flex justify-center mt-4 pagination">
    {!! $posts->appends(request()->query())->links() !!}
  </div>
@endif
