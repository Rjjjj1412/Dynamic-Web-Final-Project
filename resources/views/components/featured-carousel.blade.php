<!-- Featured Posts Carousel with Swiper Arrows -->
<section 
    x-data="{
        activeSlide: 0,
        slides: {{ count($featuredPosts) }},
        init() {
            setInterval(() => {
                this.nextSlide();
            }, 6000);
        },
        nextSlide() {
            this.activeSlide = (this.activeSlide + 1) % this.slides;
        },
        prevSlide() {
            this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides;
        }
    }"
    x-init="init"
    class="relative mt-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 group"
>
    <!-- Arrows -->
    <button 
        @click="prevSlide"
        class="absolute top-1/2 left-2 -translate-y-1/2 bg-white text-gray-600 hover:text-[#1A3D3F] hover:bg-gray-100 p-2 rounded-full shadow-md z-20 opacity-0 group-hover:opacity-100 transition"
        aria-label="Previous Slide"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <button 
        @click="nextSlide"
        class="absolute top-1/2 right-2 -translate-y-1/2 bg-white text-gray-600 hover:text-[#1A3D3F] hover:bg-gray-100 p-2 rounded-full shadow-md z-20 opacity-0 group-hover:opacity-100 transition"
        aria-label="Next Slide"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Carousel Wrapper -->
    <div class="overflow-hidden bg-[#F8FAFC] rounded-xl shadow-md ring-1 ring-gray-200">
        <div 
            class="flex transition-transform duration-700 ease-in-out"
            :style="'transform: translateX(-' + activeSlide * 100 + '%)'"
        >
            @foreach ($featuredPosts as $post)
                <div class="min-w-full md:flex p-8 md:p-12 items-center gap-10 bg-white">
                    <!-- Image -->
                    <div class="flex-shrink-0 w-56 h-56 rounded-xl overflow-hidden shadow-md border border-gray-200">
                        <img 
                            src="{{isset($post['image']) ? asset($post['image']) : asset('images/default.jpg') }}" 
                            alt="{{ $post['title'] }}" 
                            class="w-full h-full object-cover"
                        >
                    </div>

                    <!-- Post Content -->
                    <div class="flex flex-col justify-center prose space-y-4 w-full">
                        
                        <!-- Optional Tag -->
                        <div class="inline-block bg-[#E6F4F1] text-[#1A3D3F] text-xs font-medium px-3 py-1 rounded-full w-fit uppercase tracking-wide">
                            {{ $post['category'] ?? 'Featured' }}
                        </div>

                        <!-- Title -->
                        <h2 class="text-3xl font-bold text-[#1A3D3F] leading-snug  transition duration-200">
                            {{ $post['title'] }}
                        </h2>

                        <!-- Excerpt -->
                        @php
                            $rawExcerpt = $post['excerpt'] ?? '';
                            $doc = new DOMDocument();
                            libxml_use_internal_errors(true);
                            $doc->loadHTML(mb_convert_encoding($rawExcerpt, 'HTML-ENTITIES', 'UTF-8'));
                            $paragraphs = $doc->getElementsByTagName('p');
                            $previewHtml = '';
                            for ($i = 0; $i < min(2, $paragraphs->length); $i++) {
                                $previewHtml .= $doc->saveHTML($paragraphs->item($i));
                            }
                            libxml_clear_errors();
                        @endphp

                        <div class="text-gray-700 text-[15px] leading-relaxed space-y-2 max-h-44 overflow-hidden relative">
                            {!! $previewHtml !!}
                            <div class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
                        </div>

                        <!-- Author & Date -->
                        <div class="text-sm text-gray-500">
                            <span class="font-semibold text-gray-700"> By {{ $post['author'] }}</span>
                            @if (!empty($post['publication_date']))
                                <span class="mx-1">·</span>
                                <span>{{ \Carbon\Carbon::parse($post['publication_date'])->format('F j, Y') }}</span>
                            @endif
                        </div>

                        <!-- Read More Button -->
                        <a href="{{ route('blogpost.show', $post['slug']) }}"
                            class="inline-block w-fit bg-[#1A3D3F] hover:bg-[#3B7D75] text-white text-sm font-semibold px-6 py-2.5 rounded-md transition">
                            Read More
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Dots -->
    <div class="flex justify-center mt-6 space-x-2">
        <template x-for="(dot, index) in slides" :key="index">
            <div 
                @click="activeSlide = index"
                :class="{
                    'bg-[#1A3D3F]': activeSlide === index,
                    'bg-gray-300': activeSlide !== index
                }"
                class="w-2.5 h-2.5 rounded-full cursor-pointer transition duration-300"
            ></div>
        </template>
    </div>
</section>
