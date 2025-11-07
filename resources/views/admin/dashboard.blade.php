@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen p-6 transition-colors duration-300">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#232629] dark:text-[#e3e6e8]">Dashboard</h1>
        <p class="text-sm text-[#525960] dark:text-[#9fa6ad] mt-1">Tổng quan hệ thống</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-[#2d2d2d] rounded-lg p-6 border border-[#d6d9dc] dark:border-[#3f4042] transition-all duration-200 hover:shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#525960] dark:text-[#9fa6ad] mb-1">Tổng Users</p>
                    <h3 class="text-3xl font-bold text-[#232629] dark:text-[#e3e6e8]">{{ $allUser }}</h3>
                </div>
                <div class="w-14 h-14 rounded-full bg-[#f8f9f9] dark:bg-[#232426] flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-blue-500"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#2d2d2d] rounded-lg p-6 border border-[#d6d9dc] dark:border-[#3f4042] transition-all duration-200 hover:shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#525960] dark:text-[#9fa6ad] mb-1">Tổng BPlayer</p>
                    <h3 class="text-3xl font-bold text-[#232629] dark:text-[#e3e6e8]">{{ $allBPlayer }}</h3>
                </div>
                <div class="w-14 h-14 rounded-full bg-[#f8f9f9] dark:bg-[#232426] flex items-center justify-center">
                    <i class="fas fa-gamepad text-2xl text-purple-500"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#2d2d2d] rounded-lg p-6 border border-[#d6d9dc] dark:border-[#3f4042] transition-all duration-200 hover:shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#525960] dark:text-[#9fa6ad] mb-1">Đơn thuê chờ duyệt</p>
                    <h3 class="text-3xl font-bold text-[#232629] dark:text-[#e3e6e8]">{{ $pendingRentsCount }}</h3>
                    @if($pendingRentsCount > 0)
                    <p class="text-xs text-amber-500 mt-2"><i class="fas fa-clock"></i> Cần xử lý</p>
                    @endif
                </div>
                <div class="w-14 h-14 rounded-full bg-[#f8f9f9] dark:bg-[#232426] flex items-center justify-center">
                    <i class="fas fa-file-invoice text-2xl text-amber-500"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-[#2d2d2d] rounded-lg p-6 border border-[#d6d9dc] dark:border-[#3f4042]">
            <h3 class="text-lg font-semibold text-[#232629] dark:text-[#e3e6e8] mb-4">Hoạt động gần đây</h3>
            <div class="space-y-3">
                @forelse($latestUsers as $user)
                    <div class="flex items-center gap-3 p-3 bg-[#f8f9f9] dark:bg-[#232426] rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center"><i class="fas fa-user text-white text-xs"></i></div>
                        <div class="flex-1">
                            <p class="text-sm text-[#232629] dark:text-[#e3e6e8]">User <span class="font-bold">{{ $user['fullname'] }}</span> mới đăng ký</p>
                            <p class="text-xs text-[#525960] dark:text-[#9fa6ad]">{{ $user['created_at'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-center py-2 text-[#525960] dark:text-[#9fa6ad]">Chưa có user nào mới.</p>
                @endforelse
                
                @forelse($latestBPlayers as $bplayer)
                    <div class="flex items-center gap-3 p-3 bg-[#f8f9f9] dark:bg-[#232426] rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center"><i class="fas fa-gamepad text-white text-xs"></i></div>
                        <div class="flex-1">
                            <p class="text-sm text-[#232629] dark:text-[#e3e6e8]"><span class="font-bold">{{ $bplayer['nickname'] }}</span> mới đăng ký thành BPlayer</p>
                            <p class="text-xs text-[#525960] dark:text-[#9fa6ad]">{{ $bplayer['created_at'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-center py-2 text-[#525960] dark:text-[#9fa6ad]">Chưa có BPlayer nào mới.</p>
                @endforelse

                @forelse($latestCompletedRents as $rent)
                    <div class="flex items-center gap-3 p-3 bg-[#f8f9f9] dark:bg-[#232426] rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center"><i class="fas fa-check text-white text-xs"></i></div>
                        <div class="flex-1">
                            <p class="text-sm text-[#232629] dark:text-[#e3e6e8]">Đơn <span class="font-bold">#{{ $rent['id'] }}</span> vừa hoàn thành</p>
                            <p class="text-xs text-[#525960] dark:text-[#9fa6ad]">{{ $rent['updated_at'] }}</p>
                        </div>
                        <span class="text-sm font-bold text-green-500">{{ $rent['amount'] }}💎</span>
                    </div>
                @empty
                     <p class="text-sm text-center py-2 text-[#525960] dark:text-[#9fa6ad]">Chưa có đơn thuê nào hoàn thành gần đây.</p>
                @endforelse
            </div>
        </div>
        <div class="bg-white dark:bg-[#2d2d2d] rounded-lg p-6 border border-[#d6d9dc] dark:border-[#3f4042]">
    <h3 class="text-lg font-semibold text-[#232629] dark:text-[#e3e6e8] mb-4">Top BPlayer nổi bật</h3>
    <div class="space-y-3">

    @forelse($topBPlayers as $bplayer)
        <div class="flex items-center gap-3 p-3 bg-[#f8f9f9] dark:bg-[#232426] rounded-lg">
            <img src="/project/{{$bplayer['main_image']}}" alt="{{ $bplayer['nickname'] }}" 
                 class="w-10 h-10 rounded-full object-cover flex-shrink-0 border-2 border-white/50 dark:border-black/50">

            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-[#232629] dark:text-[#e3e6e8] truncate">{{ $bplayer['nickname'] }}</p>
                <p class="text-xs text-[#525960] dark:text-[#9fa6ad]">{{ $bplayer['rent_count'] }} đơn thuê</p>
            </div>

            <div class="text-right flex-shrink-0">
                <p class="text-sm font-bold text-green-500">{{ number_format($bplayer['total_earnings']) }}💎</p>
            </div>
        </div>
    @empty
        <p class="text-sm text-center py-10 text-[#525960] dark:text-[#9fa6ad]">Chưa có dữ liệu xếp hạng.</p>
    @endforelse
    
    </div>
</div>
    </div>
</div>

@endsection