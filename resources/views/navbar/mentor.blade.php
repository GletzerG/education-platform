@extends('layout.template')

@section('content')
    @include('layout.navbar')

    <div class="bg-gray-100 font-sans min-h-screen">
        <div class="container mx-auto px-4 py-12">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Mentors</h1>

            @php
                $mentors = [
                    (object) [
                        'id' => 1,
                        'name' => 'John Doe',
                        'expertise' => 'Web Development',
                        'rating' => 4.8,
                        'photo' => 'https://via.placeholder.com/300x200',
                        'description' => 'Expert in modern web technologies and frameworks with over 10 years of teaching experience.'
                    ],
                    (object) [
                        'id' => 2,
                        'name' => 'Jane Smith',
                        'expertise' => 'UI/UX Design',
                        'rating' => 4.6,
                        'photo' => 'https://via.placeholder.com/300x200',
                        'description' => 'Specialist in creating intuitive user interfaces and enhancing user experience.'
                    ],
                    (object) [
                        'id' => 3,
                        'name' => 'Michael Lee',
                        'expertise' => 'Data Science',
                        'rating' => 4.9,
                        'photo' => 'https://via.placeholder.com/300x200',
                        'description' => 'Data scientist passionate about machine learning and AI-driven solutions.'
                    ]
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($mentors as $mentor)
                    <div
                        class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl">
                        <img src="{{ $mentor->photo }}" alt="{{ $mentor->name }}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $mentor->name }}</h2>
                            <p class="text-gray-600 text-sm mt-1">{{ $mentor->expertise }}</p>

                            {{-- Rating --}}
                            <div class="flex items-center mt-2">
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($mentor->rating))
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                <path
                                                    d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                            </svg>
                                        @elseif ($i - $mentor->rating < 1 && $i - $mentor->rating > 0)
                                            {{-- Setengah bintang --}}
                                            <svg class="w-5 h-5" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient id="half">
                                                        <stop offset="50%" stop-color="gold" />
                                                        <stop offset="50%" stop-color="#e5e7eb" />
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half)"
                                                    d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20">
                                                <path
                                                    d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-gray-600 text-sm">({{ $mentor->rating }}/5)</span>
                            </div>

                            <p class="text-gray-600 mt-4">{{ $mentor->description }}</p>

                            <a href="{{ route('mentor.profile', $mentor->id) }}"
                                class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                View Profile
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection