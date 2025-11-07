@extends('layouts.app')

@section('title', 'Quản lý Đơn Thuê')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100 mb-6">Quản lý Đơn Thuê</h1>

    @php
        $successMessage = session_flash('success');
        $errorMessage = session_flash('error');
        $infoMessage = session_flash('info');
    @endphp
    @if ($successMessage)
        <div class="mb-4 p-4 rounded-lg border-l-4 flex items-start bg-green-100 dark:bg-green-900/30 border-green-500 text-green-700 dark:text-green-300"><div class="flex-shrink-0"><i class="fas fa-check-circle text-lg"></i></div><div class="ml-3 flex-grow"><p class="font-semibold">{{ $successMessage }}</p></div><button type="button" class="ml-4 p-1.5 rounded-full hover:bg-black/10" onclick="this.parentElement.style.display='none'"><i class="fas fa-times text-sm"></i></button></div>
    @endif
    @if ($errorMessage)
        <div class="mb-4 p-4 rounded-lg border-l-4 flex items-start bg-red-100 dark:bg-red-900/30 border-red-500 text-red-700 dark:text-red-300"><div class="flex-shrink-0"><i class="fas fa-exclamation-triangle text-lg"></i></div><div class="ml-3 flex-grow"><p class="font-semibold">{{ $errorMessage }}</p></div><button type="button" class="ml-4 p-1.5 rounded-full hover:bg-black/10" onclick="this.parentElement.style.display='none'"><i class="fas fa-times text-sm"></i></button></div>
    @endif
    @if ($infoMessage)
        <div class="mb-4 p-4 rounded-lg border-l-4 flex items-start bg-blue-100 dark:bg-blue-900/30 border-blue-500 text-blue-700 dark:text-blue-300"><div class="flex-shrink-0"><i class="fas fa-info-circle text-lg"></i></div><div class="ml-3 flex-grow"><p class="font-semibold">{{ $infoMessage }}</p></div><button type="button" class="ml-4 p-1.5 rounded-full hover:bg-black/10" onclick="this.parentElement.style.display='none'"><i class="fas fa-times text-sm"></i></button></div>
    @endif

    <div class="border-b border-slate-200 dark:border-slate-700">
        <nav class="flex space-x-6" aria-label="Tabs">
            <a href="#" data-tab="new" class="tab-link active-tab">
                Mới <span class="tab-count">{{ count($rentNew) }}</span>
            </a>
            <a href="#" data-tab="accepted" class="tab-link">
                Đã nhận <span class="tab-count">{{ count($rentAccepted) }}</span>
            </a>
            <a href="#" data-tab="completed" class="tab-link">
                Hoàn thành <span class="tab-count">{{ count($rentCompleted) }}</span>
            </a>
            <a href="#" data-tab="cancelled" class="tab-link">
                Đã hủy / Từ chối <span class="tab-count">{{ count($rentCancelled) }}</span>
            </a>
        </nav>
    </div>

    <div class="mt-6">
        
        <div id="tab-content-new" class="tab-content space-y-4">
            @forelse($rentNew as $rentInfo)
                <div class="bg-white dark:bg-[#2d2d2d] rounded-lg shadow-sm border border-slate-200 dark:border-slate-700/50">
                    <div class="p-4 border-b border-slate-100 dark:border-slate-700/50 flex justify-between items-center">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Yêu cầu mới • <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $rentInfo['created_at'] }}</span></p>
                    </div>
                    <div class="p-4 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="flex-grow flex items-center gap-4"><img src="/project/{{ $rentInfo['bplayer_image'] }}" alt="User Avatar" class="w-12 h-12 rounded-full"><div><p class="font-bold text-slate-800 dark:text-slate-100">{{ $rentInfo['user_fullname'] }}</p><p class="text-xs text-slate-500 dark:text-slate-400">User ID: {{ $rentInfo['user_id'] }}</p></div></div>
                        <div class="w-full sm:w-auto flex items-center divide-x divide-slate-200 dark:divide-slate-700/50 bg-slate-50 dark:bg-slate-800/30 rounded-lg p-3"><div class="px-4 text-center"><p class="text-xs text-slate-500 dark:text-slate-400">Giờ thuê</p><p class="font-bold text-slate-700 dark:text-slate-200">{{ $rentInfo['hours'] }} giờ</p></div><div class="px-4 text-center"><p class="text-xs text-slate-500 dark:text-slate-400">Bạn nhận</p><p class="font-bold text-green-500">{{ $rentInfo['amount'] }} <i class="fas fa-gem text-xs"></i></p></div></div>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-800/30 rounded-b-lg flex justify-end items-center gap-3">
                        <form action="/project/rent/{{ $rentInfo['id'] }}/handle" method="POST" class="flex items-center gap-3">
                            <button type="submit" name="action" value="deny" class="py-2 px-4 rounded-lg text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">Từ chối</button>
                            <button type="submit" name="action" value="accept" class="py-2 px-4 rounded-lg text-sm font-semibold text-white bg-[#f48024] hover:bg-orange-600 transition-all"><i class="fas fa-check mr-1.5"></i> Chấp nhận</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-500 dark:text-slate-400 py-8">Không có đơn thuê mới nào.</p>
            @endforelse
        </div>

        <div id="tab-content-accepted" class="tab-content space-y-4 hidden">
            @forelse($rentAccepted as $rentInfo)
                <div class="bg-white dark:bg-[#2d2d2d] rounded-lg shadow-sm border border-slate-200 dark:border-slate-700/50">
                    <div class="p-4 border-b border-slate-100 dark:border-slate-700/50 flex justify-between items-center">
                        <p class="text-sm text-slate-500 dark:text-slate-400"><span class="font-bold text-blue-600 dark:text-blue-400"><i class="fas fa-handshake"></i> Đã nhận</span> • <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $rentInfo['created_at'] }}</span></p>
                    </div>
                    <div class="p-4 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="flex-grow flex items-center gap-4"><img src="/project/{{ $rentInfo['bplayer_image'] }}" alt="User Avatar" class="w-12 h-12 rounded-full"><div><p class="font-bold text-slate-800 dark:text-slate-100">{{ $rentInfo['user_fullname'] }}</p><p class="text-xs text-slate-500 dark:text-slate-400">User ID: {{ $rentInfo['user_id'] }}</p></div></div>
                        <div class="w-full sm:w-auto flex items-center divide-x divide-slate-200 dark:divide-slate-700/50 bg-slate-50 dark:bg-slate-800/30 rounded-lg p-3"><div class="px-4 text-center"><p class="text-xs text-slate-500 dark:text-slate-400">Giờ thuê</p><p class="font-bold text-slate-700 dark:text-slate-200">{{ $rentInfo['hours'] }} giờ</p></div><div class="px-4 text-center"><p class="text-xs text-slate-500 dark:text-slate-400">Bạn nhận</p><p class="font-bold text-green-500">{{ $rentInfo['amount'] }} <i class="fas fa-gem text-xs"></i></p></div></div>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-800/30 rounded-b-lg flex justify-end items-center gap-3">
                        <button class="py-2 px-4 rounded-lg text-sm font-semibold text-white bg-blue-500 hover:bg-blue-600 transition-all"><i class="fas fa-comment-dots mr-1.5"></i> Trò chuyện</button>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-500 dark:text-slate-400 py-8">Chưa có đơn nào được nhận.</p>
            @endforelse
        </div>

        <div id="tab-content-completed" class="tab-content space-y-4 hidden">
            @forelse($rentCompleted as $rentInfo)
                <div class="bg-white dark:bg-[#2d2d2d] rounded-lg shadow-sm border border-slate-200 dark:border-slate-700/50 opacity-75">
                    <div class="p-4 border-b border-slate-100 dark:border-slate-700/50 flex justify-between items-center">
                        <p class="text-sm text-slate-500 dark:text-slate-400"><span class="font-bold text-green-600 dark:text-green-400"><i class="fas fa-check-circle"></i> Hoàn thành</span> • <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $rentInfo['created_at'] }}</span></p>
                    </div>
                    <div class="p-4 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="flex-grow flex items-center gap-4"><img src="/project/{{ $rentInfo['bplayer_image'] }}" alt="User Avatar" class="w-12 h-12 rounded-full"><div><p class="font-bold text-slate-800 dark:text-slate-100">{{ $rentInfo['user_fullname'] }}</p><p class="text-xs text-slate-500 dark:text-slate-400">User ID: {{ $rentInfo['user_id'] }}</p></div></div>
                        <div class="w-full sm:w-auto flex items-center divide-x divide-slate-200 dark:divide-slate-700/50 bg-slate-50 dark:bg-slate-800/30 rounded-lg p-3"><div class="px-4 text-center"><p class="text-xs text-slate-500 dark:text-slate-400">Giờ thuê</p><p class="font-bold text-slate-700 dark:text-slate-200">{{ $rentInfo['hours'] }} giờ</p></div><div class="px-4 text-center"><p class="text-xs text-slate-500 dark:text-slate-400">Bạn nhận</p><p class="font-bold text-green-500">{{ $rentInfo['amount'] }} <i class="fas fa-gem text-xs"></i></p></div></div>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-500 dark:text-slate-400 py-8">Chưa có đơn nào hoàn thành.</p>
            @endforelse
        </div>
        
        <div id="tab-content-cancelled" class="tab-content space-y-4 hidden">
            @forelse($rentCancelled as $rentInfo)
                <div class="bg-white dark:bg-[#2d2d2d] rounded-lg shadow-sm border border-slate-200 dark:border-slate-700/50 opacity-75">
                    <div class="p-4 border-b border-slate-100 dark:border-slate-700/50 flex justify-between items-center">
                        <p class="text-sm text-slate-500 dark:text-slate-400"><span class="font-bold text-red-600 dark:text-red-400"><i class="fas fa-times-circle"></i> Đã hủy</span> • <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $rentInfo['created_at'] }}</span></p>
                    </div>
                    <div class="p-4 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="flex-grow flex items-center gap-4"><img src="/project/{{ $rentInfo['bplayer_image'] }}" alt="User Avatar" class="w-12 h-12 rounded-full"><div><p class="font-bold text-slate-800 dark:text-slate-100">{{ $rentInfo['user_fullname'] }}</p><p class="text-xs text-slate-500 dark:text-slate-400">User ID: {{ $rentInfo['user_id'] }}</p></div></div>
                        <div class="w-full sm:w-auto flex items-center divide-x divide-slate-200 dark:divide-slate-700/50 bg-slate-50 dark:bg-slate-800/30 rounded-lg p-3"><div class="px-4 text-center"><p class="text-xs text-slate-500 dark:text-slate-400">Giờ thuê</p><p class="font-bold text-slate-700 dark:text-slate-200">{{ $rentInfo['hours'] }} giờ</p></div><div class="px-4 text-center"><p class="text-xs text-slate-500 dark:text-slate-400">Đã trả</p><p class="font-bold text-red-500">{{ $rentInfo['amount'] }} <i class="fas fa-gem text-xs"></i></p></div></div>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-500 dark:text-slate-400 py-8">Không có đơn nào bị hủy hoặc từ chối.</p>
            @endforelse
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .tab-link{padding:0.75rem 0.75rem;font-size:0.875rem;line-height:1.25rem;font-weight:600;color:rgb(100 116 139/1);--tw-border-opacity:1;border-bottom-width:2px;border-color:rgb(0 0 0/0);white-space:nowrap}.dark .tab-link{color:rgb(148 163 184/1)}.tab-link:hover{color:rgb(51 65 85/1)}.dark .tab-link:hover{color:rgb(226 232 240/1)}.active-tab{color:rgb(244 128 36/1);border-color:rgb(244 128 36/1)}.tab-count{margin-left:0.375rem;background-color:rgb(226 232 240/1);color:rgb(71 85 105/1);padding:.125rem .5rem;border-radius:.9375rem;font-size:.75rem;line-height:1rem}.dark .tab-count{background-color:rgb(51 65 85/1);color:rgb(203 213 225/1)}.active-tab .tab-count{background-color:rgb(244 128 36/.2);color:rgb(244 128 36/1)}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){const t=document.querySelectorAll('.tab-link'),e=document.querySelectorAll('.tab-content');t.forEach(n=>{n.addEventListener('click',function(c){c.preventDefault(),t.forEach(t=>t.classList.remove('active-tab')),this.classList.add('active-tab');const n=this.getAttribute('data-tab');e.forEach(t=>t.classList.add('hidden')),document.getElementById('tab-content-'+n).classList.remove('hidden')})})});
</script>
@endpush