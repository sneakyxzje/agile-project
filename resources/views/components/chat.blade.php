<div id="chat-widget" class="fixed bottom-0 right-4 w-full sm:w-[360px] z-50 transform translate-y-[120%] transition-transform duration-300 ease-in-out">
    
    <div class="bg-white dark:bg-[#2d2d2d] rounded-t-2xl shadow-2xl border border-[#d6d9dc] dark:border-[#3f4042] overflow-hidden h-[500px] flex flex-col">
        
        <div class="bg-[#f48024] p-3 flex items-center justify-between cursor-pointer shrink-0 z-20 relative" id="chat-header">
            <div class="flex items-center gap-3">
                <button id="btn-back-list" class="hidden text-white hover:text-gray-200 mr-1">
                    <i class="fas fa-arrow-left"></i>
                </button>

                <div>
                    <h4 id="header-name" class="text-white font-bold text-sm">Tin nhắn</h4>
                    <span id="header-status" class="text-orange-100 text-xs block">Danh sách hội thoại</span>
                </div>
            </div>
            <div class="flex items-center gap-2 text-white/80">
                <button id="close-chat-btn" class="hover:text-white p-1"><i class="fas fa-times"></i></button>
            </div>
        </div>

        <div id="chat-list-view" class="flex-1 flex flex-col min-h-0 bg-white dark:bg-[#2d2d2d]">
            <div class="flex-1 overflow-y-auto">
                <div class="p-4 text-center text-gray-500 text-sm">Đang tải danh sách...</div>
            </div>
        </div>

        <div id="chat-detail-view" class="hidden flex-1 flex flex-col min-h-0 bg-[#f8f9f9] dark:bg-[#232426]">
            
            <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4 scroll-smooth">
                </div>
            
            <div class="p-3 bg-white dark:bg-[#2d2d2d] border-t border-[#d6d9dc] dark:border-[#3f4042] shrink-0 z-10">
                <form id="chat-form" class="flex items-center gap-2">
                    <button type="button" class="text-[#525960] dark:text-[#9fa6ad] hover:text-[#f48024] p-2">
                        <i class="fas fa-image"></i>
                    </button>
                    
                    <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." autocomplete="off"
                           class="flex-1 bg-[#f1f2f3] dark:bg-[#3a3a3a] text-[#0c0d0e] dark:text-[#e3e6e8] text-sm rounded-full px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-[#f48024]">
                    
                    <button type="submit" class="text-[#f48024] hover:text-[#d97018] p-2 font-bold transition-colors">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const BASE_URL = '/project/'; 
    
    const mainChatToggle = document.getElementById('main-chat-toggle');
    const chatWidget = document.getElementById('chat-widget');
    
    const chatListView = document.getElementById('chat-list-view');
    const chatDetailView = document.getElementById('chat-detail-view');
    const btnBackList = document.getElementById('btn-back-list');
    
    const chatHeader = document.getElementById('chat-header');
    const chatHeaderName = chatHeader ? chatHeader.querySelector('h4') : null;
    const chatHeaderAvatar = chatHeader ? chatHeader.querySelector('img') : null;
    const chatHeaderStatus = chatHeader ? chatHeader.querySelector('.text-xs') : null;
    const closeChatBtn = document.getElementById('close-chat-btn');
    
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');

    let receiverId = 0; 
    let receiverName = 'Người lạ'; 
    let receiverAvatar = BASE_URL + 'assets/images/default.png';
    
    const currentUserId = <?= $_SESSION['user']['id'] ?? 0 ?>;
    const rawUserAvatar = '<?= $_SESSION['user']['avatar'] ?? "" ?>';
    const currentUserAvatar = getAvatarUrl(rawUserAvatar);

    function getAvatarUrl(path) {
        if (!path || path === 'null') return 'https://ui-avatars.com/api/?name=User&background=random';
        if (path.startsWith('http')) return path; 
        if (path.startsWith(BASE_URL)) return path; 
        const cleanPath = path.startsWith('/') ? path.substring(1) : path;
        return BASE_URL + cleanPath;
    }

    function switchView(mode) {
        if (mode === 'list') {
            chatListView.classList.remove('hidden');
            chatDetailView.classList.add('hidden');
            btnBackList.classList.add('hidden');
            
            if(chatHeaderName) chatHeaderName.textContent = "Tin nhắn";
            if(chatHeaderStatus) chatHeaderStatus.textContent = "Danh sách hội thoại";
            if(chatHeaderAvatar) chatHeaderAvatar.src = BASE_URL + 'assets/images/default.png';
            
            loadInbox(); 
        } else if (mode === 'chat') {
            chatListView.classList.add('hidden');
            chatDetailView.classList.remove('hidden'); 
            btnBackList.classList.remove('hidden');
        }
    }

    window.openChatWith = function(id, name, avatar) {
        receiverId = parseInt(id);
        receiverName = name;
        receiverAvatar = getAvatarUrl(avatar);

        if(chatHeaderName) chatHeaderName.textContent = receiverName;
        if(chatHeaderAvatar) chatHeaderAvatar.src = receiverAvatar;
        if(chatHeaderStatus) chatHeaderStatus.textContent = "";

        switchView('chat');

        chatWidget.classList.remove('translate-y-[120%]');
        chatWidget.classList.add('translate-y-0');

        loadChatHistory(receiverId);
    };

    function loadInbox() {
        chatListView.innerHTML = '<div class="p-4 text-center text-sm text-gray-500">Đang tải...</div>';
        fetch(BASE_URL + 'chat/conversations')
            .then(r => r.json())
            .then(data => {
                chatListView.innerHTML = '';
                if (data.status === 'success') {
                    if (data.data.length === 0) {
                        chatListView.innerHTML = '<div class="p-4 text-center text-sm text-gray-500">Chưa có tin nhắn nào.</div>';
                        return;
                    }
                    let html = '';
                    data.data.forEach(item => {
                        let avatar = getAvatarUrl(item.partner_avatar);
                        let lastMsg = item.last_sender_id == currentUserId ? `Bạn: ${item.last_message}` : item.last_message;
                        
                        html += `
                        <div class="flex items-center gap-3 p-3 hover:bg-gray-100 dark:hover:bg-[#3a3a3a] cursor-pointer border-b border-gray-100 dark:border-[#3f4042] transition-colors user-row"
                             data-id="${item.partner_id}" data-name="${item.partner_name}" data-avatar="${avatar}">
                            <img src="${avatar}" class="w-10 h-10 rounded-full object-cover">
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline">
                                    <h5 class="font-bold text-sm text-gray-900 dark:text-white truncate">${item.partner_name}</h5>
                                    <span class="text-xs text-gray-400">${(item.last_time || '').split(' ')[1]?.substring(0,5)}</span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">${escapeHtml(lastMsg)}</p>
                            </div>
                        </div>`;
                    });
                    chatListView.innerHTML = html;
                    
                    document.querySelectorAll('.user-row').forEach(row => {
                        row.addEventListener('click', function() {
                            openChatWith(this.dataset.id, this.dataset.name, this.dataset.avatar);
                        });
                    });
                }
            });
    }


    if(mainChatToggle) {
        mainChatToggle.addEventListener('click', function() {
            if (chatWidget.classList.contains('translate-y-0')) {
                chatWidget.classList.remove('translate-y-0');
                chatWidget.classList.add('translate-y-[120%]');
            } else {
                chatWidget.classList.remove('translate-y-[120%]');
                chatWidget.classList.add('translate-y-0');
                switchView('list');
                
                totalUnread = 0;
                if(notifBadge) notifBadge.classList.add('hidden');
            }
        });
    }

    if(btnBackList) btnBackList.addEventListener('click', () => switchView('list'));
    
    if(closeChatBtn) {
        closeChatBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            
            chatWidget.classList.remove('translate-y-0');
            chatWidget.classList.add('translate-y-[120%]');
            
            setTimeout(() => {
                switchView('list'); 
                receiverId = 0; 
            }, 300); 
        });
    }

    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-open-chat'); 
        if (btn) {
            const uid = btn.getAttribute('data-id');
            const uname = btn.getAttribute('data-name');
            const uavatar = btn.getAttribute('data-avatar');
            openChatWith(uid, uname, uavatar);
        }
    });

    var conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function(e) {
        console.log("Socket OK");
        if(chatHeaderStatus) chatHeaderStatus.textContent = "Đang online"; 
        conn.send(JSON.stringify({ type: 'register', user_id: currentUserId }));
    };
    const notifSound = document.getElementById('notif-sound');
    const notifBadge = document.getElementById('main-unread-badge');
    let totalUnread = 0; 

    conn.onmessage = function(e) {
        var data = JSON.parse(e.data);
        
        if (data.type == 'chat_messages') {
            const isWidgetOpen = !chatWidget.classList.contains('translate-y-[120%]'); 
            const isChattingWithSender = (data.from_id == receiverId); 
            const isDetailView = !chatDetailView.classList.contains('hidden');

            if (isWidgetOpen && isChattingWithSender && isDetailView) {
                appendReceivedMessage(data.content, data.time, data.avatar);
            } else {
                totalUnread++;
                if(notifBadge) {
                    notifBadge.textContent = totalUnread > 9 ? '9+' : totalUnread;
                    notifBadge.classList.remove('hidden');
                    notifBadge.parentElement.classList.add('animate-pulse'); 
                }

                if(notifSound) {
                    notifSound.currentTime = 0;
                    notifSound.play().catch(err => console.log("Chặn tự phát âm thanh:", err));
                }

                if (isWidgetOpen && !chatListView.classList.contains('hidden')) {
                    loadInbox();
                }
            }
        }
    };

    if(chatForm) {
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const msgText = chatInput.value.trim();
            if (!msgText || receiverId === 0) return;

            appendMyMessage(msgText);
            chatInput.value = '';

            fetch(BASE_URL + 'chat/send', { 
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ receiver_id: receiverId, message: msgText, sender_avatar: currentUserAvatar })
            });
        });
    }

    function loadChatHistory(partnerId) {
        chatMessages.innerHTML = '<div class="text-center text-gray-400 text-sm p-4">Đang tải...</div>';
        fetch(`${BASE_URL}chat/history?partner_id=${partnerId}`)
            .then(r => r.json())
            .then(data => {
                chatMessages.innerHTML = '';
                if (data.status === 'success') {
                    if(data.data.length === 0) chatMessages.innerHTML = '<div class="text-center text-gray-400 text-sm p-4">Hãy nói xin chào!</div>';
                    data.data.forEach(msg => {
                        let time = (msg.created_at || '').split(' ')[1]?.substring(0, 5) || '';
                        if (msg.from_id == currentUserId) appendMyMessage(msg.content);
                        else appendReceivedMessage(msg.content, time, receiverAvatar);
                    });
                    scrollToBottom();
                }
            });
    }

    function appendMyMessage(text) {
        const html = `<div class="flex items-start gap-2.5 justify-end animate-fade-in-up"><div class="flex flex-col w-full max-w-[320px] leading-1.5 items-end"><div class="flex flex-col leading-relaxed p-3 border-gray-200 bg-[#f48024] text-white rounded-s-xl rounded-ee-xl shadow-sm"><p class="text-sm font-normal">${escapeHtml(text)}`;
        chatMessages.insertAdjacentHTML('beforeend', html);
        scrollToBottom();
    }

    function appendReceivedMessage(text, time, avatar) {
        const safeAvatar = getAvatarUrl(avatar);
        const html = `<div class="flex items-start gap-2.5 animate-fade-in-up"><img src="${safeAvatar}" class="w-8 h-8 rounded-full object-cover mt-1"><div class="flex flex-col w-full max-w-[320px] leading-1.5"><div class="flex items-center space-x-2 rtl:space-x-reverse"><span class="text-sm font-semibold text-gray-900 dark:text-white">${receiverName}</span><span class="text-sm font-normal text-gray-500 dark:text-gray-400">${time}</span></div><div class="flex flex-col leading-relaxed p-3 border-gray-200 bg-white dark:bg-[#3f4042] rounded-e-xl rounded-es-xl dark:border-gray-600 shadow-sm"><p class="text-sm font-normal text-gray-900 dark:text-white">${escapeHtml(text)}</p></div></div></div>`;
        chatMessages.insertAdjacentHTML('beforeend', html);
        scrollToBottom();
    }

    function scrollToBottom() { if(chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight; }
    function escapeHtml(text) { return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;"); }

    const style = document.createElement('style');
    style.innerHTML = `.animate-fade-in-up { animation: fadeInUp 0.3s ease-out forwards; } @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }`;
    document.head.appendChild(style);
});
</script>