@auth
<style>
    /* ═══ Floating Chat Widget ═══ */
    .chat-floating-btn {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 1050;
        display: flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, var(--green-brand, #00A740), #059669);
        color: #ffffff;
        border: none;
        padding: 12px 20px;
        border-radius: 999px;
        box-shadow: 0 10px 25px rgba(0, 167, 64, 0.35);
        cursor: pointer;
        font-family: var(--font-montserrat, sans-serif);
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .chat-floating-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 14px 30px rgba(0, 167, 64, 0.45);
        color: white;
    }

    .chat-floating-btn i {
        font-size: 1.25rem;
    }

    .chat-unread-badge {
        background: #ef4444;
        color: white;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 999px;
        box-shadow: 0 0 0 2px #ffffff;
        display: none;
    }

    /* ═══ Chat Box Window ═══ */
    .chat-widget-window {
        position: fixed;
        bottom: 85px;
        right: 24px;
        width: 380px;
        max-width: calc(100vw - 32px);
        height: 520px;
        max-height: calc(100vh - 110px);
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.22);
        border: 1px solid #e2e8f0;
        z-index: 1051;
        display: none;
        flex-direction: column;
        overflow: hidden;
        animation: chatSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes chatSlideUp {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.96);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .chat-widget-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .chat-header-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--green-brand, #00A740), #10b981);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-montserrat, sans-serif);
        font-weight: 800;
        font-size: 0.9rem;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .chat-user-meta strong {
        display: block;
        font-size: 0.92rem;
        font-family: var(--font-montserrat, sans-serif);
        color: #f8fafc;
        line-height: 1.2;
    }

    .chat-user-meta span {
        font-size: 0.75rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .online-indicator {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #10b981;
        display: inline-block;
    }

    .chat-header-actions {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .chat-header-btn {
        background: none;
        border: none;
        color: #cbd5e1;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        transition: all 0.2s;
    }

    .chat-header-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    /* ═══ Reference Banner (Cattle / Transaction) ═══ */
    .chat-reference-box {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 8px 14px;
        display: none;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 0.8rem;
    }

    .chat-ref-content {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow: hidden;
    }

    .chat-ref-img {
        width: 34px;
        height: 34px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #cbd5e1;
        flex-shrink: 0;
    }

    .chat-ref-text strong {
        display: block;
        color: #0f172a;
        font-size: 0.82rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-ref-text span {
        color: #64748b;
        font-size: 0.74rem;
        display: block;
    }

    /* ═══ Contacts Drawer (switch conversations) ═══ */
    .chat-conversations-drawer {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        max-height: 200px;
        overflow-y: auto;
        display: none;
    }

    .chat-conversation-item {
        padding: 10px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        transition: background 0.2s;
    }

    .chat-conversation-item:hover {
        background: #f8fafc;
    }

    .chat-conversation-item.active {
        background: rgba(0, 167, 64, 0.08);
    }

    /* ═══ Message Feed ═══ */
    .chat-messages-body {
        flex: 1;
        overflow-y: auto;
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background: #fdfdfd;
    }

    .chat-bubble {
        max-width: 80%;
        padding: 9px 13px;
        border-radius: 14px;
        font-size: 0.88rem;
        line-height: 1.45;
        position: relative;
        word-wrap: break-word;
    }

    .chat-bubble.incoming {
        align-self: flex-start;
        background: #f1f5f9;
        color: #0f172a;
        border-bottom-left-radius: 4px;
    }

    .chat-bubble.outgoing {
        align-self: flex-end;
        background: var(--green-brand, #00A740);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .chat-bubble-time {
        font-size: 0.68rem;
        margin-top: 4px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 4px;
        opacity: 0.8;
    }

    .chat-bubble.incoming .chat-bubble-time {
        color: #64748b;
    }

    .chat-bubble.outgoing .chat-bubble-time {
        color: rgba(255, 255, 255, 0.9);
    }

    .chat-empty-hint {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #94a3b8;
        font-size: 0.85rem;
    }

    .chat-empty-hint i {
        font-size: 2.2rem;
        color: #cbd5e1;
        display: block;
        margin-bottom: 8px;
    }

    /* ═══ Quick Suggestions ═══ */
    .chat-quick-replies {
        display: flex;
        gap: 6px;
        padding: 6px 14px;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .chat-quick-replies::-webkit-scrollbar {
        display: none;
    }

    .quick-reply-chip {
        white-space: nowrap;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .quick-reply-chip:hover {
        background: rgba(0, 167, 64, 0.1);
        color: var(--green-brand, #00A740);
        border-color: var(--green-brand, #00A740);
    }

    /* ═══ Input Footer ═══ */
    .chat-widget-footer {
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chat-input-field {
        flex: 1;
        border: 1px solid #cbd5e1;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 0.88rem;
        outline: none;
        font-family: inherit;
        background: #f8fafc;
        transition: border-color 0.2s;
    }

    .chat-input-field:focus {
        border-color: var(--green-brand, #00A740);
        background: #ffffff;
    }

    .chat-btn-send {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--green-brand, #00A740);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: transform 0.2s, background 0.2s;
        flex-shrink: 0;
    }

    .chat-btn-send:hover {
        background: #059669;
        transform: scale(1.05);
    }

    /* Mobile Chat Optimization */
    @media (max-width: 640px) {
        .chat-floating-btn {
            bottom: 18px;
            right: 16px;
            padding: 9px 15px;
            font-size: 0.82rem;
        }
        .chat-widget-window {
            bottom: 0;
            right: 0;
            left: 0;
            top: 0;
            width: 100vw;
            max-width: 100vw;
            height: 100vh;
            max-height: 100vh;
            border-radius: 0;
            border: none;
            z-index: 9999;
        }
        .chat-widget-header {
            padding: 14px 16px;
            border-radius: 0;
        }
        .chat-input-field {
            font-size: 16px; /* Prevents mobile Safari auto-zoom on input focus */
        }
    }
</style>

{{-- Floating Chat Trigger Button --}}
<button type="button" class="chat-floating-btn" id="chatFloatingBtn" onclick="toggleChatWindow()">
    <i class="bi bi-chat-dots-fill"></i>
    <span>Chat</span>
    <span class="chat-unread-badge" id="chatFloatingBadge">0</span>
</button>

{{-- Chat Window --}}
<div class="chat-widget-window" id="chatWidgetWindow">
    {{-- Window Header --}}
    <div class="chat-widget-header">
        <div class="chat-header-user">
            <div class="chat-avatar" id="chatHeaderAvatar">?</div>
            <div class="chat-user-meta">
                <strong id="chatHeaderName">Pilih Obrolan</strong>
                <span><span class="online-indicator"></span> <span id="chatHeaderRole">Penjual / Pembeli</span></span>
            </div>
        </div>

        <div class="chat-header-actions">
            <button type="button" class="chat-header-btn" onclick="toggleConversationsDrawer()" title="Daftar Percakapan">
                <i class="bi bi-people"></i>
            </button>
            <button type="button" class="chat-header-btn" onclick="toggleChatWindow()" title="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>

    {{-- Conversations Switcher Drawer --}}
    <div class="chat-conversations-drawer" id="chatConversationsDrawer"></div>

    {{-- Context Reference Banner --}}
    <div class="chat-reference-box" id="chatReferenceBox">
        <div class="chat-ref-content">
            <img src="" alt="Thumbnail" class="chat-ref-img" id="chatRefThumb">
            <div class="chat-ref-text">
                <strong id="chatRefTitle">Pesanan</strong>
                <span id="chatRefSubtitle">Detail Sapi</span>
            </div>
        </div>
        <button type="button" onclick="dismissChatReference()" style="background: none; border: none; color: #94a3b8; font-size: 1.1rem; cursor: pointer;">&times;</button>
    </div>

    {{-- Messages Feed --}}
    <div class="chat-messages-body" id="chatMessagesBody">
        <div class="chat-empty-hint">
            <i class="bi bi-chat-square-text"></i>
            <span>Pilih pesan atau hubungi pembeli/penjual untuk memulai percakapan.</span>
        </div>
    </div>

    {{-- Quick Replies --}}
    <div class="chat-quick-replies" id="chatQuickReplies">
        <button type="button" class="quick-reply-chip" onclick="sendQuickReply('Halo, apakah sapi ready?')">Halo, apakah sapi ready?</button>
        <button type="button" class="quick-reply-chip" onclick="sendQuickReply('Kapan perkiraan sampai?')">Kapan perkiraan sampai?</button>
        <button type="button" class="quick-reply-chip" onclick="sendQuickReply('Surat keterangan sudah terbit?')">Surat sudah terbit?</button>
        <button type="button" class="quick-reply-chip" onclick="sendQuickReply('Terima kasih banyak!')">Terima kasih banyak!</button>
    </div>

    {{-- Input Form --}}
    <form class="chat-widget-footer" id="chatWidgetForm" onsubmit="handleChatSubmit(event)">
        @csrf
        <input type="hidden" id="chatInputRecipientId" value="">
        <input type="hidden" id="chatInputTransaksiId" value="">
        <input type="hidden" id="chatInputSapiId" value="">

        <input type="text" class="chat-input-field" id="chatInputText" placeholder="Ketik pesan Anda..." autocomplete="off">
        <button type="submit" class="chat-btn-send" id="chatSendBtn" title="Kirim Pesan">
            <i class="bi bi-send-fill"></i>
        </button>
    </form>
</div>

<script>
    let activeChatRecipientId = null;
    let activeChatTransaksiId = null;
    let activeChatSapiId = null;
    let chatPollTimer = null;
    let isChatOpen = false;

    // Inisialisasi pengecekan unread chat saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        checkUnreadChatCount();
        // Cek unread setiap 15 detik
        setInterval(checkUnreadChatCount, 15000);
    });

    function toggleChatWindow() {
        const win = document.getElementById('chatWidgetWindow');
        isChatOpen = !isChatOpen;
        
        if (isChatOpen) {
            win.style.display = 'flex';
            if (!activeChatRecipientId) {
                // Buka daftar percakapan jika belum ada lawan bicara aktif
                loadConversationsList();
                toggleConversationsDrawer(true);
            } else {
                fetchMessages();
                startChatPolling();
            }
        } else {
            win.style.display = 'none';
            stopChatPolling();
        }
    }

    function toggleConversationsDrawer(forceOpen = null) {
        const drawer = document.getElementById('chatConversationsDrawer');
        if (forceOpen !== null) {
            drawer.style.display = forceOpen ? 'block' : 'none';
        } else {
            drawer.style.display = drawer.style.display === 'block' ? 'none' : 'block';
        }
        if (drawer.style.display === 'block') {
            loadConversationsList();
        }
    }

    function checkUnreadChatCount() {
        fetch('/chat/unread-count')
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const badge = document.getElementById('chatFloatingBadge');
                    const navBadges = document.querySelectorAll('.nav-chat-badge');
                    
                    if (data.unread_count > 0) {
                        if (badge) {
                            badge.innerText = data.unread_count;
                            badge.style.display = 'inline-block';
                        }
                        navBadges.forEach(b => {
                            b.innerText = data.unread_count;
                            b.style.display = 'inline-flex';
                        });
                    } else {
                        if (badge) badge.style.display = 'none';
                        navBadges.forEach(b => b.style.display = 'none');
                    }
                }
            })
            .catch(() => {});
    }

    /**
     * Buka obrolan langsung dengan pengguna tertentu dan konteks pesanan/sapi
     */
    window.openChatWith = function(userId, userName, userRole, transaksiId = null, sapiId = null, refTitle = '', refThumb = '') {
        activeChatRecipientId = userId;
        activeChatTransaksiId = transaksiId;
        activeChatSapiId = sapiId;

        document.getElementById('chatInputRecipientId').value = userId;
        document.getElementById('chatInputTransaksiId').value = transaksiId || '';
        document.getElementById('chatInputSapiId').value = sapiId || '';

        // Update header UI
        document.getElementById('chatHeaderName').innerText = userName;
        document.getElementById('chatHeaderRole').innerText = userRole;
        document.getElementById('chatHeaderAvatar').innerText = userName.substring(0, 2).toUpperCase();

        // Update context reference banner
        const refBox = document.getElementById('chatReferenceBox');
        if (refTitle) {
            document.getElementById('chatRefTitle').innerHTML = refTitle;
            document.getElementById('chatRefSubtitle').innerHTML = transaksiId ? 'Terkait pesanan sapi ini' : 'Konsultasi ternak sapi';
            const thumbImg = document.getElementById('chatRefThumb');
            if (refThumb) {
                thumbImg.src = refThumb;
                thumbImg.style.display = 'block';
            } else {
                thumbImg.style.display = 'none';
            }
            refBox.style.display = 'flex';
        } else {
            refBox.style.display = 'none';
        }

        // Buka chat window
        const win = document.getElementById('chatWidgetWindow');
        win.style.display = 'flex';
        isChatOpen = true;
        document.getElementById('chatConversationsDrawer').style.display = 'none';

        fetchMessages();
        startChatPolling();

        // Fokus ke input
        setTimeout(() => {
            const input = document.getElementById('chatInputText');
            if (input) input.focus();
        }, 200);
    };

    function dismissChatReference() {
        document.getElementById('chatReferenceBox').style.display = 'none';
    }

    function fetchMessages() {
        if (!activeChatRecipientId) return;

        let url = `/chat/messages?user_id=${activeChatRecipientId}`;
        if (activeChatTransaksiId) url += `&transaksi_id=${activeChatTransaksiId}`;
        if (activeChatSapiId) url += `&sapi_id=${activeChatSapiId}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    renderMessages(data.messages);
                    checkUnreadChatCount();
                }
            })
            .catch(() => {});
    }

    function renderMessages(messages) {
        const body = document.getElementById('chatMessagesBody');
        
        if (!messages || messages.length === 0) {
            body.innerHTML = `
                <div class="chat-empty-hint">
                    <i class="bi bi-chat-heart"></i>
                    <span>Belum ada pesan. Mulai obrolan dengan mengetik pesan di bawah ini!</span>
                </div>
            `;
            return;
        }

        let html = '';
        messages.forEach(msg => {
            const bubbleClass = msg.is_me ? 'outgoing' : 'incoming';
            const checkIcon = msg.is_me 
                ? (msg.is_read ? '<i class="bi bi-check2-all" style="color: #67e8f9;"></i>' : '<i class="bi bi-check2"></i>') 
                : '';

            html += `
                <div class="chat-bubble ${bubbleClass}">
                    <div>${escapeHtml(msg.pesan)}</div>
                    <div class="chat-bubble-time">
                        <span>${msg.waktu}</span>
                        ${checkIcon}
                    </div>
                </div>
            `;
        });

        body.innerHTML = html;
        body.scrollTop = body.scrollHeight;
    }

    function handleChatSubmit(e) {
        e.preventDefault();
        const input = document.getElementById('chatInputText');
        const text = input.value.trim();
        if (!text || !activeChatRecipientId) return;

        sendMessageToServer(text);
        input.value = '';
    }

    function sendQuickReply(text) {
        if (!activeChatRecipientId) return;
        sendMessageToServer(text);
    }

    function sendMessageToServer(text) {
        const token = document.querySelector('meta[name="csrf-token"]') 
            ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            : '{{ csrf_token() }}';

        const payload = {
            _token: token,
            penerima_id: activeChatRecipientId,
            pesan: text,
            transaksi_id: activeChatTransaksiId || null,
            sapi_id: activeChatSapiId || null,
        };

        // Render langsung secara optimis
        const body = document.getElementById('chatMessagesBody');
        const tempBubble = document.createElement('div');
        tempBubble.className = 'chat-bubble outgoing';
        tempBubble.innerHTML = `
            <div>${escapeHtml(text)}</div>
            <div class="chat-bubble-time"><span>Baru saja</span> <i class="bi bi-clock"></i></div>
        `;
        // Hapus empty hint jika ada
        const emptyHint = body.querySelector('.chat-empty-hint');
        if (emptyHint) emptyHint.remove();

        body.appendChild(tempBubble);
        body.scrollTop = body.scrollHeight;

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                fetchMessages();
            }
        })
        .catch(err => {
            console.error('Gagal mengirim pesan:', err);
        });
    }

    function startChatPolling() {
        stopChatPolling();
        chatPollTimer = setInterval(fetchMessages, 3500);
    }

    function stopChatPolling() {
        if (chatPollTimer) {
            clearInterval(chatPollTimer);
            chatPollTimer = null;
        }
    }

    function loadConversationsList() {
        const drawer = document.getElementById('chatConversationsDrawer');
        drawer.innerHTML = '<div style="padding: 12px; text-align: center; color: #94a3b8; font-size: 0.8rem;"><i class="bi bi-arrow-repeat spin"></i> Memuat kontak...</div>';

        fetch('/chat/conversations')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.conversations.length > 0) {
                    let html = '';
                    data.conversations.forEach(c => {
                        const isActive = c.partner_id == activeChatRecipientId ? 'active' : '';
                        const unreadBadge = c.unread > 0 
                            ? `<span style="background: #ef4444; color: white; font-size: 0.7rem; font-weight: bold; padding: 1px 6px; border-radius: 999px;">${c.unread}</span>` 
                            : '';

                        html += `
                            <div class="chat-conversation-item ${isActive}" onclick="window.openChatWith(${c.partner_id}, '${escapeHtml(c.name)}', '${c.role}', ${c.transaksi_id || 'null'}, ${c.sapi_id || 'null'})">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div class="chat-avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">${c.initials}</div>
                                    <div>
                                        <strong style="font-size: 0.85rem; color: #0f172a; display: block;">${escapeHtml(c.name)}</strong>
                                        <span style="font-size: 0.72rem; color: #64748b; white-space: nowrap; max-width: 180px; overflow: hidden; text-overflow: ellipsis; display: block;">${escapeHtml(c.last_message)}</span>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <span style="font-size: 0.68rem; color: #94a3b8; display: block;">${c.last_time}</span>
                                    ${unreadBadge}
                                </div>
                            </div>
                        `;
                    });
                    drawer.innerHTML = html;
                } else {
                    drawer.innerHTML = '<div style="padding: 14px; text-align: center; color: #94a3b8; font-size: 0.8rem;">Belum ada riwayat kontak. Buka pesanan atau katalog untuk memulai chat.</div>';
                }
            })
            .catch(() => {
                drawer.innerHTML = '<div style="padding: 12px; text-align: center; color: #ef4444; font-size: 0.8rem;">Gagal memuat kontak.</div>';
            });
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
</script>
@endauth
