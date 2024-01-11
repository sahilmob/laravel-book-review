@extends('layouts.app')
@section('content')
    <h1 class="mb-10 text-2xl">Books</h1>

    <form method="GET" accept="{{ route('books.index') }}" class="flex justify-between mb-4">
        <input type="text" name="title" value="{{ request('title') }}" placeholder="Search by title" class="input mr-4" />
        <input type="hidden" name="filter" value="{{ request('filter') }}" />
        <div class="flex items-center">
            <button type="submit" class="btn mr-2">
                Search
            </button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">
                Clear
            </a>
        </div>
    </form>

    <div class="filter-container flex mb-4">
        @php
            $filters = [
                '' => 'Latest',
                'popular_last_month' => 'Popular last month',
                'popular_last_6months' => 'Popular last 6 months',
                'highest_rated_last_month' => 'Highest rated last month',
                'highest_rated_last_6months' => 'Highest rated last 6 months',
            ];
        @endphp

        @foreach ($filters as $key => $label)
            <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}"
                class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <ul>
        @forelse ($books as $book)
            <li class="mb-4">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
                            <span class="book-author">by {{ $book->author }}</span>
                        </div>
                        <div>
                            {{-- <div class="book-rating">
                                {{ number_format($book->reviews_avg_rating, 1) }}
                            </div> --}}
                            <x-star-rating rating="{{ number_format($book->reviews_avg_rating, 1) }}" />
                            <div class="book-review-count">
                                out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection
