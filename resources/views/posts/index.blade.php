@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Blog</h1>
        <p class="text-lg text-gray-600">Discover our latest articles and insights</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($posts as $post)
            <article class="card hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ $post->author->name }}</span>
                        <span class="mx-2">·</span>
                        <time>{{ $post->published_at->format('M d, Y') }}</time>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-900 mb-2 hover:text-primary-600">
                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                    </h2>

                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ $post->excerpt }}
                    </p>

                    <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                        Read more
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-3 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mt-4 text-gray-500 text-lg">No posts published yet.</p>
                @auth
                    <a href="{{ route('posts.create') }}" class="mt-4 inline-block btn-primary">
                        Create the first post
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($posts->hasPages())
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
