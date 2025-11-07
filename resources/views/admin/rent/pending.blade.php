@extends('layouts.admin')

@section('title', 'Duyệt Đơn Thuê')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-[#232629] dark:text-[#e3e6e8]">Đơn Thuê Đang Chờ</h1>
        <p class="text-sm text-[#525960] dark:text-[#9fa6ad] mt-1">Danh sách các đơn thuê cần BPlayer xử lý.</p>
    </div>

    <div class="bg-white dark:bg-[#2d2d2d] rounded-xl shadow-md overflow-hidden border border-[#d6d9dc] dark:border-[#3f4042]">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-[#525960] dark:text-[#9fa6ad]">
                <thead class="text-xs text-[#232629] dark:text-[#e3e6e8] uppercase bg-[#f8f9f9] dark:bg-[#232426]">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID Đơn</th>
                        <th scope="col" class="px-6 py-4">Người Thuê</th>
                        <th scope="col" class="px-6 py-4">BPlayer</th>
                        <th scope="col" class="px-6 py-4">Số tiền</th>
                        <th scope="col" class="px-6 py-4">Ngày tạo</th>
                        <th scope="col" class="px-6 py-4">Trạng thái</th>
                        <th scope="col" class="px-6 py-4 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingRents as $rent)
                    <tr class="border-b border-[#d6d9dc] dark:border-[#3f4042] hover:bg-[#f8f9f9] dark:hover:bg-[#3a3a3a]">
                        <td class="px-6 py-4 font-bold text-[#232629] dark:text-white">#{{ $rent['id'] }}</td>
                        
                        <td class="px-6 py-4">
                            <a href="/project/admin/users/edit/{{ $rent['user_id'] }}" class="flex items-center gap-3 group">
                                <img src="/project/{{ $rent['user_avatar'] ?? 'public/images/default.png' }}" alt="User Avatar" class="w-9 h-9 rounded-full object-cover">
                                <div>
                                    <div class="font-semibold text-[#232629] dark:text-white group-hover:text-[#f48024]">{{ $rent['user_fullname'] }}</div>
                                    <div class="text-xs">ID: {{ $rent['user_id'] }}</div>
                                </div>
                            </a>
                        </td>
                        
                        <td class="px-6 py-4">
                             <a href="/project/bplayer/{{ $rent['bplayer_id'] }}" target="_blank" class="flex items-center gap-3 group">
                                <img src="/project/{{ $rent['bplayer_image'] }}" alt="BPlayer Avatar" class="w-9 h-9 rounded-full object-cover">
                                <div>
                                    <div class="font-semibold text-[#232629] dark:text-white group-hover:text-[#f48024]">{{ $rent['bplayer_nickname'] }}</div>
                                     <div class="text-xs">ID: {{ $rent['bplayer_id'] }}</div>
                                </div>
                            </a>
                        </td>

                        <td class="px-6 py-4 font-semibold text-green-500">{{ number_format($rent['amount']) }}💎</td>
                        
                        <td class="px-6 py-4">{{ $rent['created_at'] }}</td>

                        @if($rent['status'] === 'pending')
                        <td class="px-6 py-4">Đang chờ</td>
                        @endif
                        <td class="px-6 py-4 text-center">
                            <form action="/project/admin/rents/cancel/{{ $rent['id'] }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn này và hoàn tiền cho người dùng không?');">
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 rounded-full">
                                    Hủy & Hoàn tiền
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-base">Không có đơn thuê nào đang chờ xử lý!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection