@extends('layouts.master')

@section('title', 'Show Blog Post')

@section('content')
<div 
    class="px-4 md:px-8 py-12 max-w-6xl mx-auto space-y-16 text-[#1A3D3F] transition-all" 
    x-data="commentsComponent('{{ $post->slug }}')" 
    x-init="init()"
>
    {{-- Blog Metadata --}}
    <header class="space-y-2 border-b pb-6">
        <h1 class="text-4xl font-bold">{{ $post->title }}</h1>
            @auth
            @if ($post->status === 'D' && auth()->id() === $post->user_id)
                <div class="flex items-center gap-3 mt-4">
                    <!-- Edit Button -->
                    <a href="{{ route('blogpost.edit', $post->slug) }}"
                    class="bg-[#BCE4E0] hover:bg-[#a7d3cc] text-[#1A3D3F] font-semibold py-2 px-4 rounded transition">
                        ✎ Edit Draft
                    </a>

                    <!-- Delete Button -->
                    <form action="{{ route('blogpost.destroy', $post->slug) }}" method="POST" 
                        onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.');" 
                        class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition mt-2 ml-2">
                            🗑️ Delete Post
                        </button>
                    </form>
                </div>
            @endif
        @endauth
        <div class="text-sm text-gray-600">
            By <span class="font-semibold">{{ $post->user->name }}</span> |
            {{ \Carbon\Carbon::parse($post->publication_date)->format('F j, Y') }} |
            {{ $post->views_count }} {{ Str::plural('view', $post->views_count) }}
        </div>
        <div class="flex flex-wrap gap-2 mt-2">
            @foreach ($post->categories as $category)
                <span class="bg-[#BCE4E0] text-[#1A3D3F] px-2 py-1 rounded text-xs">{{ $category->category_name }}</span>
            @endforeach
            @foreach ($post->tags as $tag)
                <span class="border border-[#BCE4E0] text-[#1A3D3F] px-2 py-1 rounded text-xs">#{{ $tag->tag_name }}</span>
            @endforeach
        </div>
    </header>

    {{-- Featured Image --}}
    @if($post->featured_image_url)
        <div class="rounded-xl overflow-hidden shadow-md">
            <img src="{{ asset($post->featured_image_url) }}" alt="{{ $post->title }}" class="w-full h-[22rem] object-cover">
        </div>
    @endif

    {{-- Post Content --}}
    <div class="text-gray-700 prose prose-lg max-w-none">
        {!! $post->content !!}
    </div>

    {{-- Comments --}}
<section id="comments-section" class="bg-[#F0FAF9] border border-[#BCE4E0] p-8 rounded-xl shadow space-y-8">
    <h2 class="text-2xl font-semibold">Comments</h2>

    {{-- Success Prompt --}}
    <template x-if="successMessage">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" x-text="successMessage"></div>
    </template>

    {{-- Live Comments --}}
    <div class="space-y-6">
        <template x-for="comment in comments" :key="comment.id">
            <div class="bg-white border border-[#BCE4E0] p-4 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-semibold" x-text="comment.reviewer_name"></span>
                    <span class="text-xs text-gray-500" x-text="comment.comment_date"></span>
                </div>
                <p class="text-sm leading-relaxed" x-text="comment.comment_content"></p>
            </div>
        </template>
        <template x-if="comments.length === 0">
            <p class="text-sm text-gray-500">No comments yet.</p>
        </template>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center gap-2 mt-6">
        <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1"
            class="px-3 py-1 text-sm border rounded"
            :class="pagination.current_page === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-[#E6F2F0]'">Prev</button>

        <template x-for="page in pagination.last_page" :key="page">
            <button @click="changePage(page)" x-text="page"
                class="px-3 py-1 text-sm border rounded"
                :class="pagination.current_page === page ? 'bg-[#BCE4E0] font-semibold' : 'hover:bg-[#E6F2F0]'">
            </button>
        </template>

        <button @click="changePage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page"
            class="px-3 py-1 text-sm border rounded"
            :class="pagination.current_page === pagination.last_page ? 'opacity-50 cursor-not-allowed' : 'hover:bg-[#E6F2F0]'">Next</button>
    </div>

    {{-- Comment Form --}}
    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4">Leave a Comment</h3>
        <form @submit.prevent="submitComment" class="space-y-4">
            <div>
                <label for="reviewer_name" class="block text-sm font-medium">Name</label>
                <input type="text" id="reviewer_name" x-model="form.reviewer_name" required
                    class="w-full px-4 py-2 border border-[#BCE4E0] rounded-lg bg-white text-[#1A3D3F]">
            </div>
            <div>
                <label for="reviewer_email" class="block text-sm font-medium">Email</label>
                <input type="email" id="reviewer_email" x-model="form.reviewer_email" required
                    class="w-full px-4 py-2 border border-[#BCE4E0] rounded-lg bg-white text-[#1A3D3F]">
            </div>
            <div>
                <label for="comment_content" class="block text-sm font-medium">Comment</label>
                <textarea id="comment_content" x-model="form.comment_content" rows="4" required
                    class="w-full px-4 py-2 border border-[#BCE4E0] rounded-lg bg-white text-[#1A3D3F]"></textarea>
            </div>
            <div>
                <button type="submit"
                    class="bg-[#BCE4E0] hover:bg-[#a7d3cc] text-[#1A3D3F] font-semibold py-2 px-6 rounded-lg transition">
                    Submit Comment
                </button>
            </div>
        </form>
    </div>
