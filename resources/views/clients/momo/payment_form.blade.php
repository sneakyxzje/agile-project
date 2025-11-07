@extends('layouts.app')

@section('title', 'Nạp kim cương')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="bg-white dark:bg-[#2d2d2d] rounded-xl shadow-sm border border-[#e3e6e8] dark:border-[#3f4042] p-4 mb-5">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-xl font-bold text-[#0c0d0e] dark:text-[#e3e6e8] mb-1 flex items-center">
                    <i class="fas fa-gem text-[#f48024] mr-2"></i>
                    Nạp kim cương
                </h1>
                <p class="text-sm text-[#525960] dark:text-[#9fa6ad]">Chọn gói nạp phù hợp</p>
            </div>
            <div class="text-right bg-gradient-to-br from-[#fff4e6] to-[#ffe8cc] dark:from-[#3a2e1f] dark:to-[#4a3a2a] px-4 py-2 rounded-xl border-2 border-[#f48024]">
                <p class="text-xs text-[#525960] dark:text-[#9fa6ad]">Số dư hiện tại</p>
                <div class="flex items-center space-x-1.5">
                    <i class="fas fa-gem text-[#f48024] text-base"></i>
                    <span class="text-lg font-bold text-[#0c0d0e] dark:text-[#e3e6e8]"><?= number_format(getUserDiamond()) ?></span>
                </div>
            </div>
        </div>
    </div>

    <form action="/project/momo/payment" method="POST" id="payment-form">
        <input type="hidden" name="id" value="<?= $userId ?>">
        <input type="hidden" name="amount" id="selected-amount" value="">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-[#2d2d2d] rounded-xl shadow-sm border border-[#e3e6e8] dark:border-[#3f4042] p-4">
                    <h2 class="text-lg font-bold text-[#0c0d0e] dark:text-[#e3e6e8] mb-4 flex items-center">
                        <i class="fas fa-box-open text-[#f48024] mr-2"></i>
                        Chọn gói nạp
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
                        
                        <div class="package-card group bg-gradient-to-br from-white to-[#fafbfc] dark:from-[#2d2d2d] dark:to-[#232426] rounded-xl border-2 border-[#e3e6e8] dark:border-[#3f4042] p-3 cursor-pointer hover:shadow-xl transition-all duration-300" onclick="selectPackage(this, 50000, 50)">
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-[#fff4e6] to-[#ffe8cc] dark:from-[#3a2e1f] dark:to-[#4a3a2a] mb-2 group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <i class="fas fa-gem text-xl text-[#f48024]"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#0c0d0e] dark:text-[#e3e6e8]">50</h3>
                                <p class="text-xs text-[#525960] dark:text-[#9fa6ad] mb-2 uppercase tracking-wide">Kim cương</p>
                                <div class="pt-2 border-t border-[#e3e6e8] dark:border-[#3f4042]">
                                    <p class="text-base font-bold text-[#f48024]">50.000₫</p>
                                </div>
                            </div>
                        </div>

                        <div class="package-card group bg-gradient-to-br from-white to-[#fafbfc] dark:from-[#2d2d2d] dark:to-[#232426] rounded-xl border-2 border-[#e3e6e8] dark:border-[#3f4042] p-3 cursor-pointer hover:shadow-xl transition-all duration-300" onclick="selectPackage(this, 100000, 100)">
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-[#fff4e6] to-[#ffe8cc] dark:from-[#3a2e1f] dark:to-[#4a3a2a] mb-2 group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <i class="fas fa-gem text-xl text-[#f48024]"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#0c0d0e] dark:text-[#e3e6e8]">100</h3>
                                <p class="text-xs text-[#525960] dark:text-[#9fa6ad] mb-2 uppercase tracking-wide">Kim cương</p>
                                <div class="pt-2 border-t border-[#e3e6e8] dark:border-[#3f4042]">
                                    <p class="text-base font-bold text-[#f48024]">100.000₫</p>
                                </div>
                            </div>
                        </div>

                        <div class="package-card group bg-gradient-to-br from-white to-[#fafbfc] dark:from-[#2d2d2d] dark:to-[#232426] rounded-xl border-2 border-[#e3e6e8] dark:border-[#3f4042] p-3 cursor-pointer hover:shadow-xl transition-all duration-300 relative" onclick="selectPackage(this, 200000, 230)">
                            <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 z-10">
                                <span class="bg-gradient-to-r from-[#f48024] to-[#f69c55] text-white text-xs font-bold px-2.5 py-0.5 rounded-full shadow-lg recommended-badge flex items-center">
                                    <i class="fas fa-fire mr-1 text-xs"></i>Phổ biến
                                </span>
                            </div>
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-[#fff4e6] to-[#ffe8cc] dark:from-[#3a2e1f] dark:to-[#4a3a2a] mb-2 group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <i class="fas fa-gem text-xl text-[#f48024]"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#0c0d0e] dark:text-[#e3e6e8]">230</h3>
                                <p class="text-xs text-[#525960] dark:text-[#9fa6ad] mb-2 uppercase tracking-wide">Kim cương</p>
                                <div class="pt-2 border-t border-[#e3e6e8] dark:border-[#3f4042]">
                                    <p class="text-base font-bold text-[#f48024]">200.000₫</p>
                                </div>
                            </div>
                        </div>

                        <div class="package-card group bg-gradient-to-br from-white to-[#fafbfc] dark:from-[#2d2d2d] dark:to-[#232426] rounded-xl border-2 border-[#e3e6e8] dark:border-[#3f4042] p-3 cursor-pointer hover:shadow-xl transition-all duration-300" onclick="selectPackage(this, 300000, 360)">
                             <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-[#fff4e6] to-[#ffe8cc] dark:from-[#3a2e1f] dark:to-[#4a3a2a] mb-2 group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <i class="fas fa-gem text-xl text-[#f48024]"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#0c0d0e] dark:text-[#e3e6e8]">360</h3>
                                <p class="text-xs text-[#525960] dark:text-[#9fa6ad] mb-2 uppercase tracking-wide">Kim cương</p>
                                <div class="pt-2 border-t border-[#e3e6e8] dark:border-[#3f4042]">
                                    <p class="text-base font-bold text-[#f48024]">300.000₫</p>
                                </div>
                            </div>
                        </div>

                        <div class="package-card group bg-gradient-to-br from-white to-[#fafbfc] dark:from-[#2d2d2d] dark:to-[#232426] rounded-xl border-2 border-[#e3e6e8] dark:border-[#3f4042] p-3 cursor-pointer hover:shadow-xl transition-all duration-300" onclick="selectPackage(this, 500000, 625)">
                             <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-[#fff4e6] to-[#ffe8cc] dark:from-[#3a2e1f] dark:to-[#4a3a2a] mb-2 group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <i class="fas fa-gem text-xl text-[#f48024]"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#0c0d0e] dark:text-[#e3e6e8]">625</h3>
                                <p class="text-xs text-[#525960] dark:text-[#9fa6ad] mb-2 uppercase tracking-wide">Kim cương</p>
                                <div class="pt-2 border-t border-[#e3e6e8] dark:border-[#3f4042]">
                                    <p class="text-base font-bold text-[#f48024]">500.000₫</p>
                                </div>
                            </div>
                        </div>

                        <div class="package-card group bg-gradient-to-br from-white to-[#fafbfc] dark:from-[#2d2d2d] dark:to-[#232426] rounded-xl border-2 border-[#e3e6e8] dark:border-[#3f4042] p-3 cursor-pointer hover:shadow-xl transition-all duration-300" onclick="selectPackage(this, 1000000, 1300)">
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-[#fff4e6] to-[#ffe8cc] dark:from-[#3a2e1f] dark:to-[#4a3a2a] mb-2 group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <i class="fas fa-gem text-xl text-[#f48024]"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#0c0d0e] dark:text-[#e3e6e8]">1.300</h3>
                                <p class="text-xs text-[#525960] dark:text-[#9fa6ad] mb-2 uppercase tracking-wide">Kim cương</p>
                                <div class="pt-2 border-t border-[#e3e6e8] dark:border-[#3f4042]">
                                    <p class="text-base font-bold text-[#f48024]">1.000.000₫</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="package-card group bg-gradient-to-br from-white to-[#fafbfc] dark:from-[#2d2d2d] dark:to-[#232426] rounded-xl border-2 border-[#e3e6e8] dark:border-[#3f4042] p-3 cursor-pointer hover:shadow-xl transition-all duration-300" onclick="selectPackage(this, 2000000, 2700)">
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-[#fff4e6] to-[#ffe8cc] dark:from-[#3a2e1f] dark:to-[#4a3a2a] mb-2 group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <i class="fas fa-gem text-xl text-[#f48024]"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#0c0d0e] dark:text-[#e3e6e8]">2.700</h3>
                                <p class="text-xs text-[#525960] dark:text-[#9fa6ad] mb-2 uppercase tracking-wide">Kim cương</p>
                                <div class="pt-2 border-t border-[#e3e6e8] dark:border-[#3f4042]">
                                    <p class="text-base font-bold text-[#f48024]">2.000.000₫</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="package-card group bg-gradient-to-br from-white to-[#fafbfc] dark:from-[#2d2d2d] dark:to-[#232426] rounded-xl border-2 border-[#e3e6e8] dark:border-[#3f4042] p-3 cursor-pointer hover:shadow-xl transition-all duration-300 relative" onclick="selectPackage(this, 3000000, 4200)">
                            <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 z-10">
                                <span class="bg-gradient-to-r from-purple-600 to-purple-700 text-white text-xs font-bold px-2.5 py-0.5 rounded-full shadow-lg recommended-badge flex items-center">
                                    <i class="fas fa-crown mr-1 text-xs"></i>Tốt nhất
                                </span>
                            </div>
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-[#fff4e6] to-[#ffe8cc] dark:from-[#3a2e1f] dark:to-[#4a3a2a] mb-2 group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <i class="fas fa-gem text-xl text-[#f48024]"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#0c0d0e] dark:text-[#e3e6e8]">4.200</h3>
                                <p class="text-xs text-[#525960] dark:text-[#9fa6ad] mb-2 uppercase tracking-wide">Kim cương</p>
                                <div class="pt-2 border-t border-[#e3e6e8] dark:border-[#3f4042]">
                                    <p class="text-base font-bold text-[#f48024]">3.000.000₫</p>
                                </div>
                            </div>
                        </div>

                        <div class="package-card group bg-gradient-to-br from-white to-[#fafbfc] dark:from-[#2d2d2d] dark:to-[#232426] rounded-xl border-2 border-[#e3e6e8] dark:border-[#3f4042] p-3 cursor-pointer hover:shadow-xl transition-all duration-300 relative" onclick="selectPackage(this, 5000000, 7500)">
                            <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 z-10">
                                <span class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-xs font-bold px-2.5 py-0.5 rounded-full shadow-lg recommended-badge flex items-center">
                                    <i class="fas fa-star mr-1 text-xs"></i>VIP
                                </span>
                            </div>
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-[#fff4e6] to-[#ffe8cc] dark:from-[#3a2e1f] dark:to-[#4a3a2a] mb-2 group-hover:scale-110 transition-transform duration-300 shadow-md">
                                    <i class="fas fa-gem text-xl text-[#f48024]"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#0c0d0e] dark:text-[#e3e6e8]">7.500</h3>
                                <p class="text-xs text-[#525960] dark:text-[#9fa6ad] mb-2 uppercase tracking-wide">Kim cương</p>
                                <div class="pt-2 border-t border-[#e3e6e8] dark:border-[#3f4042]">
                                    <p class="text-base font-bold text-[#f48024]">5.000.000₫</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div id="empty-state" class="bg-white dark:bg-[#2d2d2d] rounded-xl shadow-sm border border-[#e3e6e8] dark:border-[#3f4042] p-5">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#f8f9f9] dark:bg-[#232426] mb-3">
                                <i class="fas fa-hand-pointer text-2xl text-[#9fa6ad]"></i>
                            </div>
                            <h3 class="text-base font-semibold text-[#525960] dark:text-[#9fa6ad] mb-1">Chọn gói nạp</h3>
                            <p class="text-sm text-[#9fa6ad] dark:text-[#6a6a6a]">Vui lòng chọn một gói để tiếp tục</p>
                        </div>
                    </div>

                    <div id="payment-summary" class="bg-white dark:bg-[#2d2d2d] rounded-xl shadow-lg border-2 border-[#f48024] p-4 hidden">
                        <h3 class="text-base font-bold text-[#0c0d0e] dark:text-[#e3e6e8] mb-4 flex items-center">
                            <i class="fas fa-receipt text-[#f48024] mr-2"></i>
                            Chi tiết thanh toán
                        </h3>
                        
                        <div class="bg-gradient-to-br from-[#fff4e6] to-[#ffe8cc] dark:from-[#3a2e1f] dark:to-[#4a3a2a] rounded-xl p-3 mb-4 text-center border-2 border-[#f48024]">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-white dark:bg-[#2d2d2d] mb-1 shadow-md">
                                <i class="fas fa-gem text-xl text-[#f48024]"></i>
                            </div>
                            <h4 class="text-xl font-bold text-[#0c0d0e] dark:text-[#e3e6e8]" id="selected-diamonds">0</h4>
                            <p class="text-xs text-[#525960] dark:text-[#9fa6ad] uppercase tracking-wide">Kim cương</p>
                        </div>

                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between items-center pb-2 border-b border-[#e3e6e8] dark:border-[#3f4042]">
                                <span class="text-sm text-[#525960] dark:text-[#9fa6ad]">Giá gốc</span>
                                <span class="font-semibold text-sm text-[#0c0d0e] dark:text-[#e3e6e8]" id="original-price">0₫</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t-2 border-[#f48024]">
                                <span class="text-sm font-semibold text-[#0c0d0e] dark:text-[#e3e6e8]">Tổng thanh toán</span>
                                <span class="text-xl font-bold text-[#f48024]" id="total-amount">0₫</span>
                            </div>
                        </div>

                        <div class="bg-[#f8f9f9] dark:bg-[#232426] rounded-xl p-3 mb-4">
                            <p class="text-xs text-[#525960] dark:text-[#9fa6ad] mb-1 uppercase tracking-wide">Phương thức thanh toán</p>
                            <div class="flex items-center space-x-2">
                                <img src="https://developers.momo.vn/v3/img/logo.svg" alt="MoMo" class="h-7 w-7">
                                <div>
                                    <p class="font-semibold text-sm text-[#0c0d0e] dark:text-[#e3e6e8]">Ví MoMo</p>
                                    <p class="text-xs text-[#525960] dark:text-[#9fa6ad]">Nhanh chóng & an toàn</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full py-2.5 rounded-xl font-bold text-white shadow-lg transition-all hover:shadow-xl hover:scale-105 flex items-center justify-center space-x-2 text-sm"
                                style="background: linear-gradient(135deg, #f48024 0%, #f69c55 100%);">
                            <i class="fas fa-credit-card"></i>
                            <span>Thanh toán ngay</span>
                        </button>

                        <div class="mt-3 text-center">
                            <p class="text-xs text-[#9fa6ad] dark:text-[#6a6a6a]">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Giao dịch được bảo mật 100%
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 bg-blue-50 dark:bg-[#1e2837] border border-blue-200 dark:border-[#2d4159] rounded-xl p-3">
                        <div class="flex items-start space-x-2.5">
                            <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0"></i>
                            <div class="flex-1">
                                <h4 class="font-semibold text-blue-900 dark:text-blue-300 mb-1.5 text-sm">Lưu ý quan trọng</h4>
                                <ul class="text-xs text-blue-800 dark:text-blue-400 space-y-1">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle mr-1.5 mt-0.5 flex-shrink-0"></i>
                                        <span>Kim cương sẽ được cộng ngay lập tức</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle mr-1.5 mt-0.5 flex-shrink-0"></i>
                                        <span>Không tắt trình duyệt khi thanh toán</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle mr-1.5 mt-0.5 flex-shrink-0"></i>
                                        <span>Liên hệ CSKH nếu có vấn đề</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.package-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.package-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 15px 30px rgba(244, 128, 36, 0.15);
}
.package-card.selected {
    border-color: #f48024 !important;
    background: linear-gradient(135deg, #fff4e6 0%, #ffe8cc 100%) !important;
    box-shadow: 0 10px 25px rgba(244, 128, 36, 0.35);
    transform: translateY(-6px) scale(1.04);
}
body.dark .package-card.selected {
    background: linear-gradient(135deg, #3a2e1f 0%, #4a3a2a 100%) !important;
}
.recommended-badge {
    animation: pulse-badge 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
@keyframes pulse-badge {
    0%, 100% { 
        opacity: 1; 
        transform: scale(1);
    }
    50% { 
        opacity: 0.9; 
        transform: scale(0.97);
    }
}
#payment-summary {
    animation: slideInRight 0.4s ease-out;
}
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
.alert-popup {
    animation: fadeInDown 0.5s ease-out forwards;
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translate(-50%, -100%); }
    to { opacity: 1; transform: translate(-50%, 0); }
}
</style>

<script>
let selectedAmount = 0;
let selectedDiamonds = 0;

function selectPackage(element, amount, diamonds) {
    document.querySelectorAll('.package-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    element.classList.add('selected');
    
    selectedAmount = amount;
    selectedDiamonds = diamonds;
    
    document.getElementById('selected-amount').value = amount;
    
    const baseDiamonds = amount / 1000;
    const bonusDiamonds = diamonds - baseDiamonds;
    
    document.getElementById('empty-state').classList.add('hidden');
    document.getElementById('payment-summary').classList.remove('hidden');
    
    setTimeout(() => {
        document.getElementById('selected-diamonds').textContent = diamonds.toLocaleString('vi-VN');
        document.getElementById('original-price').textContent = amount.toLocaleString('vi-VN') + '₫';
        document.getElementById('total-amount').textContent = amount.toLocaleString('vi-VN') + '₫';
        
        const bonusRow = document.getElementById('bonus-row');
        if (bonusDiamonds > 0) {
            bonusRow.style.display = 'flex';
            document.getElementById('bonus-amount').textContent = '+' + bonusDiamonds.toLocaleString('vi-VN') + ' 💎';
        } else {
            bonusRow.style.display = 'none';
        }
    }, 100);
}

document.getElementById('payment-form').addEventListener('submit', function(e) {
    const amount = document.getElementById('selected-amount').value;
    if (!amount) {
        e.preventDefault();

        const existingAlert = document.querySelector('.alert-popup');
        if (existingAlert) existingAlert.remove();
        
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert-popup fixed top-5 left-1/2 -translate-x-1/2 bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg shadow-2xl z-50 flex items-center space-x-3';
        alertDiv.innerHTML = '<i class="fas fa-exclamation-circle text-2xl"></i><span class="font-semibold">Vui lòng chọn một gói nạp!</span>';
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.style.transition = 'opacity 0.5s ease-out';
            alertDiv.style.opacity = '0';
            setTimeout(() => alertDiv.remove(), 500);
        }, 3000);
    }
});
</script>
@endsection