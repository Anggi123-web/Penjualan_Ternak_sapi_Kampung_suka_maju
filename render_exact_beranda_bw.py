import os
from PIL import Image, ImageDraw, ImageFont

font_path = '/System/Library/Fonts/Supplemental/Arial.ttf'
def get_font(size, bold=False):
    try:
        return ImageFont.truetype(font_path, size)
    except:
        return ImageFont.load_default()

f_logo = get_font(18, True)
f_nav = get_font(14, True)
f_h1 = get_font(26, True)
f_h2 = get_font(20, True)
f_h3 = get_font(16, True)
f_card_title = get_font(14, True)
f_sub = get_font(12, False)
f_text = get_font(12, False)
f_small = get_font(11, False)
f_bold_small = get_font(11, True)

W = 1200
H = 3150
img = Image.new('RGB', (W, H), color=(255, 255, 255))
draw = ImageDraw.Draw(img)

# Palet Hitam Putih / Grayscale Sesuai Gambar Referensi User
C_BG = (255, 255, 255)
C_GREY_BOX = (212, 212, 216)      # #d4d4d8 abu-abu flat card
C_GREY_LIGHT = (235, 237, 240)    # #ebedf0 abu-abu muda
C_GREY_PILL = (228, 228, 231)
C_BLACK = (0, 0, 0)
C_BORDER_DARK = (40, 40, 40)
C_BORDER_INPUT = (160, 160, 160)
C_DOT_ACTIVE = (90, 90, 90)
C_DOT_INACTIVE = (210, 210, 210)

