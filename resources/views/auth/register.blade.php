@extends('layouts.master')

@section('title', 'Register')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-[#F0FAF9] px-4">
    <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-md border border-[#BCE4E0]">
        <h2 class="text-3xl font-bold mb-6 text-center text-[#1A3D3F]">Create an Account</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-[#1A3D3F] mb-1">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-2 rounded-lg border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} focus:border-[#3B7D75] focus:ring-[#3B7D75] focus:outline-none focus:ring-1 text-sm bg-[#F7FBFA] text-[#1A3D3F]"
                       placeholder="John Doe" required>
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-[#1A3D3F] mb-1">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="w-full px-4 py-2 rounded-lg border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} focus:border-[#3B7D75] focus:ring-[#3B7D75] focus:outline-none focus:ring-1 text-sm bg-[#F7FBFA] text-[#1A3D3F]"
                       placeholder="you@example.com" required>
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-[#1A3D3F] mb-1">Password</label>
                <input type="password" id="password" name="password"
                       class="w-full px-4 py-2 rounded-lg border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} focus:border-[#3B7D75] focus:ring-[#3B7D75] focus:outline-none focus:ring-1 text-sm bg-[#F7FBFA] text-[#1A3D3F]"
                       placeholder="Enter a strong password" required>
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-[#1A3D3F] mb-1">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="w-full px-4 py-2 rounded-lg border {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-300' }} focus:border-[#3B7D75] focus:ring-[#3B7D75] focus:outline-none focus:ring-1 text-sm bg-[#F7FBFA] text-[#1A3D3F]"
                       placeholder="Retype your password" required>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between">
                <button type="submit"
                        class="bg-[#BCE4E0] hover:bg-[#a7d3cc] text-[#1A3D3F] font-semibold py-2 px-6 rounded-lg transition">
                    Register
                </button>
                <a href="{{ route('login') }}" class="text-sm text-[#1A3D3F] hover:underline">
                    Already have an account?
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
