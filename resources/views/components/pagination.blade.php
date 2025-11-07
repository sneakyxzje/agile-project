<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="mt-8 flex justify-center items-center gap-2">
        <a href="{{ $currentPage <= 1 ? '#' : '?page=' . ($currentPage - 1) }}"
           class="px-3 py-2 rounded-lg border border-[#d6d9dc] dark:border-[#3f4042] text-[#525960] dark:text-[#9fa6ad] transition-all 
                  {{ $currentPage <= 1 ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:border-[#f48024] hover:text-[#f48024]' }}">
            <i class="fas fa-chevron-left"></i>
        </a>
    
        @for ($i = 1; $i <= $totalPages; $i++)
            @php
                $showPageLink = ($i == 1 || $i == $totalPages || abs($i - $currentPage) < 2);
                $showLeftEllipsis = ($i == 2 && $currentPage > 3);
                $showRightEllipsis = ($i == $totalPages - 1 && $currentPage < $totalPages - 2);
            @endphp
    
            @if ($showLeftEllipsis || $showRightEllipsis)
                <span class="px-2 text-[#525960] dark:text-[#9fa6ad]">...</span>
            @endif
            
            @if ($showPageLink)
                @if ($i == $currentPage)
                    <button class="px-4 py-2 rounded-lg bg-[#f48024] text-white font-medium" disabled>{{ $i }}</button>
                @else
                    <a href="?page={{ $i }}" class="px-4 py-2 rounded-lg border border-[#d6d9dc] dark:border-[#3f4042] text-[#525960] dark:text-[#9fa6ad] hover:border-[#f48024] hover:text-[#f48024] transition-all">
                        {{ $i }}
                    </a>
                @endif
            @endif
        @endfor
    
        <a href="{{ $currentPage >= $totalPages ? '#' : '?page=' . ($currentPage + 1) }}"
           class="px-3 py-2 rounded-lg border border-[#d6d9dc] dark:border-[#3f4042] text-[#525960] dark:text-[#9fa6ad] transition-all 
                  {{ $currentPage >= $totalPages ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:border-[#f48024] hover:text-[#f48024]' }}">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>

</body>
</html>