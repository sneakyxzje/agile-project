@extends('layouts.app')

@section('title', 'Thanh toán thành công')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow text-center">
    <h2 class="text-xl font-bold text-green-600 mb-4">Thanh toán thành công!</h2>
    <p>Bạn đã nạp kim cương thành công qua MoMo.</p>
    <a href="/project/" class="text-pink-500 underline mt-4 block">Quay về trang chủ</a>
</div>
@endsection
