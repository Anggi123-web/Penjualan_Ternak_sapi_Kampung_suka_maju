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
        animation: chatBadgePulse 2s infinite ease-in-out;
    }

    @keyframes chatBadgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
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
        background: var(--bg-card, #ffffff);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.22);
        border: 1px solid var(--border-color, #e2e8f0);
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

    /* Views Layout */
    .chat-view {
        display: flex;
        flex-direction: column;
        flex: 1;
        height: 100%;
        min-height: 0;
        overflow: hidden;
    }

    .chat-widget-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        flex-shrink: 0;
    }

    /* Tombol Kembali yang Jelas & Nyaman */
    .chat-back-btn {
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.22);
        color: #ffffff;
        height: 32px;
        padding: 0 10px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        font-size: 0.78rem;
        font-weight: 700;
        font-family: inherit;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .chat-back-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
        transform: translateX(-2px);
    }

    .chat-header-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--green-brand, #00A740), #10b981);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-montserrat, sans-serif);
        font-weight: 800;
        font-size: 0.88rem;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .chat-user-meta strong {
        display: block;
        font-size: 0.9rem;
        font-family: var(--font-montserrat, sans-serif);
        color: #f8fafc;
        line-height: 1.2;
    }

    .chat-user-meta span {
        font-size: 0.72rem;
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
        flex-shrink: 0;
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

    /* ═══ View 1: Contacts & Conversation List ═══ */
    .chat-list-search {
        padding: 10px 14px;
        background: var(--bg-card, #ffffff);
        border-bottom: 1px solid var(--border-color, #e2e8f0);
        flex-shrink: 0;
    }

    .chat-search-input {
        width: 100%;
        padding: 7px 12px 7px 32px;
        background: var(--bg-muted, #f1f5f9);
        border: 1px solid var(--border-color, #e2e8f0);
        border-radius: 10px;
        font-size: 0.82rem;
        color: var(--text-primary, #0f172a);
        outline: none;
        box-sizing: border-box;
        transition: all 0.2s;
    }

    .chat-search-input:focus {
        border-color: var(--green-brand, #00A740);
        background: var(--bg-card, #ffffff);
    }

    .chat-conversations-list-body {
        flex: 1;
        overflow-y: auto;
        background: var(--bg-card, #ffffff);
    }

    .chat-conversation-item {
        padding: 12px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--border-color, #f1f5f9);
        cursor: pointer;
        transition: background 0.2s;
        gap: 10px;
    }

    .chat-conversation-item:hover {
        background: var(--bg-muted, #f8fafc);
    }

    .chat-conversation-item.active {
        background: rgba(16, 185, 129, 0.1);
    }

    /* ═══ Reference Banner (Cattle / Transaction) ═══ */
    .chat-reference-box {
        background: var(--bg-surface, #f8fafc);
        border-bottom: 1px solid var(--border-color, #e2e8f0);
        padding: 8px 14px;
        display: none;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 0.8rem;
        flex-shrink: 0;
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
        border: 1px solid var(--border-color, #cbd5e1);
        flex-shrink: 0;
    }

    .chat-ref-text strong {
        display: block;
        color: var(--text-heading, #0f172a);
        font-size: 0.82rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-ref-text span {
        color: var(--text-secondary, #64748b);
        font-size: 0.74rem;
        display: block;
    }

    /* ═══ Message Feed ═══ */
    .chat-messages-body {
        flex: 1;
        overflow-y: auto;
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background: var(--bg-page, #fdfdfd);
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
        background: var(--bg-surface, #f1f5f9);
        color: var(--text-primary, #0f172a);
        border: 1px solid var(--border-color, #e2e8f0);
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
        opacity: 0.85;
    }

    .chat-bubble.incoming .chat-bubble-time {
        color: var(--text-muted, #64748b);
    }

    .chat-bubble.outgoing .chat-bubble-time {
        color: rgba(255, 255, 255, 0.9);
    }

    .chat-empty-hint {
        text-align: center;
        padding: 2.5rem 1rem;
        color: var(--text-muted, #94a3b8);
        font-size: 0.85rem;
    }

    .chat-empty-hint i {
        font-size: 2.2rem;
        color: var(--text-muted, #cbd5e1);
        display: block;
        margin-bottom: 8px;
    }

    /* ═══ Quick Suggestions ═══ */
    .chat-quick-replies {
        display: flex;
        gap: 6px;
        padding: 6px 12px;
        background: var(--bg-card, #ffffff);
        border-top: 1px solid var(--border-color, #f1f5f9);
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        flex-shrink: 0;
    }

    .chat-quick-replies::-webkit-scrollbar {
        display: none;
    }

    .quick-reply-chip {
        background: var(--bg-surface, #f1f5f9);
        color: var(--text-primary, #0f172a);
        border: 1px solid var(--border-color, #e2e8f0);
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.74rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .quick-reply-chip:hover {
        background: rgba(0, 167, 64, 0.12);
        color: var(--green-brand, #00A740);
        border-color: var(--green-brand, #00A740);
    }

    /* ═══ Chat Footer Input ═══ */
    .chat-widget-footer {
        padding: 10px 14px;
        background: var(--bg-card, #ffffff);
        border-top: 1px solid var(--border-color, #e2e8f0);
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .chat-input-field {
        flex: 1;
        padding: 8px 14px;
        background: var(--bg-muted, #f8fafc);
        border: 1px solid var(--border-color, #e2e8f0);
        border-radius: 999px;
        font-size: 0.86rem;
        font-family: inherit;
        outline: none;
        color: var(--text-primary, #0f172a);
        transition: border-color 0.2s;
    }

    .chat-input-field:focus {
        border-color: var(--green-brand, #00A740);
        background: var(--bg-surface, #ffffff);
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
            font-size: 16px;
        }
    }

    /* Dark Mode Theme Support */
    [data-theme="dark"] .chat-widget-window {
        background: #131d31;
        border-color: #27354f;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    }
    [data-theme="dark"] .chat-list-search {
        background: #131d31;
        border-bottom-color: #27354f;
    }
    [data-theme="dark"] .chat-search-input {
        background: #0b1120;
        border-color: #334155;
        color: #f8fafc;
    }
    [data-theme="dark"] .chat-search-input:focus {
        background: #131d31;
        border-color: var(--green-brand, #10b981);
    }
    [data-theme="dark"] .chat-conversations-list-body {
        background: #131d31;
    }
    [data-theme="dark"] .chat-conversation-item {
        border-bottom-color: #1e293b;
    }
    [data-theme="dark"] .chat-conversation-item:hover {
        background: #1e293b;
    }
    [data-theme="dark"] .chat-conversation-item strong {
        color: #f8fafc;
    }
    [data-theme="dark"] .chat-messages-body {
        background: #0b1120;
    }
    [data-theme="dark"] .chat-bubble.incoming {
        background: #1e293b;
        color: #f8fafc;
        border: 1px solid rgba(148, 163, 184, 0.15);
    }
    [data-theme="dark"] .chat-bubble.incoming .chat-bubble-time {
        color: #94a3b8;
    }
    [data-theme="dark"] .chat-quick-replies,
    [data-theme="dark"] .chat-widget-footer {
        background: #131d31;
        border-top-color: #27354f;
    }
    [data-theme="dark"] .quick-reply-chip {
        background: #1e293b;
        color: #cbd5e1;
        border-color: #334155;
    }
    [data-theme="dark"] .chat-input-field {
        background: #0b1120;
        color: #f8fafc;
        border-color: #334155;
    }
    [data-theme="dark"] .chat-input-field:focus {
        background: #131d31;
        border-color: var(--green-brand, #10b981);
    }
</style>

{{-- Floating Chat Trigger Button --}}
@php
    $floatingUnreadChat = 0;
    if (auth()->check()) {
        $floatingUnreadChat = \App\Models\Chat::where('penerima_id', auth()->id())->where('is_read', false)->count();
    }
@endphp
<button type="button" class="chat-floating-btn" id="chatFloatingBtn" onclick="toggleChatWindow()" title="Buka Pesan & Chat">
    <i class="bi bi-chat-dots-fill"></i>
    <span>Chat</span>
    <span class="chat-unread-badge" id="chatFloatingBadge" style="{{ $floatingUnreadChat > 0 ? 'display: inline-block;' : 'display: none;' }}">{{ $floatingUnreadChat }}</span>
</button>

{{-- Chat Window --}}
<div class="chat-widget-window" id="chatWidgetWindow">

    {{-- VIEW 1: DAFTAR PERCAKAPAN (PILIH KONTAK OBROLAN) --}}
    <div class="chat-view" id="chatViewList">
        <div class="chat-widget-header">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-chat-dots-fill" style="color: var(--green-brand, #10b981); font-size: 1.15rem;"></i>
                <strong style="font-size: 0.95rem; color: #ffffff; font-family: var(--font-montserrat, sans-serif);">Daftar Obrolan</strong>
            </div>
            <div class="chat-header-actions">
                <button type="button" class="chat-header-btn" onclick="toggleChatWindow()" title="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>

        {{-- Input Pencarian Kontak --}}
        <div class="chat-list-search">
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted, #94a3b8); font-size: 0.8rem;"></i>
                <input type="text" class="chat-search-input" id="chatSearchInput" placeholder="Cari kontak atau obrolan..." oninput="handleSearchConversations(event)" autocomplete="off">
            </div>
        </div>

        {{-- Daftar Percakapan Dinamis --}}
        <div class="chat-conversations-list-body" id="chatConversationsList"></div>
    </div>

    {{-- VIEW 2: RUANG OBROLAN AKTIF (DENGAN TOMBOL KEMBALI) --}}
    <div class="chat-view" id="chatViewRoom" style="display: none;">
        {{-- Window Header dengan Tombol Kembali --}}
        <div class="chat-widget-header">
            <div style="display: flex; align-items: center; gap: 8px; min-width: 0; flex: 1;">
                {{-- Tombol Kembali --}}
                <button type="button" class="chat-back-btn" onclick="showConversationsList()" title="Kembali ke Daftar Obrolan">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali</span>
                </button>

                <div class="chat-header-user" style="min-width: 0; flex: 1;">
                    <div class="chat-avatar" id="chatHeaderAvatar">?</div>
                    <div class="chat-user-meta" style="min-width: 0;">
                        <strong id="chatHeaderName" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Pilih Obrolan</strong>
                        <span><span class="online-indicator"></span> <span id="chatHeaderRole">Penjual / Pembeli</span></span>
                    </div>
                </div>
            </div>

            <div class="chat-header-actions">
                <button type="button" class="chat-header-btn" onclick="toggleChatWindow()" title="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>

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

</div>

<script>
    let activeChatRecipientId = null;
    let activeChatTransaksiId = null;
    let activeChatSapiId = null;
    let chatPollTimer = null;
    let isChatOpen = false;
    let allConversations = [];

    // Inisialisasi pengecekan unread chat saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        checkUnreadChatCount();
        // Cek unread setiap 15 detik
        setInterval(checkUnreadChatCount, 15000);
    });

    /**
     * Buka / Tutup Jendela Chat
     */
    function toggleChatWindow() {
        const win = document.getElementById('chatWidgetWindow');
        isChatOpen = !isChatOpen;
        
        if (isChatOpen) {
            win.style.display = 'flex';
            if (!activeChatRecipientId) {
                // Tampilkan daftar obrolan untuk memilih dengan siapa ingin chatan
                showConversationsList();
            } else {
                // Tampilkan ruang obrolan yang sedang aktif
                const viewList = document.getElementById('chatViewList');
                const viewRoom = document.getElementById('chatViewRoom');
                if (viewList) viewList.style.display = 'none';
                if (viewRoom) viewRoom.style.display = 'flex';
                fetchMessages();
                startChatPolling();
            }
        } else {
            win.style.display = 'none';
            stopChatPolling();
        }
    }

    /**
     * Tampilkan Layar Daftar Obrolan (Kembali dari ruang obrolan)
     */
    function showConversationsList() {
        stopChatPolling();
        activeChatRecipientId = null;

        const viewList = document.getElementById('chatViewList');
        const viewRoom = document.getElementById('chatViewRoom');
        if (viewList) viewList.style.display = 'flex';
        if (viewRoom) viewRoom.style.display = 'none';

        // Bersihkan input pencarian
        const searchInput = document.getElementById('chatSearchInput');
        if (searchInput) searchInput.value = '';

        loadConversationsList();
        checkUnreadChatCount();
    }

    /**
     * Alias kompatibilitas jika ada elemen lama yang memanggil toggleConversationsDrawer
     */
    function toggleConversationsDrawer() {
        showConversationsList();
    }

    /**
     * Filter daftar kontak saat user mengetik di kotak pencarian
     */
    function handleSearchConversations(e) {
        const query = e.target.value.toLowerCase().trim();
        if (!query) {
            renderConversations(allConversations);
            return;
        }

        const filtered = allConversations.filter(c => {
            const nameMatch = c.name && c.name.toLowerCase().includes(query);
            const roleMatch = c.role && c.role.toLowerCase().includes(query);
            const msgMatch = c.last_message && c.last_message.toLowerCase().includes(query);
            return nameMatch || roleMatch || msgMatch;
        });

        renderConversations(filtered);
    }

    /**
     * Render daftar kontak obrolan
     */
    function renderConversations(conversations) {
        const container = document.getElementById('chatConversationsList');
        if (!container) return;

        if (!conversations || conversations.length === 0) {
            container.innerHTML = `
                <div class="chat-empty-hint" style="padding: 3rem 1.5rem;">
                    <i class="bi bi-chat-left-dots" style="font-size: 2.2rem; color: var(--text-muted, #94a3b8); margin-bottom: 8px;"></i>
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-heading, #0f172a); margin: 0 0 4px 0;">Belum Ada Obrolan</h4>
                    <p style="font-size: 0.8rem; color: var(--text-muted, #94a3b8); margin: 0; line-height: 1.4;">
                        Pilih tombol <strong>Chat</strong> pada data pesanan atau katalog sapi untuk memulai obrolan baru.
                    </p>
                </div>
            `;
            return;
        }

        let html = '';
        conversations.forEach(c => {
            const isActive = c.partner_id == activeChatRecipientId ? 'active' : '';
            const unreadBadge = c.unread > 0 
                ? `<span style="background: #ef4444; color: white; font-size: 0.7rem; font-weight: 800; padding: 2px 7px; border-radius: 999px; box-shadow: 0 1px 3px rgba(239, 68, 68, 0.4);">${c.unread}</span>` 
                : '';

            let roleBadgeStyle = 'background: rgba(16, 185, 129, 0.15); color: #10b981;';
            if (c.role_raw === 'pembeli') {
                roleBadgeStyle = 'background: rgba(59, 130, 246, 0.15); color: #3b82f6;';
            } else if (c.role_raw === 'mantri_hewan') {
                roleBadgeStyle = 'background: rgba(245, 158, 11, 0.15); color: #f59e0b;';
            } else if (c.role_raw === 'pengurus_kampung') {
                roleBadgeStyle = 'background: rgba(139, 92, 246, 0.15); color: #8b5cf6;';
            }

            html += `
                <div class="chat-conversation-item ${isActive}" onclick="window.openChatWith(${c.partner_id}, '${escapeHtml(c.name)}', '${c.role}', ${c.transaksi_id || 'null'}, ${c.sapi_id || 'null'})">
                    <div class="chat-avatar" style="width: 40px; height: 40px; font-size: 0.85rem;">${c.initials}</div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                            <strong style="font-size: 0.88rem; color: var(--text-heading, #0f172a); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 170px;">
                                ${escapeHtml(c.name)}
                            </strong>
                            <span style="font-size: 0.7rem; color: var(--text-muted, #94a3b8); white-space: nowrap;">${c.last_time}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 6px;">
                            <span style="font-size: 0.78rem; color: var(--text-secondary, #64748b); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 190px;">
                                ${escapeHtml(c.last_message || 'Mulai percakapan...')}
                            </span>
                            <div style="display: flex; align-items: center; gap: 4px; flex-shrink: 0;">
                                <span style="font-size: 0.65rem; font-weight: 700; padding: 1px 6px; border-radius: 4px; ${roleBadgeStyle}">${c.role}</span>
                                ${unreadBadge}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    /**
     * Memuat daftar percakapan dari server
     */
    function loadConversationsList() {
        const container = document.getElementById('chatConversationsList');
        if (!container) return;

        container.innerHTML = '<div style="padding: 2rem; text-align: center; color: #94a3b8; font-size: 0.85rem;"><i class="bi bi-arrow-repeat spin"></i> Memuat daftar obrolan...</div>';

        fetch('/chat/conversations')
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    allConversations = data.conversations || [];
                    renderConversations(allConversations);
                } else {
                    container.innerHTML = '<div style="padding: 1.5rem; text-align: center; color: #ef4444; font-size: 0.8rem;">Gagal memuat kontak.</div>';
                }
            })
            .catch(() => {
                container.innerHTML = '<div style="padding: 1.5rem; text-align: center; color: #ef4444; font-size: 0.8rem;">Gagal memuat kontak.</div>';
            });
    }

    /**
     * Cek jumlah pesan yang belum terbaca
     */
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

        // Buka chat window & beralih ke View Ruang Obrolan
        const win = document.getElementById('chatWidgetWindow');
        win.style.display = 'flex';
        isChatOpen = true;

        const viewList = document.getElementById('chatViewList');
        const viewRoom = document.getElementById('chatViewRoom');
        if (viewList) viewList.style.display = 'none';
        if (viewRoom) viewRoom.style.display = 'flex';

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
        if (!body) return;
        
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

        // Render secara optimis
        const body = document.getElementById('chatMessagesBody');
        if (body) {
            const tempBubble = document.createElement('div');
            tempBubble.className = 'chat-bubble outgoing';
            tempBubble.innerHTML = `
                <div>${escapeHtml(text)}</div>
                <div class="chat-bubble-time"><span>Baru saja</span> <i class="bi bi-clock"></i></div>
            `;
            const emptyHint = body.querySelector('.chat-empty-hint');
            if (emptyHint) emptyHint.remove();

            body.appendChild(tempBubble);
            body.scrollTop = body.scrollHeight;
        }

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
