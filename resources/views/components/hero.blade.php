<section class="bg-[#1A3D3F] py-12">
  <div class="text-center max-w-4xl mx-auto px-4">
    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight text-white mb-4">
      Welcome to <span class="text-[#7AD1C2]">The Soft Horizon</span>
    </h1>
    <p class="text-base sm:text-lg text-gray-200 max-w-2xl mx-auto mb-6">
      Discover stories of <span class="font-semibold text-white">travel</span>, 
      <span class="font-semibold text-white">culture</span>, 
      <span class="font-semibold text-white">food</span>, and hidden gems from around the world.
    </p>

    <div class="flex flex-col sm:flex-row justify-center gap-3 text-sm font-medium">
      <a href="/blogs"
         class="inline-block bg-[#7AD1C2] hover:bg-[#6bb8ad] text-[#1A3D3F] px-5 py-2 rounded-full shadow-sm transition duration-200">
        View Blogs
      </a>
      <a href="{{ route('blogpost.create') }}"
         class="inline-block border border-[#7AD1C2] hover:bg-[#7AD1C2] hover:text-[#1A3D3F] text-white px-5 py-2 rounded-full shadow-sm transition duration-200">
        Share Your Story
      </a>
    </div>
  </div>
</section>
