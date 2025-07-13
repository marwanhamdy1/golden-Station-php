<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoldenStation - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-primary">
                            <i class="fas fa-gem mr-2"></i>GoldenStation
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
                    <div class="relative">
                        <button class="flex items-center text-gray-700 hover:text-primary focus:outline-none">
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin&background=1e40af&color=fff" alt="Profile">
                            <span class="ml-2">Admin</span>
                            <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>



    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg min-h-screen">
            <div class="p-4">
                <nav class="space-y-2">
                      <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-primary bg-blue-50 rounded-lg">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('agents.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-users mr-3"></i>
                        Agents
                    </a>
                    <a href="{{ route('vendors.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-store mr-3"></i>
                        Vendors
                    </a>
                    <a href="{{ route('branches.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-map-marker-alt mr-3"></i>
                        Branches
                    </a>
                    <a href="{{ route('visits.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-calendar-check mr-3"></i>
                        Visits
                    </a>
                    <a href="{{ route('packages.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-box mr-3"></i>
                        Packages
                    </a>
                    <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Reports
                    </a>
                    @if(app()->environment('local'))
                    <a href="{{ route('telescope') }}" target="_blank" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-telescope mr-3"></i>
                        Telescope
                    </a>
                    @endif
                    <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-cog mr-3"></i>
                        Settings
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
