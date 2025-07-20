{{--Landing Page --}}
<!DOCTYPE html>
<html lang="en" data-theme="dark" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>memo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="h-full bg-neutral-900">
    <div class="container">
        @if (Route::has('login'))
            <nav class="flex justify-between px-20 py-10">
                <h1 class="text-4xl font-bold">mem<span class="text-primary">:</span>o</h1>
                @auth
                    <a href="{{ url('/myday') }}" class="btn btn-lg btn-outline btn-primary px-8">
                        lets' plan
                    </a>
                @else
                    <div class="flex gap-3">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-lg btn-outline btn-primary px-8"> Register </a>
                        @endif
                        <a href="{{ route('login') }}" class="btn btn-lg  btn-primary px-8"> Login</a>
                    </div>
                @endauth
            </nav>
        @endif
        <main>
            <div class="mt-10 text-center flex-col ">
                <h1 class="text-6xl font-bold mt-20 mb-10">The Simplest Way to</h1>
                <h1 class="text-6xl font-bold">Get Things Done</h1>
                <img src="/image/garisbawah.png" alt="decoration" class="absolute top-90 right-125 -z-10">
                <p class="font-medium text-lg text-gray-500 mt-10">Don't let tasks pile up. Prioritize, set smart
                    reminders, and</p>
                <p class="font-medium text-lg text-gray-500">get things done seamlessly.</p>
                <a href="{{ Auth::check() ? url('/myday') : route('register') }}" class="btn btn-primary btn-xl mt-15 text-xl rounded-4xl">Organize Your Life
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.8" d="m19 12l-6-6m6 6l-6 6m6-6H5" />
                    </svg>
                </a>
            </div>
        </main>
    </div>
</body>

</html>
