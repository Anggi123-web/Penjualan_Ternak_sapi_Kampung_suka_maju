@extends('layouts.frontend')

@section('title', 'Unggah Bukti Pembayaran — ' . $transaksi->kode_transaksi)

@section('content')
<div class="upload-pembayaran-page" style="padding-top: 140px; padding-bottom: 80px; min-height: calc(100vh - 110px); background: #fafafa;">
    <div style="max-width: 680px; margin: 0 auto; padding: 0 20px;">

        @if(session('success'))
            <div style="background: #d1fae5; border: 1px solid #34d399; color: #065f46; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 2rem; font-weight: 500;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #fee2e2; border: 1px solid #f87171; color: #b91c1c; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 2rem;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="background: var(--bg-card, #ffffff); border-radius: 16px; border: 1px solid var(--border-color, rgba(0,0,0,0.06)); box-shadow: var(--card-shadow, 0 10px 25px -5px rgba(0,0,0,0.04)); overflow: hidden; padding: 2.25rem;">
            
            <div style="text-align: center; margin-bottom: 2rem;">
                <div style="width: 60px; height: 60px; background: rgba(16, 185, 129, 0.12); color: var(--green-brand, #10b981); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin: 0 auto 1rem;">
                    <i class="bi bi-credit-card-2-front"></i>
                </div>
                <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.5rem; font-weight: 800; color: var(--text-heading, #111827); margin-bottom: 0.25rem;">
                    @if($transaksi->is_preorder)
                        Upload Bukti Pembayaran DP
                    @else
                        Upload Bukti Pembayaran
                    @endif
                </h2>
                <p style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">
                    Nomor Pesanan: <strong style="color: var(--text-heading, #0f172a);">{{ $transaksi->kode_transaksi }}</strong>
                    @if($transaksi->is_preorder)
                        <span style="display: block; margin-top: 4px; font-size: 0.85rem; color: #b45309; font-weight: 700;">
                            <i class="bi bi-info-circle"></i> Pembayaran Tahap 1 dari 2 (Uang Muka / DP)
                        </span>
                    @endif
                </p>
            </div>

            {{-- Ringkasan Pembayaran & Rekening Tujuan --}}
            <div style="background: var(--bg-surface, #f8fafc); border: 1px solid var(--border-color, #e2e8f0); border-radius: 12px; padding: 1.25rem 1.5rem; margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Ternak Sapi:</span>
                    <strong style="color: var(--text-heading, #1e293b);">{{ $transaksi->sapi->jenis }} ({{ $transaksi->is_preorder ? 'Pre-Order' : 'Order' }})</strong>
                </div>
                @if($transaksi->tanggal_pengambilan)
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Jadwal {{ $transaksi->is_pengantaran ? 'Pengantaran' : 'Pengambilan' }}:</span>
                    <strong style="color: var(--text-heading, #1e293b);">
                        {{ \Carbon\Carbon::parse($transaksi->tanggal_pengambilan)->translatedFormat('d F Y') }} ({{ $transaksi->durasi_perawatan_hari }} Hari)
                    </strong>
                </div>
                @endif
                @if($transaksi->biaya_perawatan > 0)
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Biaya Perawatan:</span>
                    <strong style="color: #b45309;">Rp {{ number_format($transaksi->biaya_perawatan, 0, ',', '.') }}</strong>
                </div>
                @endif
                @if($transaksi->is_preorder)
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Total Biaya Keseluruhan:</span>
                    <strong style="color: var(--text-heading, #1e293b);">{{ $transaksi->total_harga_formatted }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; background: rgba(16, 185, 129, 0.12); padding: 0.5rem 0.75rem; border-radius: 8px;">
                    <span style="color: #047857; font-size: 0.95rem; font-weight: 700;">
                        <i class="bi bi-wallet2"></i> Ditransfer Sekarang (Uang Muka / DP):
                    </span>
                    <strong style="color: #047857; font-size: 1.15rem; font-family: 'Montserrat', sans-serif;">{{ $transaksi->dibayarkan_formatted }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; background: rgba(245, 158, 11, 0.12); padding: 0.5rem 0.75rem; border-radius: 8px;">
                    <span style="color: #b45309; font-size: 0.85rem; font-weight: 700;">
                        <i class="bi bi-clock-history"></i> Sisa Pelunasan (Tahap 2):
                    </span>
                    <strong style="color: #b45309;">{{ $transaksi->sisa_pembayaran_formatted }} <span style="font-size: 0.75rem; font-weight: normal;">(saat ambil/kirim)</span></strong>
                </div>
                @else
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Jumlah yang Harus Ditransfer (Total):</span>
                    <strong style="color: var(--green-brand, #10b981); font-size: 1.15rem; font-family: 'Montserrat', sans-serif;">{{ $transaksi->dibayarkan_formatted }}</strong>
                </div>
                @endif
                <div style="border-top: 1px dashed var(--border-color, #cbd5e1); padding-top: 0.75rem; margin-top: 0.5rem;">
                    <div style="font-size: 0.85rem; color: var(--text-secondary, #64748b); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Transfer ke Rekening:</div>
                    <div style="font-size: 1.15rem; font-weight: 800; color: var(--text-heading, #0f172a); margin-top: 0.2rem;">
                        {{ $bankNama }} - <span style="font-family: monospace;">{{ $bankRekening }}</span>
                    </div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary, #64748b); margin-top: 0.15rem;">
                        A.N. {{ $transaksi->sapi->peternak->name ?? 'Peternak Suka Maju' }}
                    </div>
                </div>
            </div>

            {{-- Form Upload --}}
            <form action="{{ route('pembayaran.upload.process', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div style="margin-bottom: 1.75rem;">
                    <label style="display: block; font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 700; color: var(--text-heading, #1e293b); margin-bottom: 0.65rem;">
                        Pilih Foto Bukti Transfer
                    </label>

                    <div style="border: 2px dashed var(--border-color, #cbd5e1); border-radius: 12px; padding: 2rem; text-align: center; background: var(--bg-muted, #fafafa); cursor: pointer; transition: all 0.2s;" onclick="document.getElementById('inputBukti').click()" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                        <input type="file" name="bukti_pembayaran" id="inputBukti" accept="image/*" style="display: none;" onchange="previewImage(this)">
                        
                        <div id="previewWrapper" style="display: none; margin-bottom: 1rem;">
                            <img id="imagePreview" src="" alt="Preview Bukti" style="max-height: 250px; max-width: 100%; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        </div>

                        <div id="uploadPrompt">
                            <div style="font-size: 2.5rem; margin-bottom: 0.5rem; color: var(--green-brand, #10b981);"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                            <div style="font-weight: 700; color: var(--text-heading, #1e293b); font-size: 1rem;">Klik untuk memilih file foto bukti transfer</div>
                            <div style="font-size: 0.85rem; color: var(--text-secondary, #94a3b8); margin-top: 0.25rem;">Format JPG, PNG, WEBP (Maksimal 4 MB)</div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('katalog.show', $transaksi->sapi_id) }}" style="flex: 1; height: 48px; display: inline-flex; align-items: center; justify-content: center; background: var(--bg-muted, #e2e8f0); color: var(--text-secondary, #475569); border: 1px solid var(--border-color, transparent); text-decoration: none; border-radius: 10px; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 0.95rem;">
                        Nanti Saja
                    </a>
                    <button type="submit" style="flex: 2; height: 48px; display: inline-flex; align-items: center; justify-content: center; background: var(--green-brand, #10b981); color: white; border: none; border-radius: 10px; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                        Kirim Bukti Pembayaran
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('previewWrapper').style.display = 'block';
                document.getElementById('uploadPrompt').style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function handleDrop(e) {
        e.preventDefault();
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length > 0) {
            document.getElementById('inputBukti').files = files;
            previewImage(document.getElementById('inputBukti'));
        }
    }
</script>
@endsection
