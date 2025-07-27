<div class="grid grid-cols-2 gap-4">
    @foreach ($categories as $category)
        @php
            $categoryColor = '';
            $categoryHoverColor = '';

            switch ($category->category_name) {
                case 'Travel':
                    $categoryColor = 'bg-[#3B7D75]';
                    $categoryHoverColor = 'hover:bg-[#326861]';
                    break;
                case 'Food & Drink':
                    $categoryColor = 'bg-[#D97171]';
                    $categoryHoverColor = 'hover:bg-[#c55d5d]';
                    break;
                case 'Culture':
                    $categoryColor = 'bg-[#AF7AC5]';
                    $categoryHoverColor = 'hover:bg-[#9b62b4]';
                    break;
                case 'Adventure':
                    $categoryColor = 'bg-[#F5A623]';
                    $categoryHoverColor = 'hover:bg-[#db931f]';
                    break;
                case 'Photography':
                    $categoryColor = 'bg-[#5D6D7E]';
                    $categoryHoverColor = 'hover:bg-[#4a5965]';
                    break;
                case 'Hidden Gems':
                    $categoryColor = 'bg-[#69B899]';
                    $categoryHoverColor = 'hover:bg-[#56a486]';
                    break;
                case 'Seasonal':
                    $categoryColor = 'bg-[#F0C75E]';
                    $categoryHoverColor = 'hover:bg-[#dcb14f]';
                    break;
                default:
                    $categoryColor = 'bg-[#A0BEB8]';
                    $categoryHoverColor = 'hover:bg-[#8eada7]';
                    break;
            }
        @endphp

        <a href="#"
           data-category="{{ $category->category_name }}"
           class="category-btn w-full text-white font-semibold py-3 px-5 rounded-lg text-center {{ $categoryColor }} {{ $categoryHoverColor }} transition duration-200 ease-in-out">
            {{ $category->category_name }}
        </a>
    @endforeach
</div>
