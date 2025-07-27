@extends('layouts.master')

@section('title', 'Edit Post')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="bg-white p-8 rounded-xl shadow-md border border-[#BCE4E0]">
        <h2 class="text-3xl font-bold text-center text-[#1A3D3F] mb-8">Edit Your Story</h2>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('blogpost.update', $post->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-semibold text-[#1A3D3F] mb-1">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm bg-[#F7FBFA] text-[#1A3D3F]"
                    placeholder="Post title" required>
            </div>

            {{-- Content --}}
            <div>
                <label for="content" class="block text-sm font-semibold text-[#1A3D3F] mb-1">Content</label>
                <textarea name="content" id="content"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm bg-[#F7FBFA] text-[#1A3D3F]" rows="18">
                    {{ old('content', $post->content) }}
                </textarea>
            </div>

            {{-- Featured Image --}}
            <div>
                <label for="featured_image" class="block text-sm font-semibold text-[#1A3D3F] mb-1">Featured Image</label>
                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                    class="block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-[#BCE4E0] file:text-[#1A3D3F] hover:file:bg-[#a7d3cc]">
                @if ($post->featured_image_url)
                    <p class="text-sm mt-2 text-[#1A3D3F]">Current: <a href="{{ asset($post->featured_image_url) }}" class="underline" target="_blank">View Image</a></p>
                @endif
            </div>

            {{-- Categories --}}
            <div>
                <label class="block text-sm font-semibold text-[#1A3D3F] mb-2">Categories</label>
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($categories as $category)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                class="text-[#3B7D75] mr-2"
                                {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <span class="text-sm text-[#1A3D3F]">{{ $category->category_name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Tags --}}
            <div>
                <label class="block text-sm font-semibold text-[#1A3D3F] mb-2">Tags</label>
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($tags as $tag)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                class="text-[#3B7D75] mr-2"
                                {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <span class="text-sm text-[#1A3D3F]">{{ $tag->tag_name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-semibold text-[#1A3D3F] mb-1">Post Status</label>
                <select name="status" id="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm bg-[#F7FBFA] text-[#1A3D3F]">
                    <option value="D" {{ old('status', $post->status) == 'D' ? 'selected' : '' }}>Draft</option>
                    <option value="P" {{ old('status', $post->status) == 'P' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="text-center pt-4">
                <button type="submit"
                    class="bg-[#BCE4E0] hover:bg-[#a7d3cc] text-[#1A3D3F] font-semibold py-2 px-6 rounded-lg transition-all duration-200">
                    Update Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <style>
        .ck-editor__editable_inline {
            min-height: 500px;
            max-height: 800px;
        }
    </style>
@endsection
