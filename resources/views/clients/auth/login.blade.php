@extends('layouts.app')

@section('title', 'Đăng nhập')

@php
    $successMessage = session_flash('success');
@endphp

@section('content')
<div class="flex items-center justify-center min-h-screen transition-all duration-300">
  <div class="w-full max-w-md bg-white dark:bg-[#2d2d2d] shadow-xl rounded-2xl p-8 mt-10 mx-4 transition-all duration-300">
    @if ( $successMessage)
    <div class="alert-success" style="background-color: #d4edda; color: #155724; padding: 1rem; border: 1px solid #c3e6cb; border-radius: .25rem; margin-bottom: 1rem;">
        <p>{{  $successMessage }}</p>
    </div>
@endif
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100">Đăng nhập tài khoản</h2>

    <form action="{{ route('login-handle')}}" method="POST" class="space-y-5">
      <div>
        <label class="block text-gray-700 dark:text-gray-200 mb-2 font-medium">Email</label>
        <input type="email" name="email" required placeholder="Nhập email của bạn"
          class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-orange-400 focus:outline-none bg-white dark:bg-[#3a3a3a] text-gray-900 dark:text-gray-100 transition-all duration-300" />
      </div>

      <div>
        <label class="block text-gray-700 dark:text-gray-200 mb-2 font-medium">Mật khẩu</label>
        <input type="password" name="password" required placeholder="Nhập mật khẩu"
          class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-orange-400 focus:outline-none bg-white dark:bg-[#3a3a3a] text-gray-900 dark:text-gray-100 transition-all duration-300" />
      </div>

      <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300">
        <label class="flex items-center space-x-2">
          <input type="checkbox" class="rounded border-gray-400 dark:border-gray-600" />
          <span>Ghi nhớ đăng nhập</span>
        </label>
        <a href="#" class="text-orange-500 hover:text-orange-600 font-medium">Quên mật khẩu?</a>
      </div>

      <button type="submit"
        class="w-full bg-gradient-to-r from-orange-500 to-orange-400 text-white py-3 rounded-lg font-medium hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
        Đăng nhập
      </button>
    </form>

    <p class="mt-6 text-center text-gray-600 dark:text-gray-300">
      Chưa có tài khoản?
      <a href="/project/register" class="text-orange-500 hover:text-orange-600 font-medium">Đăng ký ngay</a>
    </p>
  </div>
</div>
@endsection