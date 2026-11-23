<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | 3EONE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-950 flex items-center justify-center text-white">

    <main class="text-center px-6">

        <a href="{{ url('/') }}"
            class="text-3xl font-bold tracking-wider">
            3EONE<span class="text-blue-500">.</span>
        </a>

        <div class="mt-12">
            <h1 class="text-9xl font-black text-blue-500">
                404
            </h1>

            <h2 class="text-3xl font-bold mt-4">
                Page Not Found
            </h2>

            <p class="text-slate-400 mt-4 max-w-md mx-auto">
                Oops! The page you're looking for doesn't exist,
                has been moved, or is temporarily unavailable.
            </p>

            <a href="{{ url('/') }}"
                class="inline-block mt-8 px-8 py-3 bg-blue-600
                      hover:bg-blue-700 rounded-lg font-semibold
                      transition">
                ← Back to Homepage
            </a>
        </div>

        <footer class="mt-20 text-sm text-slate-500">
            © {{ date('Y') }} 3EONE. All rights reserved.
        </footer>

    </main>

</body>

</html>