<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GoldenStation Dashboard</title>
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
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg border-t-4 border-primary">
        <div class="flex flex-col items-center mb-6">
            <i class="fas fa-gem text-4xl text-primary mb-2"></i>
            <h1 class="text-2xl font-bold text-primary">GoldenStation Login</h1>
            <p class="text-gray-500 mt-1">Sign in to your dashboard</p>
        </div>
        @if(session('error'))
            <div class="mb-4 text-danger text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-danger text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input id="email" name="email" type="email" required autofocus class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder="you@example.com">
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input id="password" name="password" type="password" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder="********">
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                </div>
                <a href="#" class="text-sm text-primary hover:underline">Forgot password?</a>
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-primary text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                <i class="fas fa-sign-in-alt mr-2"></i> Sign In
            </button>
        </form>
    </div>
</body>
</html>
