<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Profile - Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-950 via-cyan-900 to-blue-700 min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white/10 backdrop-blur-lg border-b border-white/20 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-white">Dashboard Profile</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Profile Header -->
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-8 mb-8 animate-fade-in">
            <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                <div class="relative group">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                        alt="Profile"
                        class="w-32 h-32 rounded-full border-4 border-white/20 group-hover:border-white/40 transition-all duration-300 object-cover">
                </div>

                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h2>
                    <p class="text-white/70 mb-4">{{ $user->skills ? implode(', ', $user->skills) : 'Belum ada skill' }}</p>
                    <p class="text-white/60 mb-6 max-w-2xl">{{ $user->bio ?? 'Belum ada bio.' }}</p>

                    <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                        <div class="flex items-center space-x-2 text-white/60">
                            <span>{{ $user->email }}</span>
                        </div>
                        @if($user->location)
                        <div class="flex items-center space-x-2 text-white/60">
                            <span>{{ $user->location }}</span>
                        </div>
                        @endif
                        <div class="flex items-center space-x-2 text-white/60">
                            <span>Bergabung sejak {{ $user->created_at->translatedFormat('F Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <a href="{{ route('profile.edit') }}"
                        class="px-6 py-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 flex items-center space-x-2">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-8 animate-fade-in">
            <h3 class="text-xl font-bold text-white mb-6">Profile Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-white/60 text-sm font-medium mb-2">Nama Lengkap</label>
                    <p class="text-white bg-white/5 p-3 rounded-lg border border-white/10">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="block text-white/60 text-sm font-medium mb-2">Email</label>
                    <p class="text-white bg-white/5 p-3 rounded-lg border border-white/10">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="block text-white/60 text-sm font-medium mb-2">Nomor Telepon</label>
                    <p class="text-white bg-white/5 p-3 rounded-lg border border-white/10">{{ $user->phone ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-white/60 text-sm font-medium mb-2">Lokasi</label>
                    <p class="text-white bg-white/5 p-3 rounded-lg border border-white/10">{{ $user->location ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-white/60 text-sm font-medium mb-2">Bio</label>
                    <p class="text-white bg-white/5 p-3 rounded-lg border border-white/10">{{ $user->bio ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
