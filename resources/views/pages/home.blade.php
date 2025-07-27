@extends('layouts.master')

@section('title', 'Home')

@section('content')
<div class="bg-[#E6F2F0] text-[#1A3D3F]">

    {{-- Hero Section --}}
    <section class="py-20 bg-[#1A3D3F] text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @include('components.hero')
        </div>
    </section>

    {{-- Featured Posts --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-[#1A3D3F]">Featured Posts</h2>
                <p class="text-gray-600">Discover handpicked stories worth your time</p>
            </div>
            @include('components.featured-carousel', ['featuredPosts' => $featuredPosts])
        </div>
    </section>

    {{-- Main Section --}}
    <section class="py-16 bg-[#F0FAF9]" id="recent-posts">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-12">

            {{-- Recent or Filtered Posts --}}
            <div class="md:col-span-2">
                <div class="mb-8" id="recent-posts-title-block">
                    <h2 class="text-3xl font-bold text-[#1A3D3F] mb-2" id="recent-posts-title">
                        {{ !empty($selectedCategory) ? 'Posts in "' . $selectedCategory . '"' : 'Recent Posts' }}
                    </h2>
                    <p class="text-gray-600" id="recent-posts-subtitle">
                        {{ !empty($selectedCategory) ? 'Filtered by category: ' . $selectedCategory : 'Catch up on our latest updates and stories' }}
                    </p>

                    <a href="{{ route('home') }}"
                        id="category-reset-btn"
                        class="mt-2 text-sm text-[#1A3D3F] hover:underline category-reset {{ empty($selectedCategory) ? 'hidden' : '' }}">
                        ← Clear Filter
                    </a>
                </div>

                <div id="recent-posts-content">
                    @include('components.recent-posts-pagination', ['recentPosts' => $recentPosts])
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-12">
                <div>
                    <h3 class="text-2xl font-bold text-[#1A3D3F] mb-2">Popular Posts</h3>
                    <p class="text-gray-600 mb-4">What our readers are loving this week</p>
                    @include('components.popular-posts')
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-[#1A3D3F] mb-2">Browse by Category</h3>
                    <p class="text-gray-600 mb-4">Choose a topic you’re interested in</p>
                    @include('components.category-buttons')
                </div>
            </aside>

        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const recentPostsContainer = document.getElementById('recent-posts-content');
    const recentPostsTitle = document.getElementById('recent-posts-title');
    const recentPostsSubtitle = document.getElementById('recent-posts-subtitle');
    const resetBtn = document.getElementById('category-reset-btn');

    function updateTitleAndSubtitle(category = null) {
        if (category) {
            recentPostsTitle.textContent = `Posts in "${category}"`;
            recentPostsSubtitle.textContent = `Filtered by category: ${category}`;
            resetBtn?.classList.remove('hidden');
        } else {
            recentPostsTitle.textContent = 'Recent Posts';
            recentPostsSubtitle.textContent = 'Catch up on our latest updates and stories';
            resetBtn?.classList.add('hidden');
        }
    }

    function fetchAndUpdate(url, updateHistory = true) {
        axios.get(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(response => {
            recentPostsContainer.innerHTML = response.data;

            const urlParams = new URLSearchParams(url.split('?')[1]);
            const category = urlParams.get('category');
            updateTitleAndSubtitle(category);
            
            const titleBlock = document.getElementById('recent-posts-title-block');
            if (titleBlock) {
                const yOffset = -100; // Adjust this depending on your nav height
                const y = titleBlock.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }
            
            if (updateHistory) {
                history.pushState({}, '', url);
            }
        });
    }

    document.addEventListener('click', function (e) {
        const paginationLink = e.target.closest('.pagination a');
        const categoryBtn = e.target.closest('.category-btn');
        const resetClick = e.target.closest('.category-reset');

        if (paginationLink) {
            e.preventDefault();
            fetchAndUpdate(paginationLink.href);
        }

        if (categoryBtn) {
            e.preventDefault();
            const category = categoryBtn.dataset.category;
            const url = `/?category=${encodeURIComponent(category)}`;
            fetchAndUpdate(url);
        }

        if (resetClick) {
            e.preventDefault();
            fetchAndUpdate('/');
        }
    });

    window.addEventListener('popstate', function () {
        fetchAndUpdate(location.href, false);
    });
});
</script>
@endsection
