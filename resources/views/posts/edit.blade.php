@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Post</h1>
        <p class="mt-2 text-gray-600">Update your post content</p>
    </div>

    <div class="card p-6">
        <form action="{{ route('posts.update', $post) }}" method="POST">
            @csrf
            @method('PATCH')

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="label">Title <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title', $post->title) }}"
                    class="input w-full @error('title') border-red-500 @enderror" 
                    required>
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
                    class="input w-full @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="label">Content <span class="text-red-500">*</span></label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="15"
                    class="input w-full @error('content') border-red-500 @enderror" 
                    required>{{ old('content', $post->content) }}</textarea>
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
                        {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Published</span>
                </label>
                @if ($post->published_at)
                    <p class="mt-1 text-sm text-gray-500">
                        Published on {{ $post->published_at->format('F d, Y \a\t g:i A') }}
                    </p>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('posts.show', $post) }}" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