</section>

    {{-- Related Posts --}}
    <section class="mt-20">
        <h2 class="text-xl font-bold mb-4">You might also like</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @forelse ($relatedPosts as $related)
                <a href="{{ route('blogpost.show', $related->slug) }}" class="group">
                    <div class="overflow-hidden rounded-lg shadow-md">
                        @if($related->featured_image_url)
                            <img src="{{ asset($related->featured_image_url) }}" alt="{{ $related->title }}"
                                 class="h-40 w-full object-cover transition duration-300 group-hover:scale-105">
                        @endif
                    </div>
                    <div class="mt-2">
                        <h3 class="text-lg font-bold">{{ $related->title }}</h3>
                        <p class="text-sm text-gray-500">{{ Str::limit(strip_tags($related->content), 80) }}</p>
                    </div>
                </a>
            @empty
                <p class="text-gray-500">No related posts found.</p>
            @endforelse
        </div>
        <div class="mt-10">
            <a href="{{ route('home') }}" class="text-[#1A3D3F] font-medium hover:underline">← Back to Blog</a>
        </div>
    </section>

    {{-- Scroll to Top --}}
    <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-6 right-6 z-50 bg-[#BCE4E0] hover:bg-[#a7d3cc] text-[#1A3D3F] px-4 py-2 rounded-full shadow-lg">
        ↑
    </button>
</div>

<script>
    function commentsComponent(slug) {
        return {
            comments: [],
            pagination: {
                current_page: 1,
                last_page: 1
            },
            successMessage: '',
            form: {
                reviewer_name: '{{ auth()->user()->name ?? '' }}',
                reviewer_email: '{{ auth()->user()->email ?? '' }}',
                comment_content: ''
            },
            fetchComments(page = 1) {
                fetch(`/blogpost/${slug}/comments?page=${page}`)
                    .then(res => res.json())
                    .then(data => {
                        this.comments = data.data;
                        this.pagination.current_page = data.current_page;
                        this.pagination.last_page = data.last_page;
                    });
            },
            changePage(page) {
                if (page >= 1 && page <= this.pagination.last_page) {
                    this.fetchComments(page);
                    this.$nextTick(() => {
                        const el = document.getElementById('comments-section');
                        const offset = 100; // adjust based on your fixed header height
                        if (el) {
                            const y = el.getBoundingClientRect().top + window.scrollY - offset;
                            window.scrollTo({ top: y, behavior: 'smooth' });
                        }
                    });
                }
            },
            submitComment() {
                fetch(`/blogpost/${slug}/comments`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(this.form)
                })
                .then(res => res.json())
                .then(data => {
                    this.form.comment_content = '';
                    this.successMessage = 'Comment submitted successfully!';
                    this.fetchComments(1);

                    // Scroll to top of comments
                    this.$nextTick(() => {
                        const el = document.getElementById('comments-section');
                        if (el) el.scrollIntoView({ behavior: 'smooth' });
                    });

                    setTimeout(() => this.successMessage = '', 3000);
                });
            },
            init() {
                this.fetchComments();
            }
        };
    }
</script>
@endsection
