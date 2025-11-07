@extends('layouts.admin')

@section('title', 'Quản lý BPlayer')

@section('content')
<div class="min-h-screen p-6 transition-colors duration-300">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-[#232629] dark:text-[#e3e6e8]">Quản lý BPlayer</h1>
            <p class="text-sm text-[#525960] dark:text-[#9fa6ad] mt-1">Danh sách tất cả BPlayer trong hệ thống.</p>
        </div>
        <div>
            <a href="/project/admin/bplayers/pending" class="inline-flex items-center mt-4 sm:mt-0 px-4 py-2 bg-[#f48024] text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-orange-600 transition-colors">
                <i class="fas fa-user-check mr-2"></i>
                Duyệt đăng ký mới
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-[#2d2d2d] rounded-xl shadow-md overflow-hidden border border-[#d6d9dc] dark:border-[#3f4042]">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-[#525960] dark:text-[#9fa6ad]">
                <thead class="text-xs text-[#232629] dark:text-[#e3e6e8] uppercase bg-[#f8f9f9] dark:bg-[#232426]">
                    <tr>
                        <th scope="col" class="px-6 py-4">BPlayer</th>
                        <th scope="col" class="px-6 py-4">Games</th>
                        <th scope="col" class="px-6 py-4">Giá thuê / giờ</th>
                        <th scope="col" class="px-6 py-4">Ngày tham gia</th>
                        <th scope="col" class="px-6 py-4">Trạng thái</th>
                        <th scope="col" class="px-6 py-4 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bPlayerList as $bplayer)
                    <tr class="border-b border-[#d6d9dc] dark:border-[#3f4042] hover:bg-[#f8f9f9] dark:hover:bg-[#3a3a3a]">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="/project/{{ $bplayer['main_image'] }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <div class="font-bold text-[#232629] dark:text-white">{{ $bplayer['nickname'] }}</div>
                                    <div class="text-xs">{{ $bplayer['fullname'] }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach(json_decode($bplayer['games'], true) as $game)
                                    <span class="game-badge">{{ strtoupper($game) }}</span>
                                @endforeach
                            </div>
                        </td>

                        <td class="px-6 py-4 font-semibold text-[#232629] dark:text-white">{{ number_format($bplayer['price_per_hour']) }}💎</td>
                        
                        <td class="px-6 py-4">{{ date('d/m/Y', strtotime($bplayer['created_at'])) }}</td>

                        <td class="px-6 py-4">
                            @if($bplayer['status'] == 'approved')
                                <span class="status-badge bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Đã duyệt</span>
                            @elseif($bplayer['status'] == 'pending')
                                <span class="status-badge bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">Chờ duyệt</span>
                             @elseif($bplayer['status'] == 'suspended')
                                <span class="status-badge bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Đã khóa</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($bplayer['status'] == 'pending')
                                <form action="/project/admin/bplayers/handle/{{ $bplayer['id'] }}" method="POST" class="flex items-center justify-end gap-2">
                                    <button type="submit" name="action" value="reject" class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 rounded-full">
                                        Từ chối
                                    </button>
                                    <button type="submit" name="action" value="approve" class="px-3 py-1.5 text-xs font-semibold text-green-600 bg-green-100 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 rounded-full">
                                        Chấp nhận
                                    </button>
                                </form>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-base">
                            Chưa có BPlayer nào trong hệ thống.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .status-badge { @apply px-2.5 py-1 text-xs font-bold rounded-full; }
    .game-badge { @apply px-2 py-0.5 text-xs font-medium rounded bg-[#e3e6e8] dark:bg-[#3a3a3a] text-[#525960] dark:text-[#9fa6ad]; }
</style>
@endpush