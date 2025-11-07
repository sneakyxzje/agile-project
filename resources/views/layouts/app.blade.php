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
</body>
</html>