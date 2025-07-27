@extends('layouts.master')

@section('title', 'Your Blog Posts')

@section('content')
<div 
    class="px-4 md:px-8 py-12 max-w-6xl mx-auto space-y-16 text-[#1A3D3F] transition-all" 
    x-data="postsComponent('{{ route('blogpost.yourposts.json') }}')"
    x-init="init()"
>
    <header class="space-y-2 border-b pb-6">
        <h1 class="text-4xl font-bold">Your Blog Posts</h1>
    </header>

    <!-- Search & Filter Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6 sticky top-0 bg-white z-10 py-4">
        <input type="text" placeholder="Search your posts..." class="w-full md:w-1/2 border border-[#BCE4E0] px-4 py-2 rounded" x-model="search">
        <div class="flex gap-2">
            <select class="border border-[#BCE4E0] px-4 py-2 rounded" x-model="statusFilter">
                <option value="">All Statuses</option>
                <option value="P">Published</option>
                <option value="D">Draft</option>
            </select>
            <select class="border border-[#BCE4E0] px-4 py-2 rounded" x-model="sort">
                <option value="desc">Newest</option>
                <option value="asc">Oldest</option>
            </select>
        </div>
    </div>

    <!-- Posts List -->
    <template x-if="filteredPosts.length">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <template x-for="post in paginatedPosts" :key="post.id">
                <div class="bg-white rounded shadow-md overflow-hidden hover:shadow-lg transition">
                    <template x-if="post.featured_image_url">
                        <img :src="post.featured_image_url" class="w-full h-48 object-cover">
                    </template>
                    <div class="p-4 text-[#1A3D3F] prose">
                        <h2 class="text-lg font-bold mb-1">
                            <a :href="`/blogpost/${post.slug}`" class="hover:underline" x-text="post.title"></a>
                        </h2>
                        <p class="text-sm text-gray-600 mb-2">
                            <span class="font-semibold text-[#1A3D3F]" x-text="post.user && post.user.name ? post.user.name : 'Unknown'"></span> ·
                            <span x-text="new Date(post.publication_date).toLocaleDateString()"></span> · 
                            <span x-text="`${post.views_count ?? 0} views`"></span>
                        </p>
                        <p class="text-sm text-gray-700 mb-3" x-text="stripHtml(post.content).slice(0, 130) + '...'"></p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="cat in post.categories" :key="cat.id">
                                <span class="bg-[#BCE4E0] text-[#1A3D3F] px-2 py-1 rounded text-xs" x-text="cat.category_name"></span>
                            </template>
                            <template x-for="tag in post.tags" :key="tag.id">
                                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs" x-text="'#' + tag.tag_name"></span>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </template>

    <!-- No Posts -->
    <template x-if="!filteredPosts.length">
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg mb-4">No Posts Yet</p>
            <a href="{{ route('blogpost.create') }}" class="bg-[#1A3D3F] hover:bg-[#163233] text-white font-semibold py-2 px-6 rounded transition">
                Share Your Story
            </a>
        </div>
    </template>

    <!-- Pagination -->
    <div class="flex justify-center gap-2 mt-10" x-show="totalPages > 1">
        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
                class="px-3 py-1 text-sm border rounded"
                :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-[#E6F2F0]'">
            Prev
        </button>

        <template x-for="page in totalPages" :key="page">
            <button @click="changePage(page)" x-text="page"
                    class="px-3 py-1 text-sm border rounded"
                    :class="currentPage === page ? 'bg-[#BCE4E0] font-semibold' : 'hover:bg-[#E6F2F0]'">
            </button>
        </template>

        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages"
                class="px-3 py-1 text-sm border rounded"
                :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-[#E6F2F0]'">
            Next
        </button>
    </div>
</div>

<script>
function postsComponent(apiUrl) {
    return {
        posts: [],
        search: '',
        statusFilter: '',
        sort: 'desc',
        currentPage: 1,
        perPage: 10,

        get filteredPosts() {
            let results = this.posts;
            if (this.search) {
                const term = this.search.toLowerCase();
                results = results.filter(p => p.title.toLowerCase().includes(term));
            }
            if (this.statusFilter) {
                results = results.filter(p => p.status === this.statusFilter);
            }
            return results.sort((a, b) => {
                const dateA = new Date(a.publication_date);
                const dateB = new Date(b.publication_date);
                return this.sort === 'desc' ? dateB - dateA : dateA - dateB;
            });
        },

        get totalPages() {
            return Math.ceil(this.filteredPosts.length / this.perPage);
        },

        get paginatedPosts() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredPosts.slice(start, start + this.perPage);
        },

        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                this.$nextTick(() => {
                    const el = document.getElementById('posts-section');
                    const y = el.getBoundingClientRect().top + window.scrollY - 100;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                });
            }
        },

        stripHtml(content) {
            return content.replace(/<[^>]*>?/gm, '').substring(0, 150) + '...';
        },

        init() {
            fetch(apiUrl)
                .then(res => res.json())
                .then(data => this.posts = data);
        }
    }
}
</script>
@endsection