@extends('layouts.master')
@section('title','All Blogs')

@section('content')
<div class="bg-[#F0FAF9] text-[#1A3D3F] py-12 min-h-screen">
  <div class="max-w-7xl mx-auto px-4" x-data="blogFilter()" x-init="init(); watchFilters()">

    <div id="blogs-title-block" class="text-center mb-8">
      <h1 class="text-4xl font-bold text-[#1A3D3F]">All Blog Posts</h1>
      <p class="text-gray-600">Browse the latest from our community</p>
    </div>

    <div class="flex flex-wrap gap-4 items-center mb-8">
      <input type="text"
             x-model.debounce.500ms="filters.search"
             placeholder="Search by title or author"
             class="flex-1 min-w-[180px] px-4 py-2 rounded border border-gray-300 shadow-sm">

      <select x-model="filters.category"
              class="px-4 py-2 rounded border border-gray-300 shadow-sm">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->category_name }}">{{ $cat->category_name }}</option>
        @endforeach
      </select>

      <select x-model="filters.tag"
              class="px-4 py-2 rounded border border-gray-300 shadow-sm">
        <option value="">All Tags</option>
        @foreach($tags as $tg)
          <option value="{{ $tg->tag_name }}">{{ $tg->tag_name }}</option>
        @endforeach
      </select>

      <select x-model="filters.sort"
              class="px-4 py-2 rounded border border-gray-300 shadow-sm">
        <option value="newest">Newest</option>
        <option value="oldest">Oldest</option>
      </select>

      <button @click="clearFilters"
              class="px-4 py-2 bg-[#BCE4E0] text-[#1A3D3F] font-medium rounded hover:bg-[#A6D8D2] transition">
        Reset
      </button>
    </div>

    <div class="mb-4 text-sm" x-show="anyFilter">
      <span class="font-semibold">Filtered by:</span>
      <template x-if="filters.search">
        <span class="px-2 py-1 bg-gray-200 rounded">Search: "<span x-text="filters.search"></span>"</span>
      </template>
      <template x-if="filters.category">
        <span class="px-2 py-1 bg-gray-200 rounded">Category: <span x-text="filters.category"></span></span>
      </template>
      <template x-if="filters.tag">
        <span class="px-2 py-1 bg-gray-200 rounded">Tag: <span x-text="filters.tag"></span></span>
      </template>
      <template x-if="filters.sort">
        <span class="px-2 py-1 bg-gray-200 rounded">Sort: <span x-text="filters.sort"></span></span>
      </template>
    </div>

    <div x-html="postsHtml" x-ref="postsList"></div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('blogFilter', () => ({
    filters: { search:'', category:'', tag:'', sort:'newest', page:1 },
    postsHtml: '',
    get anyFilter() {
      return this.filters.search || this.filters.category || this.filters.tag || this.filters.sort !== 'newest';
    },
    fetchPosts(pageUrl = null) {
      const params = new URLSearchParams(this.filters).toString();
      fetch(`/blogs/live?${params}`, { headers:{ 'X-Requested-With':'XMLHttpRequest' }})
        .then(r => r.text())
        .then(html => {
          this.postsHtml = html;

          this.$nextTick(() => {
            document.querySelectorAll('.pagination a').forEach(link => {
              link.addEventListener('click', e => {
                e.preventDefault();
                const url = new URL(e.target.href);
                const newPage = url.searchParams.get('page') || 1;
                this.filters.page = newPage;
                this.fetchPosts();
              });
            });

            const titleBlock = document.getElementById('blogs-title-block');
            if (titleBlock) {
              const yOffset = -100;
              const y = titleBlock.getBoundingClientRect().top + window.pageYOffset + yOffset;
              window.scrollTo({ top: y, behavior: 'smooth' });
            }
          });
        });
    },
    clearFilters() {
      this.filters = { search:'', category:'', tag:'', sort:'newest', page:1 };
      this.fetchPosts();
    },
    init() {
        const url = new URL(window.location.href);
        const searchParams = url.searchParams;

        this.filters.search = searchParams.get('search') || '';
        this.filters.category = searchParams.get('category') || '';
        this.filters.tag = searchParams.get('tag') || '';
        this.filters.sort = searchParams.get('sort') || 'newest';

        this.fetchPosts();
    },
    watchFilters() {
      this.$watch('filters.search', () => this.fetchPosts());
      this.$watch('filters.category', () => this.fetchPosts());
      this.$watch('filters.tag', () => this.fetchPosts());
      this.$watch('filters.sort', () => this.fetchPosts());
    }
  }));
});
</script>
@endsection
