<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoldenStation - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#64748b',
                        success: '#059669',
                        warning: '#d97706',
                        danger: '#dc2626',
                        info: '#0891b2'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50" x-data="{ userSlideOpen: false }">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <img src="{{ asset('images/logo/logo.png') }}" alt="GoldenStation Logo" class="h-20 w-auto mr-4">
                            <span class="text-lg font-semibold text-primary">GoldenStation</span>
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center text-gray-700 hover:text-primary focus:outline-none">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </button>
                    </div>
                    <!-- Language Switcher -->
                    <div class="relative">
                        <form action="" method="get" class="inline">
                            <select onchange="window.location.href=this.value" class="px-2 py-1 border rounded text-sm">
                                <option value="{{ route('lang.switch', ['locale' => 'en', 'redirect' => request()->fullUrl()]) }}" @if(app()->getLocale()=='en') selected @endif>{{ __('dashboard.english') }}</option>
                                <option value="{{ route('lang.switch', ['locale' => 'ar', 'redirect' => request()->fullUrl()]) }}" @if(app()->getLocale()=='ar') selected @endif>{{ __('dashboard.arabic') }}</option>
                            </select>
                        </form>
                    </div>
                    <div class="relative">
                        <button @click="userSlideOpen = true" class="flex items-center text-gray-700 hover:text-primary focus:outline-none">
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'User' }}&background=1e40af&color=fff" alt="Profile">
                            <span class="ml-2">{{ auth()->user()->name ?? 'User' }}</span>
                            <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- User Slide Panel -->
    <div x-show="userSlideOpen" class="fixed inset-0 z-50 flex justify-end" style="display: none;">
        <div class="fixed inset-0 bg-black bg-opacity-30" @click="userSlideOpen = false"></div>
        <div class="relative w-80 bg-white h-full shadow-xl transition-transform transform translate-x-0">
            <button @click="userSlideOpen = false" class="absolute top-4 right-4 text-gray-500 hover:text-primary focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div class="p-8 flex flex-col items-center mt-8">
                <img class="h-16 w-16 rounded-full mb-4" src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'User' }}&background=1e40af&color=fff" alt="Profile">
                <div class="font-bold text-lg text-primary mb-1">{{ auth()->user()->name ?? 'User' }}</div>
                <div class="text-sm text-gray-500 mb-6">{{ auth()->user()->email ?? '' }}</div>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full py-2 px-4 bg-primary text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 flex items-center justify-center">
                        <i class="fas fa-sign-out-alt mr-2"></i> {{ __('dashboard.logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>


    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg min-h-screen">
            <div class="p-4">
                <nav class="space-y-2">
                      <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-primary bg-blue-50 rounded-lg">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        {{ __('dashboard.dashboard') }}
                    </a>
                    <a href="{{ route('agents.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-users mr-3"></i>
                        {{ __('dashboard.agent') }}
                    </a>
                    <a href="{{ route('vendors.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-store mr-3"></i>
                        {{ __('dashboard.vendor') }}
                    </a>
                    <a href="{{ route('branches.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-map-marker-alt mr-3"></i>
                        {{ __('dashboard.branch') }}
                    </a>
                    <a href="{{ route('visits.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-calendar-check mr-3"></i>
                        {{ __('dashboard.visit_details') }}
                    </a>
                    <a href="{{ route('packages.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-box mr-3"></i>
                        {{ __('dashboard.package') }}
                    </a>
                    <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-chart-bar mr-3"></i>
                        {{ __('dashboard.actions') }}
                    </a>
                    @if(app()->environment('local'))
                    <a href="{{ route('telescope') }}" target="_blank" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-telescope mr-3"></i>
                        Telescope
                    </a>
                    @endif
                    <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-cog mr-3"></i>
                        {{ __('dashboard.settings') }}
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simple navigation link verification
            const agentsLink = document.getElementById('agents-link');
            const vendorsLink = document.getElementById('vendors-link');
            const branchesLink = document.getElementById('branches-link');

            // Ensure links are clickable
            [agentsLink, vendorsLink, branchesLink].forEach(link => {
                if (link) {
                    link.style.pointerEvents = 'auto';
                    link.style.cursor = 'pointer';
                }
            });
        });
    </script>
</body>
</html>