def draw_c_text(cx, cy, text, font, fill=C_BLACK):
    bbox = draw.textbbox((0, 0), text, font=font)
    tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
    draw.text((cx - tw // 2, cy - th // 2), text, font=font, fill=fill)

def draw_l_text(x, y, text, font, fill=C_BLACK):
    draw.text((x, y), text, font=font, fill=fill)

def draw_r_text(x, y, text, font, fill=C_BLACK):
    bbox = draw.textbbox((0, 0), text, font=font)
    tw = bbox[2] - bbox[0]
    draw.text((x - tw, y), text, font=font, fill=fill)

# ═══════════════════════════════════════════════════════════════════
# 1. NAVBAR (Header) — Sesuai navbar-premium pada sistem
# ═══════════════════════════════════════════════════════════════════
ny = 30
# Logo SIPETER Box
draw.rounded_rectangle([(60, ny), (210, ny + 50)], radius=8, fill=C_GREY_BOX, outline=C_BORDER_DARK, width=1)
draw_c_text(135, ny + 25, "SIPETER LOGO", f_logo)

# Links Nav
draw_l_text(250, ny + 17, "Branda", f_nav)
draw_l_text(340, ny + 17, "Catalog", f_nav)
draw_l_text(430, ny + 17, "About us", f_nav)

# Search Input
draw.rounded_rectangle([(550, ny + 6), (980, ny + 46)], radius=8, fill=(255, 255, 255), outline=C_BORDER_INPUT, width=2)
# Tombol Search icon
draw.rounded_rectangle([(550, ny + 6), (595, ny + 46)], radius=6, fill=C_GREY_BOX)
draw_c_text(572, ny + 26, "🔍", f_small)
draw_l_text(610, ny + 16, "Cari sapi berdasarkan jenis atau lokasi...", f_small, fill=(120, 120, 120))

# Tombol Login
draw.rounded_rectangle([(1020, ny + 6), (1140, ny + 46)], radius=8, fill=C_GREY_BOX, outline=C_BORDER_DARK, width=1)
draw_c_text(1080, ny + 26, "Login", f_nav)

draw.line([(0, ny + 65), (W, ny + 65)], fill=C_BORDER_INPUT, width=1)

# ═══════════════════════════════════════════════════════════════════
# 2. HERO STATIC SECTION — Sesuai hero-static-section
# ═══════════════════════════════════════════════════════════════════
hy = ny + 85
# Kotak Besar Hero Background
draw.rounded_rectangle([(60, hy), (W - 60, hy + 280)], radius=16, fill=C_GREY_LIGHT)

# Kolom Kiri: Hero Image Sapi
draw.rounded_rectangle([(90, hy + 25), (490, hy + 255)], radius=12, fill=C_GREY_BOX)
draw_c_text(290, hy + 130, "Gambar Hero Sapi", f_h3)
draw_c_text(290, hy + 155, "(Ilustrasi Mengambang / Sapi Hero)", f_small)

# Kolom Kanan: Teks Headline Sistem
hx = 540
draw_l_text(hx, hy + 45, "Dari Peternak", f_h1)
draw_l_text(hx, hy + 80, "Untuk Kebutuhan", f_h1)
draw_l_text(hx, hy + 115, "Terbaik Anda.", f_h1)

draw_l_text(hx, hy + 165, "Nikmati kemudahan bertransaksi sapi pilihan yang dirawat", f_sub)
draw_l_text(hx, hy + 185, "dengan sepenuh hati oleh peternak lokal terbaik.", f_sub)

# Tombol CTA Hero
draw.rounded_rectangle([(hx, hy + 215), (hx + 170, hy + 255)], radius=8, fill=C_GREY_BOX, outline=C_BORDER_DARK, width=1)
draw_c_text(hx + 85, hy + 235, "Lihat Katalog Sapi", f_bold_small)

# ═══════════════════════════════════════════════════════════════════
# 3. MARKETPLACE TRUST BAR — Sesuai trust-bar-section (4 Pilar)
# ═══════════════════════════════════════════════════════════════════
ty = hy + 310
tb_w = (W - 120 - (3 * 20)) // 4
tb_h = 75

trust_data = [
    ("100% Tersertifikasi", "Uji kesehatan Mantri Hewan"),
    ("Langsung dari Peternak", "Tanpa calo, harga kandang"),
    ("Garansi Pengantaran", "Sapi selamat sampai alamat"),
    ("Transaksi Aman & DP", "Tersedia skema Pre-Order DP")
]

for i, (title, sub) in enumerate(trust_data):
    tx1 = 60 + i * (tb_w + 20)
    tx2 = tx1 + tb_w
    draw.rounded_rectangle([(tx1, ty), (tx2, ty + tb_h)], radius=12, fill=C_GREY_BOX)
    draw_c_text((tx1 + tx2) // 2, ty + 26, title, f_bold_small)
    draw_c_text((tx1 + tx2) // 2, ty + 48, sub, get_font(10, False))

# ═══════════════════════════════════════════════════════════════════
# 4. QUICK CATEGORY BAR — Sesuai quick-categories-section
# ═══════════════════════════════════════════════════════════════════
cy = ty + 105
draw_l_text(60, cy, "Pilihan Kategori Ternak", f_h2)
draw_l_text(60, cy + 26, "Jelajahi sapi pilihan berdasarkan jenis ras dan tipe pemesanan", f_sub)
draw_r_text(W - 60, cy + 10, "Lihat Semua ->", f_bold_small)

pills = ["Sapi Limosin", "Sapi Simental", "Sapi Brahman", "Sapi Bali", "Sapi PO", "Sapi Pre-Order", "Siap Kirim"]
px = 60
py = cy + 55
for pill in pills:
    bbox = draw.textbbox((0, 0), pill, font=f_small)
    pw = bbox[2] - bbox[0] + 28
    draw.rounded_rectangle([(px, py), (px + pw, py + 34)], radius=17, fill=C_GREY_PILL, outline=C_BORDER_INPUT, width=1)
    draw_c_text(px + pw // 2, py + 17, pill, f_small)
    px += pw + 12

# ═══════════════════════════════════════════════════════════════════
# FUNGSI MENGGAMBAR KARTU SAPI (GRID SAPI PADA BERANDA)
# ═══════════════════════════════════════════════════════════════════
def draw_sapi_card_bw(x, y, cw, ch, badge_label, title, price, specs_list, overlay_text=None):
    # Container Card
    draw.rounded_rectangle([(x, y), (x + cw, y + ch)], radius=14, fill=C_GREY_LIGHT, outline=C_BORDER_INPUT, width=1)
    
    # Foto Sapi Placeholder
    img_h = 160
    draw.rounded_rectangle([(x + 10, y + 10), (x + cw - 10, y + img_h)], radius=10, fill=C_GREY_BOX)
    draw_c_text(x + cw // 2, y + img_h // 2, "Foto Sapi", f_card_title)
    
    # Badge Tipe (Order / Pre-Order)
    draw.rounded_rectangle([(x + 18, y + 18), (x + 95, y + 38)], radius=6, fill=(255, 255, 255), outline=C_BORDER_DARK, width=1)
    draw_c_text(x + 56, y + 28, badge_label, f_bold_small)
    
    # Badge Layak
    draw.rounded_rectangle([(x + cw - 75, y + 18), (x + cw - 18, y + 38)], radius=6, fill=(255, 255, 255), outline=C_BORDER_DARK, width=1)
    draw_c_text(x + cw - 46, y + 28, "✓ Layak", f_bold_small)
    
    # Overlay Pre-Order jika ada
    if overlay_text:
        draw.rectangle([(x + 10, y + img_h - 26), (x + cw - 10, y + img_h)], fill=(50, 50, 50))
        draw_c_text(x + cw // 2, y + img_h - 13, overlay_text, get_font(10, True), fill=(255, 255, 255))
        
    # Title & Price
    draw_l_text(x + 15, y + img_h + 12, title, f_card_title)
    draw_l_text(x + 15, y + img_h + 34, price, get_font(15, True))
    
    # Specs
    sy = y + img_h + 60
    for s in specs_list:
        draw_l_text(x + 15, sy, s, f_small)
        sy += 18
        
    # Divider
    draw.line([(x + 15, y + ch - 50), (x + cw - 15, y + ch - 50)], fill=C_BORDER_INPUT, width=1)
    
    # Peternak & Tombol
    draw_l_text(x + 15, y + ch - 35, "by Pak Budi Peternak", f_small)
    
    # Tombol Detail
    draw.rounded_rectangle([(x + cw - 120, y + ch - 42), (x + cw - 55, y + ch - 12)], radius=6, fill=C_GREY_BOX, outline=C_BORDER_DARK, width=1)
    draw_c_text(x + cw - 87, y + ch - 27, "Detail", f_bold_small)
    
    # Tombol Keranjang
    draw.rounded_rectangle([(x + cw - 48, y + ch - 42), (x + cw - 12, y + ch - 12)], radius=6, fill=(255, 255, 255), outline=C_BORDER_INPUT, width=1)
    draw_c_text(x + cw - 30, y + ch - 27, "🛒", f_small)

# ═══════════════════════════════════════════════════════════════════
# 5. UPDATE SAPI TERBARU — Sesuai sapi-update-section
# ═══════════════════════════════════════════════════════════════════
uy = cy + 115
draw_l_text(60, uy, "Update Sapi Terbaru", f_h2)
draw_l_text(60, uy + 26, "Lihat sapi-sapi terbaru yang diunggah dalam 1 minggu terakhir.", f_sub)
draw_r_text(W - 60, uy + 10, "Selengkapnya ->", f_bold_small)

card_w = (W - 120 - (2 * 25)) // 3
card_h = 320
card_y = uy + 55

draw_sapi_card_bw(60, card_y, card_w, card_h, "Order", "Sapi Limosin Super", "Rp 27.500.000", ["Umur : 32 bulan", "Bobot : ± 680 kg", "Lokasi : Kandang A1"])
draw_sapi_card_bw(60 + card_w + 25, card_y, card_w, card_h, "Order", "Sapi Simental Jumbo", "Rp 32.000.000", ["Umur : 36 bulan", "Bobot : ± 750 kg", "Lokasi : Kandang A2"])
draw_sapi_card_bw(60 + 2 * (card_w + 25), card_y, card_w, card_h, "Pre-Order", "Sapi Brahman Cross", "Rp 24.500.000", ["Umur : 28 bulan", "Bobot : ± 590 kg", "Lokasi : Kandang C1"], "Pre-Order Bulan Juni 2026")

# ═══════════════════════════════════════════════════════════════════
# 6. KATALOG SAPI PRE-ORDER — Sesuai id="katalog-preorder"
# ═══════════════════════════════════════════════════════════════════
poy = card_y + card_h + 35
# Badge Pre-Order
draw.rounded_rectangle([(60, poy), (145, poy + 24)], radius=12, fill=C_GREY_BOX, outline=C_BORDER_DARK, width=1)
draw_c_text(102, poy + 12, "PRE-ORDER", get_font(10, True))

draw_l_text(60, poy + 30, "Katalog Sapi Pre-Order", f_h2)
draw_l_text(60, poy + 56, "Pesan sapi lebih awal untuk kebutuhan qurban, aqiqah, atau hajatan mendatang.", f_sub)
draw_r_text(W - 60, poy + 40, "Selengkapnya ->", f_bold_small)

poy_cards = poy + 85
draw_sapi_card_bw(60, poy_cards, card_w, card_h, "Pre-Order", "Sapi Brahman Super", "Rp 24.500.000", ["Umur : 28 bulan", "Bobot : ± 590 kg", "Lokasi : Kandang C1"], "Pre-Order Bulan Juni 2026")
draw_sapi_card_bw(60 + card_w + 25, poy_cards, card_w, card_h, "Pre-Order", "Sapi Pegon Istimewa", "Rp 26.000.000", ["Umur : 30 bulan", "Bobot : ± 620 kg", "Lokasi : Kandang C2"], "Pre-Order Bulan Juni 2026")
draw_sapi_card_bw(60 + 2 * (card_w + 25), poy_cards, card_w, card_h, "Pre-Order", "Sapi Ongole Berkah", "Rp 21.500.000", ["Umur : 24 bulan", "Bobot : ± 530 kg", "Lokasi : Kandang C3"], "Pre-Order Bulan Juli 2026")

# ═══════════════════════════════════════════════════════════════════
# 7. BANNER IKLAN DI SELA KATALOG — Sesuai iklan-sela-katalog-section
# ═══════════════════════════════════════════════════════════════════
by = poy_cards + card_h + 35
draw.rounded_rectangle([(60, by), (W - 60, by + 160)], radius=16, fill=C_GREY_BOX)
draw_c_text(W // 2, by + 70, "Banner Iklan Peternak & Info Desa", f_h2)
draw_c_text(W // 2, by + 95, "(Carousel Banner Otomatis - Rasio 1638 x 500)", f_sub)

# Dots Carousel
draw.rounded_rectangle([(W//2 - 25, by + 135), (W//2 - 5, by + 143)], radius=4, fill=C_DOT_ACTIVE)
draw.rounded_rectangle([(W//2 + 5, by + 135), (W//2 + 15, by + 143)], radius=4, fill=C_DOT_INACTIVE)
draw.rounded_rectangle([(W//2 + 22, by + 135), (W//2 + 32, by + 143)], radius=4, fill=C_DOT_INACTIVE)

# ═══════════════════════════════════════════════════════════════════
# 8. KATALOG SAPI PESAN BIASA — Sesuai id="katalog-biasa" (Ready Stock)
# ═══════════════════════════════════════════════════════════════════
roy = by + 195
# Badge Ready Stock
draw.rounded_rectangle([(60, roy), (155, roy + 24)], radius=12, fill=C_GREY_BOX, outline=C_BORDER_DARK, width=1)
draw_c_text(107, roy + 12, "READY STOCK", get_font(10, True))

draw_l_text(60, roy + 30, "Katalog Sapi Pesan Biasa", f_h2)
draw_l_text(60, roy + 56, "Pilihan sapi sehat berkualitas yang siap langsung dipesan dan dikirim ke lokasi Anda.", f_sub)
draw_r_text(W - 60, roy + 40, "Selengkapnya ->", f_bold_small)

roy_cards = roy + 85
draw_sapi_card_bw(60, roy_cards, card_w, card_h, "Order", "Sapi Limosin Jantan", "Rp 27.500.000", ["Umur : 32 bulan", "Bobot : ± 680 kg", "Lokasi : Kandang A1"])
draw_sapi_card_bw(60 + card_w + 25, roy_cards, card_w, card_h, "Order", "Sapi Simental Jumbo", "Rp 32.000.000", ["Umur : 36 bulan", "Bobot : ± 750 kg", "Lokasi : Kandang A2"])
draw_sapi_card_bw(60 + 2 * (card_w + 25), roy_cards, card_w, card_h, "Order", "Sapi Bali Murni", "Rp 18.000.000", ["Umur : 26 bulan", "Bobot : ± 430 kg", "Lokasi : Kandang B1"])

# Tombol Lihat Semua Katalog
draw.rounded_rectangle([(W//2 - 120, roy_cards + card_h + 20), (W//2 + 120, roy_cards + card_h + 60)], radius=20, fill=C_GREY_BOX, outline=C_BORDER_DARK, width=1)
draw_c_text(W//2, roy_cards + card_h + 40, "Lihat Semua Katalog Sapi ->", f_bold_small)

# ═══════════════════════════════════════════════════════════════════
# 9. EDUKASI & INFO SECTION — Sesuai section Edukasi di beranda.blade
# ═══════════════════════════════════════════════════════════════════
ey = roy_cards + card_h + 85
draw_c_text(W // 2, ey, "Edukasi & Info", f_h2)
draw_c_text(W // 2, ey + 26, "Informasi seputar perawatan sapi dan regulasi pembelian.", f_sub)

edu_w = (W - 120 - 30) // 2
edu_h = 160
edu_y = ey + 55

# Slide 1
draw.rounded_rectangle([(60, edu_y), (60 + edu_w, edu_y + edu_h)], radius=14, fill=C_GREY_LIGHT, outline=C_BORDER_INPUT, width=1)
draw.rounded_rectangle([(75, edu_y + 15), (250, edu_y + edu_h - 15)], radius=10, fill=C_GREY_BOX)
draw_c_text(162, edu_y + edu_h // 2, "Thumbnail Edukasi", f_small)
draw_l_text(265, edu_y + 30, "Panduan Perawatan & Manajemen Pakan", f_card_title)
draw_l_text(265, edu_y + 55, "Tips menjaga stamina dan bobot sapi agar sehat optimal", f_small)
draw_l_text(265, edu_y + 75, "dalam program penggemukan peternak.", f_small)
draw_l_text(265, edu_y + 115, "Baca Selengkapnya ->", f_bold_small)

# Slide 2
draw.rounded_rectangle([(60 + edu_w + 30, edu_y), (W - 60, edu_y + edu_h)], radius=14, fill=C_GREY_LIGHT, outline=C_BORDER_INPUT, width=1)
draw.rounded_rectangle([(75 + edu_w + 30, edu_y + 15), (250 + edu_w + 30, edu_y + edu_h - 15)], radius=10, fill=C_GREY_BOX)
draw_c_text(162 + edu_w + 30, edu_y + edu_h // 2, "Thumbnail Edukasi", f_small)
draw_l_text(265 + edu_w + 30, edu_y + 30, "Syarat & Standar Kelayakan Qurban", f_card_title)
draw_l_text(265 + edu_w + 30, edu_y + 55, "Regulasi syariat dan panduan pemeriksaan kesehatan", f_small)
draw_l_text(265 + edu_w + 30, edu_y + 75, "oleh Mantri Hewan bersertifikasi.", f_small)
draw_l_text(265 + edu_w + 30, edu_y + 115, "Baca Selengkapnya ->", f_bold_small)

# Slider Buttons (< dan >)
draw.rounded_rectangle([(35, edu_y + edu_h//2 - 18), (70, edu_y + edu_h//2 + 18)], radius=18, fill=(255, 255, 255), outline=C_BORDER_DARK, width=1)
draw_c_text(52, edu_y + edu_h//2, "❮", f_small)
draw.rounded_rectangle([(W - 70, edu_y + edu_h//2 - 18), (W - 35, edu_y + edu_h//2 + 18)], radius=18, fill=(255, 255, 255), outline=C_BORDER_DARK, width=1)
draw_c_text(W - 53, edu_y + edu_h//2, "❯", f_small)

# ═══════════════════════════════════════════════════════════════════
# 10. FOOTER — Sesuai footer pada layout sistem ini
# ═══════════════════════════════════════════════════════════════════
fy = edu_y + edu_h + 55
draw.rectangle([(0, fy), (W, H)], fill=C_GREY_BOX)

# Brand Footer
draw_l_text(60, fy + 35, "SIPETER", f_h1)
draw_l_text(60, fy + 70, "Mewujudkan ekosistem peternakan sapi digital Indonesia yang lebih sehat,", f_small)
draw_l_text(60, fy + 88, "transparan, dan terpercaya bagi peternak dan pembeli.", f_small)

# Kolom Navigasi
draw_l_text(650, fy + 35, "Navigasi", f_h3)
draw_l_text(650, fy + 65, "• Branda", f_small)
draw_l_text(650, fy + 85, "• Catalog", f_small)
draw_l_text(650, fy + 105, "• About Us", f_small)

# Kolom Akses Sistem
draw_l_text(850, fy + 35, "Akses Sistem", f_h3)
draw_l_text(850, fy + 65, "• Masuk", f_small)
draw_l_text(850, fy + 85, "• Daftar Akun Baru", f_small)

# Copyright Line
draw.line([(60, fy + 145), (W - 60, fy + 145)], fill=C_BORDER_INPUT, width=1)
draw_c_text(W // 2, fy + 165, "© 2026 SIPETER — Sistem Penjualan Ternak Sapi. All rights reserved.", f_small)

# Simpan hasil
out_path = 'public/images/sketsa_beranda_sistem_hitam_putih.png'
img.save(out_path, 'PNG')
print(f"Generated {out_path} successfully!")

artifact_dir = '/Users/macbookair/.gemini/antigravity-ide/brain/48569085-a56e-4a69-a9fa-a1a2f95d020f'
img.save(os.path.join(artifact_dir, 'sketsa_beranda_sistem_hitam_putih.png'), 'PNG')
