@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Welcome to our Blog</h1>
    <p class="mb-8 text-gray-600">Your source for travel inspiration.</p>

    <div 
        x-data="{
            activeSlide: 0,
            slides: {{ count($featuredPosts) }},
            showModal: false,
            modalPost: {},
            init() {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slides;
                }, 5000);
            },
            openModal(post) {
                this.modalPost = post;
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
                this.modalPost = {};
            }
        }" 
        class="relative"
    >
        <!-- Carousel -->
        <div class="overflow-hidden">
            <div 
                class="flex transition-transform duration-500"
                :style="'transform: translateX(-' + activeSlide * 100 + '%)'"
            >
                @foreach ($featuredPosts as $index => $post)
                    <div class="min-w-full flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden">
                        <!-- Left Panel: Image -->
                        <div class="md:w-1/2 w-full">
                            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="w-full h-64 md:h-full object-cover">
                        </div>
                        <!-- Right Panel: Content -->
                        <div class="md:w-1/2 w-full flex flex-col justify-center p-6">
                            <h2 class="text-2xl font-bold mb-2">{{ $post['title'] }}</h2>
                            <p class="text-gray-600 mb-4">{{ $post['excerpt'] }}</p>
                            <button 
                                @click="openModal(@js($post))"
                                class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                            >
                                Read More
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Left Arrow -->
        <button
            @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1"
            class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-white/70 hover:bg-white rounded-full p-2 shadow">
            &#8592;
        </button>

        <!-- Right Arrow -->
        <button
            @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1"
            class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-white/70 hover:bg-white rounded-full p-2 shadow">
            &#8594;
        </button>

        <!-- Dots Indicator -->
        <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <template x-for="i in slides" :key="i">
                <button
                    @click="activeSlide = i - 1"
                    :class="{
                        'w-3 h-3 rounded-full bg-blue-600': activeSlide === i - 1,
                        'w-3 h-3 rounded-full bg-gray-400': activeSlide !== i - 1
                    }"
                ></button>
            </template>
        </div>

        <!-- Fullscreen Modal -->
        <div
            x-show="showModal"
            x-transition
            class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
        >
            <div class="bg-white max-w-3xl w-full rounded-lg shadow-lg overflow-y-auto max-h-screen relative">
                <button @click="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
                <div class="p-6">
                    <h2 class="text-3xl font-bold mb-4" x-text="modalPost.title"></h2>
                    <img :src="modalPost.image" alt="" class="w-full h-96 object-cover rounded mb-4">
                    <div 
                        class="text-gray-700 space-y-4"
                        x-html="modalPost.content"
                    ></div>

                    <style>
                        .text-gray-700 p {
                            @apply text-justify mb-4 leading-relaxed indent-8;
                        }
                    </style>
            </div>
        </div>
    </div>
@endsection
