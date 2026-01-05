@extends('layouts.app')

@section('title', 'Create New Post')

@section('content')
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Create New Post</h1>
        <p class="mt-2 text-gray-600">Share your thoughts with the world</p>
    </div>

    <div class="card p-6">
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="label">Title <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title') }}"
                    class="input w-full @error('title') border-red-500 @enderror" 
                    required 
                    autofocus
                    placeholder="Enter your post title">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div class="mb-6">
                <label for="excerpt" class="label">Excerpt</label>
                <textarea 
                    name="excerpt" 
                    id="excerpt" 
                    rows="2"
                    class="input w-full @error('excerpt') border-red-500 @enderror"
                    placeholder="Short description (optional, will be auto-generated if empty)">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from content</p>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="label">Content <span class="text-red-500">*</span></label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="15"
                    class="input w-full @error('content') border-red-500 @enderror" 
                    required
                    placeholder="Write your post content here...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Publish Status -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="is_published" 
                        value="1"
                        {{ old('is_published') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Publish immediately</span>
                </label>
                <p class="mt-1 text-sm text-gray-500">Leave unchecked to save as draft</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard') }}" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Create Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
