@extends('layouts.admin')

@section('title', 'Chỉnh sửa User')

@section('content')
<div class="min-h-screen p-6 transition-colors duration-300">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-[#232629] dark:text-[#e3e6e8]">Chỉnh sửa Người dùng</h1>
            <p class="text-sm text-[#525960] dark:text-[#9fa6ad] mt-1">Cập nhật thông tin cho <span class="font-bold">{{ $user['fullname'] }}</span></p>
        </div>
        <a href="/project/admin/users" class="flex items-center px-4 py-2 text-sm font-semibold text-[#525960] dark:text-[#9fa6ad] bg-white dark:bg-[#2d2d2d] border border-[#d6d9dc] dark:border-[#3f4042] rounded-lg hover:bg-[#f8f9f9] dark:hover:bg-[#3a3a3a] transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Quay lại danh sách
        </a>
    </div>

    <form action="/project/admin/users/update/{{ $user['id'] }}" method="POST">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-[#2d2d2d] rounded-xl shadow-md border border-[#d6d9dc] dark:border-[#3f4042]">
                    <div class="p-6 border-b border-[#d6d9dc] dark:border-[#3f4042]">
                        <h3 class="text-lg font-semibold text-[#232629] dark:text-[#e3e6e8]">Thông tin tài khoản</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <input type="text" id="fullname" name="fullname" class="form-input" value="{{ $user['fullname'] }}">
                        </div>
                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-input" value="{{ $user['email'] }}">
                        </div>
                        @if(!empty($user['nickname']))
                        <div>
                            <label class="form-label">Nickname BPlayer</label>
                            <input type="text" class="form-input bg-[#f8f9f9] dark:bg-[#232426] cursor-not-allowed" value="{{ $user['nickname'] }}" disabled readonly>
                        </div>
                        @endif
                        <div>
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <input type="password" id="new_password" name="new_password" class="form-input" placeholder="Để trống nếu không muốn đổi">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white dark:bg-[#2d2d2d] rounded-xl shadow-md border border-[#d6d9dc] dark:border-[#3f4042]">
                    <div class="p-6 border-b border-[#d6d9dc] dark:border-[#3f4042]">
                        <h3 class="text-lg font-semibold text-[#232629] dark:text-[#e3e6e8]">Vai trò</h3>
                    </div>
                    <div class="p-6">
                        <select name="role" class="form-input">
                            <option value="user" @if($user['role'] == 'user') selected @endif>User</option>
                            <option value="bplayer" @if($user['role'] == 'bplayer') selected @endif>BPlayer</option>
                            <option value="admin" @if($user['role'] == 'admin') selected @endif>Admin</option>
                        </select>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#2d2d2d] rounded-xl shadow-md border border-[#d6d9dc] dark:border-[#3f4042]">
                    <div class="p-6 border-b border-[#d6d9dc] dark:border-[#3f4042]">
                        <h3 class="text-lg font-semibold text-[#232629] dark:text-[#e3e6e8]">Số dư kim cương</h3>
                    </div>
                    <div class="p-6">
                         <input type="number" name="diamond" class="form-input" value="{{ $user['diamond'] }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="px-6 py-3 bg-[#f48024] text-white font-bold text-sm rounded-lg shadow-md hover:bg-orange-600 transition-colors">
                Lưu thay đổi
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .form-label { @apply block mb-2 text-sm font-semibold text-[#232629] dark:text-[#e3e6e8]; }
    .form-input { @apply block w-full px-4 py-2 text-sm text-[#232629] dark:text-[#e3e6e8] bg-white dark:bg-[#232426] border border-[#d6d9dc] dark:border-[#3f4042] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f48024] transition; }
</style>
@endpush