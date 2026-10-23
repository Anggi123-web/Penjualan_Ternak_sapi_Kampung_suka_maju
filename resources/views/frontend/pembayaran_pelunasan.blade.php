@extends('layouts.frontend')

@section('title', 'Pelunasan Pre-Order — ' . $transaksi->kode_transaksi)

@section('content')
<div class="pelunasan-page" style="padding-top: 140px; padding-bottom: 80px; min-height: calc(100vh - 110px); background: #fafafa;">
    <div style="max-width: 720px; margin: 0 auto; padding: 0 20px;">

        @if(session('success'))
            <div style="background: #d1fae5; border: 1px solid #34d399; color: #065f46; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-check-circle-fill" style="font-size: 1.2rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; border: 1px solid #f87171; color: #b91c1c; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 600;">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #fee2e2; border: 1px solid #f87171; color: #b91c1c; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="background: #ffffff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 10px 30px -5px rgba(0,0,0,0.05); overflow: hidden; padding: 2.25rem;">
            
            {{-- Header --}}
            <div style="text-align: center; margin-bottom: 1.75rem;">
                <div style="width: 64px; height: 64px; background: rgba(245, 158, 11, 0.12); color: #d97706; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.85rem; margin: 0 auto 1rem;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div style="display: inline-flex; align-items: center; gap: 6px; background: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 999px; font-size: 0.78rem; font-weight: 700; margin-bottom: 0.5rem; text-transform: uppercase;">
                    <i class="bi bi-calendar-check"></i> Pembayaran Tahap 2 — Pelunasan
                </div>
                <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">
                    Pelunasan Sapi Pre-Order
                </h2>
                <p style="color: #64748b; font-size: 0.92rem; margin: 0;">
                    Nomor Pesanan: <strong style="color: #0f172a; font-family: monospace;">{{ $transaksi->kode_transaksi }}</strong>
                </p>
            </div>

            {{-- Ringkasan Keuangan Pre-Order --}}
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 1.25rem 1.5rem; margin-bottom: 1.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <span style="color: #64748b; font-size: 0.9rem;">Ternak Sapi:</span>
                    <strong style="color: #0f172a; font-size: 0.95rem;">Sapi {{ $transaksi->sapi->jenis }}</strong>
                </div>

                @if($transaksi->tanggal_pengambilan)
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <span style="color: #64748b; font-size: 0.9rem;">Rencana {{ $transaksi->is_pengantaran ? 'Pengantaran' : 'Penjemputan' }}:</span>
                    <strong style="color: #b45309; font-size: 0.92rem;">
                        <i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($transaksi->tanggal_pengambilan)->translatedFormat('d F Y') }}
                    </strong>
                </div>
                @endif

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <span style="color: #64748b; font-size: 0.9rem;">Total Biaya Keseluruhan:</span>
                    <strong style="color: #0f172a;">{{ $transaksi->total_harga_formatted }}</strong>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; background: rgba(16, 185, 129, 0.08); padding: 0.5rem 0.75rem; border-radius: 8px;">
                    <span style="color: #047857; font-size: 0.88rem; font-weight: 600;">
                        <i class="bi bi-check-circle-fill"></i> Pembayaran 1 (DP yang Sudah Dibayar):
                    </span>
                    <strong style="color: #047857;">{{ $transaksi->dp_formatted }}</strong>
                </div>

                <div style="border-top: 2px dashed #cbd5e1; padding-top: 0.85rem; margin-top: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 0.85rem; color: #64748b; font-weight: 700; text-transform: uppercase;">
                            Sisa Tagihan Pelunasan:
                        </div>
                        <div style="font-size: 0.78rem; color: #94a3b8;">
                            Dibayarkan saat sapi siap diambil / diantar
                        </div>
                    </div>
                    <div style="font-size: 1.45rem; font-weight: 800; color: #e11d48; font-family: 'Montserrat', sans-serif;">
                        {{ $transaksi->sisa_pembayaran_formatted }}
                    </div>
                </div>
            </div>

            {{-- Rekening Peternak --}}
            <div style="background: linear-gradient(135deg, #0f172a, #1e293b); color: white; border-radius: 14px; padding: 1.25rem 1.5rem; margin-bottom: 1.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span style="font-size: 0.78rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">
                        Rekening Tujuan Transfer Peternak:
                    </span>
                    <span style="font-size: 0.75rem; background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 6px; color: #38bdf8;">
                        {{ $bankNama }}
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 1.35rem; font-weight: 800; font-family: monospace; letter-spacing: 1px; color: #f8fafc;" id="textRekening">
                            {{ $bankRekening }}
                        </div>
                        <div style="font-size: 0.85rem; color: #cbd5e1; margin-top: 2px;">
                            Atas Nama: <strong>{{ $transaksi->sapi->peternak->name ?? 'Peternak Suka Maju' }}</strong>
                        </div>
                    </div>
                    <button type="button" onclick="copyRekening()" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25); color: white; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="bi bi-clipboard"></i> Salin
                    </button>
                </div>
            </div>

            {{-- Form Upload Bukti Pelunasan --}}
            <form action="{{ route('pembayaran.pelunasan.process', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">
                        Unggah Foto Bukti Transfer Pelunasan
                    </label>

                    <div style="border: 2px dashed #cbd5e1; border-radius: 14px; padding: 2rem; text-align: center; background: #fafafa; cursor: pointer; transition: all 0.2s;" onclick="document.getElementById('inputBuktiPelunasan').click()" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                        <input type="file" name="bukti_pelunasan" id="inputBuktiPelunasan" accept="image/*" style="display: none;" onchange="previewImage(this)" required>
                        
                        <div id="previewWrapper" style="display: none; margin-bottom: 1rem;">
                            <img id="imagePreview" src="" alt="Preview Bukti Pelunasan" style="max-height: 250px; max-width: 100%; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        </div>

                        <div id="uploadPrompt">
                            <div style="font-size: 2.75rem; margin-bottom: 0.5rem; color: #f59e0b;">
                                <i class="bi bi-cloud-arrow-up-fill"></i>
                            </div>
                            <div style="font-weight: 700; color: #1e293b; font-size: 1rem;">Klik untuk memilih file foto bukti transfer pelunasan</div>
                            <div style="font-size: 0.82rem; color: #94a3b8; margin-top: 0.25rem;">Format JPG, PNG, WEBP (Maksimal 4 MB)</div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <a href="{{ route('pesanan.index') }}" style="flex: 1; height: 50px; display: inline-flex; align-items: center; justify-content: center; background: #f1f5f9; color: #475569; text-decoration: none; border-radius: 12px; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 0.92rem; border: 1px solid #cbd5e1;">
                        <i class="bi bi-arrow-left" style="margin-right: 6px;"></i> Kembali
                    </a>
                    <button type="submit" style="flex: 2; height: 50px; display: inline-flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 12px; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);">
                        <i class="bi bi-check-circle-fill" style="margin-right: 8px;"></i> Kirim Bukti Pelunasan
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
            document.getElementById('inputBuktiPelunasan').files = files;
            previewImage(document.getElementById('inputBuktiPelunasan'));
        }
    }

    function copyRekening() {
        const text = document.getElementById('textRekening').innerText.trim();
        navigator.clipboard.writeText(text).then(() => {
            alert('Nomor rekening berhasil disalin!');
        });
    }
</script>
@endsection
