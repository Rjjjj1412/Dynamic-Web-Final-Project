<div id="recent-posts-list">
    @foreach ($recentPosts as $post)
        <div class="bg-[#BCE4E0] rounded-lg shadow-lg p-6 mb-6 text-[#1A3D3F]">
            <div class="flex items-center space-x-6">
                
                {{-- Post Image --}}
                <div class="w-36 h-36 rounded-lg overflow-hidden border border-[#3B7D75] flex-shrink-0">
                    <img src="{{ isset($post['featured_image_url']) ? asset($post['featured_image_url']) : asset('images/default.jpg') }}"
                         alt="{{ $post->title }}"
                         class="w-full h-full object-cover">
                </div>

                {{-- Post Content --}}
                <div class="flex flex-col justify-between prose w-full">
                    
                    {{-- Date and Categories --}}
                    <div class="text-sm text-[#1A3D3F] mb-1 flex items-center flex-wrap gap-2">
                        <span>{{ \Carbon\Carbon::parse($post->publication_date)->format('F j, Y') }}</span>

                        @foreach ($post->categories as $category)
                            @php
                                $colorMap = [
                                    'Travel' => 'bg-[#3B7D75]',
                                    'Food & Drink' => 'bg-[#D97171]',
                                    'Culture' => 'bg-[#AF7AC5]',
                                    'Adventure' => 'bg-[#F5A623]',
                                    'Photography' => 'bg-[#5D6D7E]',
                                    'Hidden Gems' => 'bg-[#69B899]',
                                    'Seasonal' => 'bg-[#F0C75E] text-[#1A3D3F]',
                                ];
                                $bgColor = $colorMap[$category->category_name] ?? 'bg-[#A0BEB8]';
                            @endphp
                            <span class="text-xs font-semibold px-2 py-1 rounded text-white {{ $bgColor }}">
                                {{ $category->category_name }}
                            </span>
                        @endforeach
                    </div>

                    {{-- Title --}}
                    <h4 class="text-xl font-semibold mt-1">
                        {{ $post->title }}
                    </h4>

                    {{-- Excerpt --}}
                    @php
                        $rawContent = $post->content ?? '';
                        $doc = new DOMDocument();
                        libxml_use_internal_errors(true);
                        $doc->loadHTML(mb_convert_encoding($rawContent, 'HTML-ENTITIES', 'UTF-8'));
                        $paragraphs = $doc->getElementsByTagName('p');
                        $previewHtml = '';

                        if ($paragraphs->length > 0) {
                            $firstParagraph = $paragraphs->item(0)->textContent;
                            $sentences = preg_split('/(?<=[.?!])\s+/', trim($firstParagraph));
                            $trimmed = implode(' ', array_slice($sentences, 0, 2));
                            $previewHtml = '<p>' . e($trimmed) . '</p>';
                        }

                        libxml_clear_errors();
                    @endphp

                    <div class="text-gray-700 text-[15px] leading-relaxed space-y-2 max-h-36 overflow-hidden relative mt-2">
                        {!! $previewHtml !!}
                        <div class="absolute bottom-0 left-0 right-0 h-10 bg-gradient-to-t from-[#BCE4E0] to-transparent pointer-events-none"></div>
                    </div>

                    {{-- Read More --}}
                    <a href="{{ route('blogpost.show', $post->slug) }}"
                       class="mt-3 text-[#1A3D3F] text-sm font-medium hover:underline w-fit">
                        Read More
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Pagination --}}
<div id="recent-posts-pagination" class="mt-6 pagination">
    {{ $recentPosts->withPath(request()->url())->links('pagination::tailwind') }}
</div>
