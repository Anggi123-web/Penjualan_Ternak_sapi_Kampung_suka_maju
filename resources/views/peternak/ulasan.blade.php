@extends('layouts.peternak', ['title' => 'Ulasan & Reputasi Peternak — Sistem Penjualan Sapi'])

@section('page-styles')
<style>
    .ulasan-page-wrapper {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header Ringkas & Modern */
    .ulasan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .ulasan-header-title {
        font-size: clamp(1.35rem, 3vw, 1.75rem);
        font-weight: 800;
        color: var(--text-heading);
        margin: 0;
        font-family: var(--font-montserrat, sans-serif);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ulasan-header-subtitle {
        color: var(--text-secondary);
        font-size: 0.88rem;
        margin-top: 4px;
        margin-bottom: 0;
        max-width: 600px;
    }

    /* Stat Cards Grid */
    .ulasan-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .ulasan-stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 1.25rem 1.35rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease;
        color: var(--text-primary);
    }

    .ulasan-stat-card:hover {
        transform: translateY(-2px);
    }

    .ulasan-stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.65rem;
        flex-shrink: 0;
    }

    .ulasan-stat-content {
        flex: 1;
        min-width: 0;
    }

    .ulasan-stat-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .ulasan-stat-val {
        font-size: 1.75rem;
        font-weight: 900;
        color: var(--text-heading);
        line-height: 1.15;
        margin-top: 2px;
        font-family: var(--font-montserrat, sans-serif);
    }

    /* Distribution Card */
    .ulasan-dist-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: var(--text-primary);
    }

    .dist-row {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.76rem;
        margin-bottom: 3px;
        color: var(--text-secondary);
    }

    .dist-bar-track {
        flex: 1;
        height: 6px;
        background: var(--bg-muted);
        border-radius: 999px;
        overflow: hidden;
    }

    .dist-bar-fill {
        height: 100%;
        background: #f59e0b;
        border-radius: 999px;
        transition: width 0.3s ease;
    }

    /* Filter Bar */
    .ulasan-filter-scroll {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        padding-bottom: 4px;
        margin-bottom: 1.25rem;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }

    .ulasan-filter-scroll::-webkit-scrollbar {
        display: none;
    }

    .ulasan-pill-btn {
        text-decoration: none;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
        border: 1px solid var(--border-color);
        background: var(--bg-card);
        color: var(--text-secondary);
        flex-shrink: 0;
    }

    .ulasan-pill-btn:hover {
        background: rgba(16, 185, 129, 0.15);
        color: var(--green-brand);
        border-color: rgba(16, 185, 129, 0.3);
    }

    .ulasan-pill-btn.active {
        background: #10b981;
        color: white;
        border-color: #10b981;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .ulasan-pill-btn.active-star {
        background: #f59e0b;
        color: white;
        border-color: #f59e0b;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }

    /* Review Card */
    .ulasan-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 1.25rem 1.35rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        margin-bottom: 1rem;
        transition: border-color 0.2s;
        color: var(--text-primary);
    }

    .ulasan-card:hover {
        border-color: rgba(16, 185, 129, 0.3);
    }

    .ulasan-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .buyer-info-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .buyer-avatar-circle {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .buyer-name-title {
        margin: 0;
        color: var(--text-heading);
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .buyer-meta-sub {
        color: var(--text-secondary);
        font-size: 0.76rem;
        margin-top: 2px;
    }

    .rating-badge-pill {
        background: rgba(245, 158, 11, 0.12);
        border: 1px solid rgba(245, 158, 11, 0.25);
        padding: 3px 10px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        flex-shrink: 0;
    }

    .comment-quote-box {
        color: var(--text-primary);
        font-size: 0.88rem;
        line-height: 1.5;
        margin: 0.75rem 0 0;
        background: var(--bg-muted);
        padding: 0.75rem 0.95rem;
        border-radius: 8px;
        border-left: 3px solid #f59e0b;
        border: 1px solid var(--border-color);
        border-left-width: 3px;
        border-left-color: #f59e0b;
    }

    .reply-bubble-box {
        margin-top: 0.85rem;
        background: rgba(16, 185, 129, 0.08);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 8px;
        padding: 0.75rem 0.95rem;
    }

    /* RESPONSIVE BREAKPOINTS */
    @media (max-width: 991px) {
        .ulasan-stats-grid {
            grid-template-columns: 1fr 1fr;
        }

        .ulasan-dist-card {
            grid-column: span 2;
        }
    }

    @media (max-width: 640px) {
        .ulasan-header {
            margin-bottom: 1rem;
        }

        .ulasan-header-subtitle {
            display: none;
        }

        .ulasan-stats-grid {
            grid-template-columns: 1fr;
            gap: 0.65rem;
            margin-bottom: 1rem;
        }

        .ulasan-dist-card {
            grid-column: span 1;
        }

        .ulasan-stat-card {
            padding: 0.85rem 1rem;
            gap: 0.85rem;
        }

        .ulasan-stat-icon {
            width: 44px;
            height: 44px;
            font-size: 1.35rem;
        }

        .ulasan-stat-val {
            font-size: 1.45rem;
        }

        .ulasan-card {
            padding: 0.95rem;
            border-radius: 12px;
        }

        .buyer-avatar-circle {
            width: 36px;
            height: 36px;
            font-size: 0.95rem;
        }

        .buyer-name-title {
            font-size: 0.88rem;
        }

        .buyer-meta-sub {
            font-size: 0.72rem;
        }

        .comment-quote-box {
            font-size: 0.84rem;
            padding: 0.65rem 0.8rem;
        }

        textarea {
            font-size: 16px !important; /* Cegah zoom otomatis iOS */
        }
    }
</style>
@endsection

@section('page-content')
<div class="ulasan-page-wrapper">
        {{-- Header Halaman --}}
        <div class="ulasan-header">
            <div>
                <h1 class="ulasan-header-title">
                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i> Ulasan & Reputasi Peternak
                </h1>
                <p class="ulasan-header-subtitle">
                    Pantau feedback kepuasan pembeli dan respon testimoni pelanggan untuk meningkatkan reputasi peternakan Anda.
                </p>
            </div>
            @if($totalUlasan > 0)
                <div>
                    <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); font-size: 0.8rem; font-weight: 700; padding: 5px 12px; border-radius: 999px; display: inline-flex; align-items: center; gap: 5px;">
                        <i class="bi bi-patch-check-fill"></i> Reputasi Aktif di Katalog
                    </span>
                </div>
            @endif
        </div>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 8px; font-size: 0.88rem;">
                <i class="bi bi-check-circle-fill" style="font-size: 1.1rem; flex-shrink: 0;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Ringkasan Statistik Rating (Responsif & Ringkas) --}}
        <div class="ulasan-stats-grid">
            {{-- Card 1: Rata-rata Skor Bintang --}}
            <div class="ulasan-stat-card">
                <div class="ulasan-stat-icon" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="ulasan-stat-content">
                    <div class="ulasan-stat-label">Rata-rata Rating</div>
                    <div class="ulasan-stat-val">
                        {{ $avgRating }} <span style="font-size: 0.95rem; color: #64748b; font-weight: 600;">/ 5.0</span>
                    </div>
                    <div style="color: #f59e0b; font-size: 0.85rem; margin-top: 1px;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Card 2: Total Ulasan --}}
            <div class="ulasan-stat-card">
                <div class="ulasan-stat-icon" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa;">
                    <i class="bi bi-chat-heart-fill"></i>
                </div>
                <div class="ulasan-stat-content">
                    <div class="ulasan-stat-label">Total Ulasan</div>
                    <div class="ulasan-stat-val">
                        {{ $totalUlasan }} <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">Feedback</span>
                    </div>
                    <div style="font-size: 0.76rem; color: #34d399; margin-top: 2px; font-weight: 600;">
                        <i class="bi bi-check-circle-fill"></i> Pembeli Resmi
                    </div>
                </div>
            </div>

            {{-- Card 3: Distribusi Bintang Mini --}}
            <div class="ulasan-dist-card">
                <div style="font-size: 0.74rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.4rem; letter-spacing: 0.04em;">
                    Distribusi Kepuasan:
                </div>
                @foreach([5, 4, 3, 2, 1] as $star)
                    @php
                        $cnt = $ratingCounts[$star] ?? 0;
                        $pct = $totalUlasan > 0 ? round(($cnt / $totalUlasan) * 100) : 0;
                    @endphp
                    <div class="dist-row">
                        <span style="width: 22px; font-weight: 600;">{{ $star }}★</span>
                        <div class="dist-bar-track">
                            <div class="dist-bar-fill" style="width: {{ $pct }}%;"></div>
                        </div>
                        <span style="width: 26px; text-align: right; color: #94a3b8; font-size: 0.7rem;">{{ $cnt }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Filter Bintang (Scrollable Pill) --}}
        <div class="ulasan-filter-scroll">
            <a href="{{ route('peternak.ulasan') }}" class="ulasan-pill-btn {{ !request('rating') ? 'active' : '' }}">
                Semua ({{ $totalUlasan }})
            </a>
            @foreach([5, 4, 3, 2, 1] as $star)
                <a href="{{ route('peternak.ulasan', ['rating' => $star]) }}" class="ulasan-pill-btn {{ request('rating') == $star ? 'active-star' : '' }}">
                    <span>{{ $star }} ★</span>
                    <span>({{ $ratingCounts[$star] ?? 0 }})</span>
                </a>
            @endforeach
        </div>

        {{-- Daftar Ulasan --}}
        @if($ulasans->count() > 0)
            <div>
                @foreach($ulasans as $u)
                    <div class="ulasan-card">
                        <div class="ulasan-card-header">
                            {{-- User Header --}}
                            <div class="buyer-info-group">
                                <div class="buyer-avatar-circle">
                                    {{ strtoupper(substr($u->pembeli->name ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="buyer-name-title">
                                        {{ $u->pembeli->name ?? 'Pembeli' }}
                                    </h4>
                                    <div class="buyer-meta-sub">
                                        Membeli <strong>Sapi {{ $u->sapi->jenis ?? 'Ternak' }}</strong> &bull; {{ $u->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>

                            {{-- Rating Bintang --}}
                            <div class="rating-badge-pill">
                                <div style="color: #f59e0b; font-size: 0.85rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $u->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <strong style="color: #fbbf24; font-size: 0.82rem;">{{ $u->rating }}.0</strong>
                            </div>
                        </div>

                        {{-- Tags Kepuasan --}}
                        @if(!empty($u->kategori) && is_array($u->kategori))
                            <div style="display: flex; gap: 4px; flex-wrap: wrap; margin-top: 0.75rem;">
                                @foreach($u->kategori as $tag)
                                    <span style="background: rgba(59, 130, 246, 0.12); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.25); font-size: 0.72rem; font-weight: 600; padding: 2px 8px; border-radius: 999px;">
                                        <i class="bi bi-patch-check-fill"></i> {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Komentar Ulasan --}}
                        <p class="comment-quote-box">
                            "{{ $u->komentar }}"
                        </p>

                        {{-- Foto Pembeli jika ada --}}
                        @if($u->foto)
                            <div style="margin-top: 0.75rem;">
                                <a href="{{ asset('storage/' . $u->foto) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $u->foto) }}" alt="Foto Ulasan" style="max-height: 85px; border-radius: 6px; border: 1px solid rgba(148, 163, 184, 0.2); object-fit: cover;">
                                </a>
                            </div>
                        @endif

                        {{-- Balasan Peternak --}}
                        @if($u->balasan_peternak)
                            <div class="reply-bubble-box">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3px;">
                                    <div style="font-size: 0.8rem; font-weight: 700; color: #34d399; display: flex; align-items: center; gap: 5px;">
                                        <i class="bi bi-reply-fill"></i> Balasan Anda:
                                    </div>
                                    @if($u->balasan_at)
                                        <span style="font-size: 0.7rem; color: #64748b;">{{ $u->balasan_at->format('d M Y, H:i') }}</span>
                                    @endif
                                </div>
                                <div style="color: #e2e8f0; font-size: 0.82rem; font-style: italic;">
                                    "{{ $u->balasan_peternak }}"
                                </div>
                                <button type="button" onclick="toggleReplyBox({{ $u->id }})" style="background: none; border: none; color: #38bdf8; font-size: 0.74rem; cursor: pointer; padding: 0; margin-top: 5px; text-decoration: underline;">
                                    Ubah Balasan
                                </button>
                            </div>
                        @else
                            <div style="margin-top: 0.85rem;">
                                <button type="button" onclick="toggleReplyBox({{ $u->id }})" style="background: rgba(56, 189, 248, 0.12); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.25); padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="bi bi-reply"></i> Balas Ulasan Ini
                                </button>
                            </div>
                        @endif

                        {{-- Kotak Input Balasan --}}
                        <div id="replyBox-{{ $u->id }}" style="display: none; margin-top: 0.85rem; background: var(--bg-muted); padding: 0.85rem; border-radius: 8px; border: 1px solid var(--border-color);">
                            <form action="{{ route('peternak.ulasan.balas', $u->id) }}" method="POST">
                                @csrf
                                <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-heading); margin-bottom: 0.35rem;">
                                    Tulis tanggapan / ucapan terima kasih:
                                </label>
                                <textarea name="balasan_peternak" rows="2" required placeholder="Contoh: Terima kasih atas kepercayaannya! Semoga ternak sapinya sehat dan berkah..." style="width: 100%; padding: 0.55rem 0.75rem; background: var(--input-bg); border: 1px solid var(--input-border); border-radius: 6px; color: var(--text-primary); font-size: 0.84rem; outline: none; resize: vertical; font-family: inherit;">{{ $u->balasan_peternak }}</textarea>
                                <div style="display: flex; justify-content: flex-end; gap: 6px; margin-top: 6px;">
                                    <button type="button" onclick="toggleReplyBox({{ $u->id }})" style="background: var(--bg-card); color: var(--text-secondary); border: 1px solid var(--border-color); padding: 4px 10px; border-radius: 5px; font-size: 0.78rem; cursor: pointer;">
                                        Batal
                                    </button>
                                    <button type="submit" style="background: #10b981; color: white; border: none; padding: 4px 12px; border-radius: 5px; font-size: 0.78rem; font-weight: 600; cursor: pointer;">
                                        Kirim Tanggapan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach

                <div style="margin-top: 1.5rem;">
                    {{ $ulasans->links() }}
                </div>
            </div>
        @else
            <div style="background: var(--bg-card); border: 1px dashed var(--border-color); border-radius: 14px; padding: 3rem 1.5rem; text-align: center;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(245, 158, 11, 0.1); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 1.85rem; margin: 0 auto 1rem;">
                    <i class="bi bi-star"></i>
                </div>
                <h3 style="color: var(--text-heading); font-size: 1.1rem; font-weight: 700; margin-bottom: 0.35rem;">Belum Ada Ulasan Pembeli</h3>
                <p style="color: var(--text-secondary); font-size: 0.85rem; max-width: 440px; margin: 0 auto; line-height: 1.5;">
                    Ulasan kepuasan dan rating bintang akan muncul di sini saat pembeli mengonfirmasi pesanan sapi mereka telah diterima.
                </p>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    function toggleReplyBox(id) {
        var box = document.getElementById('replyBox-' + id);
        if (box) {
            box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
        }
    }
</script>
@endsection
