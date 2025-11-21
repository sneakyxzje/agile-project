<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BikoDuo')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        (function() {
            if (localStorage.getItem('theme') === 'dark' || 
               (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <style>
        body {
            padding-top: 64px;
            padding-left: 0;
            transition: all 0.3s ease;
        }

        @media (min-width: 768px) {
            body {
                padding-left: 280px;
            }
        }

        .main-content {
            min-height: calc(100vh - 64px);
            transition: all 0.3s ease;
        }

        .sidebar-container {
            display: none;
        }

        @media (min-width: 768px) {
            .sidebar-container {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f1f2f3] dark:bg-[#1c1d1f] transition-colors duration-300">
    @include('components.sidebar')
    <main class="main-content">
        @yield('content')
    </main>
    <script src="/project/public/js/theme.js"></script>
    @stack('scripts')
    @include('components.chat')
    <button id="main-chat-toggle" class="fixed bottom-6 right-6 w-14 h-14 bg-[#f48024] hover:bg-[#d97018] text-white rounded-full shadow-lg flex items-center justify-center transition-transform hover:scale-110 z-40 group">
    <i class="fas fa-comment-dots text-2xl group-hover:animate-pulse"></i>
    <audio id="notif-sound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>
    <span id="main-unread-badge" class="hidden absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full border-2 border-white">
        0
    </span>
</button>
</body>
</html>