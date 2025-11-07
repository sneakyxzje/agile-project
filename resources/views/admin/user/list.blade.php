@extends('layouts.admin')

@section('title', 'Quản lý Người dùng')
@section('content')
<div class="min-h-screen p-6 transition-colors duration-300">
    @php
        $successMessage = session_flash('success');
        $errorMessage = session_flash('error');
        $infoMessage = session_flash('info');
    @endphp

    @if ($successMessage)
        <div class="mb-4 p-4 rounded-lg border-l-4 flex items-start bg-green-100 dark:bg-green-900/30 border-green-500 text-green-700 dark:text-green-300" role="alert">
            <div class="flex-shrink-0"><i class="fas fa-check-circle text-lg"></i></div>
            <div class="ml-3 flex-grow"><p class="font-semibold">{{ $successMessage }}</p></div>
            <button type="button" class="ml-4 p-1.5 rounded-full hover:bg-black/10" onclick="this.parentElement.style.display='none'"><i class="fas fa-times text-sm"></i></button>
        </div>
    @endif
    @if ($errorMessage)
        <div class="mb-4 p-4 rounded-lg border-l-4 flex items-start bg-red-100 dark:bg-red-900/30 border-red-500 text-red-700 dark:text-red-300" role="alert">
            <div class="flex-shrink-0"><i class="fas fa-exclamation-triangle text-lg"></i></div>
            <div class="ml-3 flex-grow"><p class="font-semibold">{{ $errorMessage }}</p></div>
            <button type="button" class="ml-4 p-1.5 rounded-full hover:bg-black/10" onclick="this.parentElement.style.display='none'"><i class="fas fa-times text-sm"></i></button>
        </div>
    @endif
    @if ($infoMessage)
         <div class="mb-4 p-4 rounded-lg border-l-4 flex items-start bg-blue-100 dark:bg-blue-900/30 border-blue-500 text-blue-700 dark:text-blue-300" role="alert">
            <div class="flex-shrink-0"><i class="fas fa-info-circle text-lg"></i></div>
            <div class="ml-3 flex-grow"><p class="font-semibold">{{ $infoMessage }}</p></div>
            <button type="button" class="ml-4 p-1.5 rounded-full hover:bg-black/10" onclick="this.parentElement.style.display='none'"><i class="fas fa-times text-sm"></i></button>
        </div>
    @endif
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-[#232629] dark:text-[#e3e6e8]">Quản lý Người dùng</h1>
            <p class="text-sm text-[#525960] dark:text-[#9fa6ad] mt-1">Danh sách tất cả người dùng trong hệ thống.</p>
        </div>
        <div>
            <a href="/project/admin/users/add" class="inline-flex items-center mt-4 sm:mt-0 px-4 py-2 bg-[#f48024] text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-orange-600 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Thêm User mới
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-[#2d2d2d] rounded-xl shadow-md overflow-hidden border border-[#d6d9dc] dark:border-[#3f4042]">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-[#525960] dark:text-[#9fa6ad]">
                <thead class="text-xs text-[#232629] dark:text-[#e3e6e8] uppercase bg-[#f8f9f9] dark:bg-[#232426]">
                    <tr>
                        <th scope="col" class="px-6 py-4">Người dùng</th>
                        <th scope="col" class="px-6 py-4">Vai trò</th>
                        <th scope="col" class="px-6 py-4">Nickname BPlayer</th>
                        <th scope="col" class="px-6 py-4">Số dư</th>
                        <th scope="col" class="px-6 py-4 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allUsers as $user)
                    <tr class="border-b border-[#d6d9dc] dark:border-[#3f4042] hover:bg-[#f8f9f9] dark:hover:bg-[#3a3a3a]">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="/project/{{ $user['avatar'] ?? 'public/images/default.png' }}" alt="User Avatar" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <div class="font-bold text-[#232629] dark:text-white">{{ $user['fullname'] }}</div>
                                    <div class="text-xs">{{ $user['email'] }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            @if($user['role'] == 'admin')
                                <span class="role-badge bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Admin</span>
                            @elseif($user['role'] == 'bplayer')
                                <span class="role-badge bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">BPlayer</span>
                            @else
                                <span class="role-badge bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">User</span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4">
                            @if (!empty($user['nickname']))
                                <span class="font-semibold text-[#232629] dark:text-white">{{ $user['nickname'] }}</span>
                            @else
                                <span class="text-gray-400/70">--</span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 font-semibold text-green-500">{{ number_format($user['diamond']) }}💎</td>
                        
                        <td class="px-6 py-4 text-right">
                            <a href="/project/admin/users/edit/{{ $user['id'] }}" class="font-medium text-[#f48024] hover:underline mr-4">Sửa</a>
                            <a href="/project/admin/users/lock/{{ $user['id'] }}" class="font-medium text-red-500 hover:underline">Khóa</a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-base">
                            Không có người dùng nào trong hệ thống.
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
    .role-badge { @apply px-2.5 py-1 text-xs font-bold rounded-full; }
</style>
@endpush