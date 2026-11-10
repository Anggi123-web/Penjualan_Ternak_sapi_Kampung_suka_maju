import os
from PIL import Image, ImageDraw, ImageFont

# Canvas Setup
W = 1440
H = 3200
bg_color = (248, 250, 252) # Slate-50

img = Image.new('RGB', (W, H), color=bg_color)
draw = ImageDraw.Draw(img)

# Try loading TrueType font
font_path = '/System/Library/Fonts/Supplemental/Arial.ttf'
def get_font(size, bold=False):
    try:
        return ImageFont.truetype(font_path, size)
    except:
        return ImageFont.load_default()

f_tag = get_font(12, True)
f_title = get_font(20, True)
f_card_title = get_font(16, True)
f_h1 = get_font(30, True)
f_sub = get_font(13)
f_text = get_font(13)
f_small = get_font(11)
f_tiny = get_font(10)

# Colors
C_BORDER = (226, 232, 240)       # Slate-200
C_CARD_BG = (255, 255, 255)      # White
C_SKELETON_DARK = (203, 213, 225) # Slate-300
C_SKELETON_LIGHT = (241, 245, 249)# Slate-100
C_TEXT_DARK = (30, 41, 59)        # Slate-800
C_TEXT_MUTED = (100, 116, 139)    # Slate-500
C_BLUE = (37, 99, 235)           # Blue-600
C_BLUE_BG = (239, 246, 255)
C_GREEN = (16, 185, 129)         # Emerald-500
C_GREEN_BG = (236, 253, 245)
C_RED = (239, 68, 68)            # Red-500
C_RED_BG = (254, 242, 242)

def draw_tag(x, y, text, color=C_BLUE, bg=C_BLUE_BG):
    bbox = draw.textbbox((x, y), text, font=f_tag)
    pw, ph = bbox[2] - bbox[0] + 16, bbox[3] - bbox[1] + 8
    draw.rounded_rectangle([(x, y), (x + pw, y + ph)], radius=6, fill=bg, outline=color, width=1)
    draw.text((x + 8, y + 4), text, fill=color, font=f_tag)
    return ph

def draw_image_placeholder(x1, y1, x2, y2, label="[ Foto / Gambar ]"):
    draw.rounded_rectangle([(x1, y1), (x2, y2)], radius=8, fill=C_SKELETON_LIGHT, outline=C_BORDER, width=1)
    draw.line([(x1, y1), (x2, y2)], fill=(226, 232, 240), width=1)
    draw.line([(x1, y2), (x2, y1)], fill=(226, 232, 240), width=1)
    bbox = draw.textbbox((0, 0), label, font=f_text)
    tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
    cx = (x1 + x2) // 2
    cy = (y1 + y2) // 2
    draw.rectangle([(cx - tw//2 - 6, cy - th//2 - 4), (cx + tw//2 + 6, cy + th//2 + 4)], fill=(255, 255, 255))
    draw.text((cx - tw//2, cy - th//2), label, fill=C_TEXT_MUTED, font=f_text)

# ─── HEADER / TOP META BANNER ───
draw.rectangle([(0, 0), (W, 70)], fill=(15, 23, 42))
draw.text((40, 16), "SIPETER — SKETSA STRUKTUR & SKELETON WIREFRAME HALAMAN BERANDA", fill=(255, 255, 255), font=get_font(20, True))
draw.text((40, 42), "Model Arsitektur Antarmuka & Tata Letak Komponen UI Web (Low-Fidelity Skeleton Layout)", fill=(148, 163, 184), font=f_text)

# ─── 1. NAVBAR / HEADER ───
ny = 85
draw_tag(40, ny, "1. SECTION: HEADER & STICKY NAVBAR", C_BLUE, C_BLUE_BG)
draw.rounded_rectangle([(40, ny + 32), (W - 40, ny + 95)], radius=12, fill=C_CARD_BG, outline=C_BORDER, width=1)

# Logo
draw.rounded_rectangle([(65, ny + 46), (175, ny + 81)], radius=6, fill=C_GREEN_BG, outline=C_GREEN)
draw.text((80, ny + 54), "SIPETER", fill=C_GREEN, font=f_title)

# Nav items
nav_links = ["Beranda (Aktif)", "Katalog Sapi", "Tentang Kami", "Pemesanan", "Hubungi Kami"]
lx = 240
for link in nav_links:
    draw.rounded_rectangle([(lx, ny + 52), (lx + 105, ny + 76)], radius=6, fill=C_SKELETON_LIGHT)
    draw.text((lx + 10, ny + 57), link, fill=C_TEXT_DARK if "Aktif" in link else C_TEXT_MUTED, font=f_small)
    lx += 120

# Auth & Cart
draw.rounded_rectangle([(W - 250, ny + 50), (W - 210, ny + 80)], radius=6, fill=C_SKELETON_LIGHT, outline=C_BORDER)
draw.text((W - 240, ny + 56), "🛒", fill=C_TEXT_MUTED, font=f_text)
draw.rounded_rectangle([(W - 195, ny + 50), (W - 65, ny + 80)], radius=6, fill=C_BLUE_BG, outline=C_BLUE)
draw.text((W - 175, ny + 56), "Masuk / Daftar", fill=C_BLUE, font=f_text)

# ─── 2. HERO SECTION ───
hy = ny + 120
draw_tag(40, hy, "2. SECTION: HERO STATIC SECTION (BANNER UTAMA)", C_GREEN, C_GREEN_BG)
draw.rounded_rectangle([(40, hy + 32), (W - 40, hy + 460)], radius=16, fill=(240, 253, 244), outline=(187, 247, 208), width=1)

# Hero Image Placeholder (Left)
draw_image_placeholder(70, hy + 60, 580, hy + 430, "[ Gambar Sapi Hero - Animasi Mengambang / Float ]")

# Hero Content (Right)
hx = 630
draw_tag(hx, hy + 75, "TAGLINE BRAND", C_GREEN, (220, 252, 231))
draw.text((hx, hy + 120), "Dari Peternak", fill=C_TEXT_DARK, font=get_font(32, True))
draw.text((hx, hy + 165), "Untuk Kebutuhan", fill=C_TEXT_DARK, font=get_font(32, True))
draw.text((hx, hy + 210), "Terbaik Anda.", fill=C_GREEN, font=get_font(32, True))

# Subtitle bars
draw.rounded_rectangle([(hx, hy + 270), (hx + 560, hy + 284)], radius=4, fill=C_SKELETON_DARK)
draw.rounded_rectangle([(hx, hy + 294), (hx + 480, hy + 308)], radius=4, fill=C_SKELETON_LIGHT)
draw.text((hx, hy + 325), "Platform digital jual-beli sapi langsung dari peternak lokal terverifikasi Mantri Hewan.", fill=C_TEXT_MUTED, font=f_text)

# CTA Buttons
draw.rounded_rectangle([(hx, hy + 365), (hx + 200, hy + 415)], radius=99, fill=C_GREEN)
draw.text((hx + 30, hy + 382), "Lihat Katalog Sapi", fill=(255, 255, 255), font=get_font(14, True))
draw.rounded_rectangle([(hx + 220, hy + 365), (hx + 380, hy + 415)], radius=99, fill=C_CARD_BG, outline=C_BORDER)
draw.text((hx + 250, hy + 382), "Tentang Kami", fill=C_TEXT_DARK, font=get_font(14, True))

# ─── 3. TRUST & VALUE BAR ───
ty = hy + 485
draw_tag(40, ty, "3. SECTION: MARKETPLACE TRUST & VALUE BAR (4 PILAR KEUNGGULAN)", (147, 51, 234), (250, 245, 255))
t_grid_y = ty + 32
draw.rounded_rectangle([(40, t_grid_y), (W - 40, t_grid_y + 100)], radius=12, fill=C_CARD_BG, outline=C_BORDER, width=1)

trust_items = [
    ("🛡️", "100% Tersertifikasi", "Uji Mantri Hewan"),
    ("🤝", "Langsung dari Peternak", "Tanpa calo, harga kandang"),
    ("🚚", "Garansi Pengantaran", "Sapi selamat sampai alamat"),
    ("💳", "Transaksi Aman & DP", "Tersedia Pre-Order DP 25%")
]
tx = 60
for icon, title, desc in trust_items:
    draw.rounded_rectangle([(tx, t_grid_y + 20), (tx + 50, t_grid_y + 70)], radius=8, fill=C_SKELETON_LIGHT, outline=C_BORDER)
    draw.text((tx + 16, t_grid_y + 32), icon, fill=C_TEXT_DARK, font=f_title)
    draw.text((tx + 65, t_grid_y + 25), title, fill=C_TEXT_DARK, font=get_font(13, True))
    draw.text((tx + 65, t_grid_y + 48), desc, fill=C_TEXT_MUTED, font=f_small)
    tx += 330

# ─── 4. QUICK CATEGORIES BAR ───
cy = t_grid_y + 125
draw_tag(40, cy, "4. SECTION: PILIHAN KATEGORI TERNAK (QUICK FILTER PILLS)", C_BLUE, C_BLUE_BG)
draw.rounded_rectangle([(40, cy + 32), (W - 40, cy + 120)], radius=12, fill=C_CARD_BG, outline=C_BORDER, width=1)
draw.text((60, cy + 46), "Pilihan Kategori Ternak Sapi", fill=C_TEXT_DARK, font=f_title)
draw.text((60, cy + 74), "Jelajahi sapi pilihan berdasarkan ras dan tipe pemesanan", fill=C_TEXT_MUTED, font=f_small)

pills = [
    ("Sapi Limosin", C_CARD_BG, C_BORDER, C_TEXT_DARK),
    ("Sapi Simental", C_CARD_BG, C_BORDER, C_TEXT_DARK),
    ("Sapi Brahman", C_CARD_BG, C_BORDER, C_TEXT_DARK),
    ("Sapi Bali", C_CARD_BG, C_BORDER, C_TEXT_DARK),
    ("Sapi PO", C_CARD_BG, C_BORDER, C_TEXT_DARK),
    ("Sapi Pre-Order", C_RED_BG, C_RED, C_RED),
    ("Siap Kirim", C_GREEN_BG, C_GREEN, C_GREEN),
]
px = 440
for name, p_bg, p_bdr, p_col in pills:
    draw.rounded_rectangle([(px, cy + 54), (px + 115, cy + 92)], radius=99, fill=p_bg, outline=p_bdr)
    draw.text((px + 14, cy + 66), name, fill=p_col, font=f_small)
    px += 125

# ─── 5. KATALOG SAPI PRE-ORDER ───
poy = cy + 145
draw_tag(40, poy, "5. SECTION: KATALOG SAPI PRE-ORDER (QURBAN & PENGGEMUKAN)", C_RED, C_RED_BG)

# Header
draw.rounded_rectangle([(40, poy + 32), (W - 40, poy + 90)], radius=10, fill=C_CARD_BG, outline=C_BORDER)
draw.rounded_rectangle([(60, poy + 48), (160, poy + 74)], radius=99, fill=C_RED)
draw.text((72, poy + 54), "PRE-ORDER", fill=(255, 255, 255), font=get_font(12, True))
draw.text((175, poy + 44), "Katalog Sapi Pre-Order", fill=C_TEXT_DARK, font=f_title)
draw.text((175, poy + 70), "Pesan lebih awal untuk qurban atau aqiqah dengan skema DP dan perawatan", fill=C_TEXT_MUTED, font=f_small)
draw.text((W - 180, poy + 54), "Selengkapnya ->", fill=C_RED, font=f_text)

# 3 Cards Grid
def draw_sapi_card(x, y, badge_text, badge_bg, badge_col, title, price, specs, verified_by, preorder_banner=None):
    cw = 425
    ch = 440
    draw.rounded_rectangle([(x, y), (x + cw, y + ch)], radius=12, fill=C_CARD_BG, outline=C_BORDER, width=1)
    
    # Image Placeholder (upper half)
    draw_image_placeholder(x + 12, y + 12, x + cw - 12, y + 210, "[ Foto Sapi ]")
    
    # Badges
    draw.rounded_rectangle([(x + 22, y + 22), (x + 110, y + 46)], radius=6, fill=badge_bg, outline=badge_col)
    draw.text((x + 30, y + 28), badge_text, fill=badge_col, font=f_small)
    
    draw.rounded_rectangle([(x + cw - 95, y + 22), (x + cw - 22, y + 46)], radius=6, fill=C_GREEN_BG, outline=C_GREEN)
    draw.text((x + cw - 85, y + 28), "✓ Layak", fill=C_GREEN, font=f_small)
    
    if preorder_banner:
        draw.rectangle([(x + 12, y + 180), (x + cw - 12, y + 210)], fill=(220, 38, 38, 200))
        draw.text((x + 25, y + 186), preorder_banner, fill=(255, 255, 255), font=get_font(12, True))
    
    # Title & Price
    draw.text((x + 18, y + 225), title, fill=C_TEXT_DARK, font=get_font(15, True))
    draw.text((x + 18, y + 252), price, fill=C_GREEN if badge_text == "Order" else C_RED, font=get_font(16, True))
    
    # Specs
    sy = y + 285
    for s in specs:
        draw.rounded_rectangle([(x + 18, sy), (x + cw - 18, sy + 16)], radius=3, fill=C_SKELETON_LIGHT)
        draw.text((x + 24, sy + 1), s, fill=C_TEXT_MUTED, font=f_small)
        sy += 22
        
    # Footer
    draw.line([(x + 18, y + 375), (x + cw - 18, y + 375)], fill=C_BORDER)
    draw.text((x + 18, y + 395), f"by {verified_by}", fill=C_TEXT_MUTED, font=f_small)
    
    # Detail Button
    draw.rounded_rectangle([(x + cw - 170, y + 386), (x + cw - 65, y + 424)], radius=8, fill=badge_col)
    draw.text((x + cw - 150, y + 397), "Detail", fill=(255, 255, 255), font=f_small)
    
    # Cart Button
    draw.rounded_rectangle([(x + cw - 55, y + 386), (x + cw - 18, y + 424)], radius=8, fill=C_SKELETON_LIGHT, outline=C_BORDER)
    draw.text((x + cw - 45, y + 397), "🛒", fill=C_TEXT_MUTED, font=f_small)

# Render 3 Pre-order cards
po_cards_y = poy + 105
draw_sapi_card(40, po_cards_y, "Pre-Order", C_RED_BG, C_RED, "Sapi Brahman Cross Super", "Rp 24.500.000", ["Umur : 2 tahun 4 bulan", "Bobot : ± 590 kg", "Lokasi : Kandang C1 Sukamaju"], "Pak Budi Peternak", "Pre-Order Bulan Juni 2026")
draw_sapi_card(495, po_cards_y, "Pre-Order", C_RED_BG, C_RED, "Sapi Pegon Istimewa Idul Adha", "Rp 26.000.000", ["Umur : 2 tahun 6 bulan", "Bobot : ± 620 kg", "Lokasi : Kandang C2 Sukamaju"], "Pak Budi Peternak", "Pre-Order Bulan Juni 2026")
draw_sapi_card(950, po_cards_y, "Pre-Order", C_RED_BG, C_RED, "Sapi Ongole Berkah Penggemukan", "Rp 21.500.000", ["Umur : 2 tahun", "Bobot : ± 530 kg", "Lokasi : Kandang C3 Sukamaju"], "Pak Budi Peternak", "Pre-Order Bulan Juli 2026")

# ─── 6. PROMO BANNER CAROUSEL ───
by = po_cards_y + 465
draw_tag(40, by, "6. SECTION: BANNER IKLAN / PROMO CAROUSEL (SELA-SELA KATALOG)", (217, 119, 6), (254, 243, 199))
draw_image_placeholder(40, by + 32, W - 40, by + 210, "[ Banner Iklan Peternak & Info Desa - Carousel Otomatis (Rasio 16:5) ]")
# Slider indicators
draw.ellipse([(W//2 - 25, by + 185), (W//2 - 15, by + 195)], fill=C_TEXT_DARK)
draw.ellipse([(W//2 - 5, by + 185), (W//2 + 5, by + 195)], fill=C_SKELETON_DARK)
draw.ellipse([(W//2 + 15, by + 185), (W//2 + 25, by + 195)], fill=C_SKELETON_DARK)

# ─── 7. KATALOG SAPI ORDER (READY STOCK) ───
roy = by + 235
draw_tag(40, roy, "7. SECTION: KATALOG SAPI PESAN BIASA (READY STOCK / SIAP KIRIM)", C_GREEN, C_GREEN_BG)

# Header
draw.rounded_rectangle([(40, roy + 32), (W - 40, roy + 90)], radius=10, fill=C_CARD_BG, outline=C_BORDER)
draw.rounded_rectangle([(60, roy + 48), (170, roy + 74)], radius=99, fill=C_GREEN)
draw.text((75, roy + 54), "READY STOCK", fill=(255, 255, 255), font=get_font(12, True))
draw.text((185, roy + 44), "Katalog Sapi Pesan Biasa", fill=C_TEXT_DARK, font=f_title)
draw.text((185, roy + 70), "Pilihan sapi sehat berkualitas yang siap langsung dipesan dan dikirim", fill=C_TEXT_MUTED, font=f_small)
draw.text((W - 180, roy + 54), "Selengkapnya ->", fill=C_GREEN, font=f_text)

# 3 Cards Grid Order
ro_cards_y = roy + 105
draw_sapi_card(40, ro_cards_y, "Order", C_GREEN_BG, C_GREEN, "Sapi Limosin Super Jantan", "Rp 27.500.000", ["Umur : 2 tahun 8 bulan", "Bobot : ± 680 kg", "Lokasi : Kandang A1 Sukamaju"], "Pak Budi Peternak")
draw_sapi_card(495, ro_cards_y, "Order", C_GREEN_BG, C_GREEN, "Sapi Simental Bobot Jumbo", "Rp 32.000.000", ["Umur : 3 tahun", "Bobot : ± 750 kg", "Lokasi : Kandang A2 Sukamaju"], "Pak Budi Peternak")
draw_sapi_card(950, ro_cards_y, "Order", C_GREEN_BG, C_GREEN, "Sapi Bali Murni Siap Kirim", "Rp 18.000.000", ["Umur : 2 tahun 2 bulan", "Bobot : ± 430 kg", "Lokasi : Kandang B1 Sukamaju"], "Pak Budi Peternak")

# ─── 8. EDUKASI & INFORMASI TERNAK ───
edy = ro_cards_y + 465
draw_tag(40, edy, "8. SECTION: EDUKASI & INFORMASI SEPUTAR TERNAK (SLIDER)", C_BLUE, C_BLUE_BG)
draw.rounded_rectangle([(40, edy + 32), (W - 40, edy + 240)], radius=12, fill=C_CARD_BG, outline=C_BORDER)

# Edu Card 1 (Left Half)
draw_image_placeholder(60, edy + 50, 310, edy + 215, "[ Thumbnail Panduan ]")
draw.text((330, edy + 55), "Panduan Perawatan & Manajemen Pakan", fill=C_TEXT_DARK, font=f_card_title)
draw.text((330, edy + 78), "Sapi Sehat Kampung Sukamaju", fill=C_TEXT_DARK, font=f_card_title)
draw.rounded_rectangle([(330, edy + 110), (680, edy + 124)], radius=3, fill=C_SKELETON_DARK)
draw.rounded_rectangle([(330, edy + 132), (630, edy + 146)], radius=3, fill=C_SKELETON_LIGHT)
draw.text((330, edy + 175), "Baca Selengkapnya ->", fill=C_BLUE, font=get_font(13, True))

# Separator Line
draw.line([(715, edy + 45), (715, edy + 225)], fill=C_BORDER, width=1)

# Edu Card 2 (Right Half)
draw_image_placeholder(735, edy + 50, 985, edy + 215, "[ Thumbnail Regulasi ]")
draw.text((1005, edy + 55), "Syarat & Standar Kelayakan Qurban", fill=C_TEXT_DARK, font=f_card_title)
draw.text((1005, edy + 78), "Berdasarkan Syariat & Uji Mantri Hewan", fill=C_TEXT_DARK, font=f_card_title)
draw.rounded_rectangle([(1005, edy + 110), (1380, edy + 124)], radius=3, fill=C_SKELETON_DARK)
draw.rounded_rectangle([(1005, edy + 132), (1320, edy + 146)], radius=3, fill=C_SKELETON_LIGHT)
draw.text((1005, edy + 175), "Baca Selengkapnya ->", fill=C_BLUE, font=get_font(13, True))

# ─── 9. FOOTER ───
fy = edy + 265
draw_tag(40, fy, "9. SECTION: FOOTER & INFORMASI KONTAK", (100, 116, 139), (241, 245, 249))
draw.rectangle([(0, fy + 32), (W, H)], fill=(15, 23, 42))

# Footer Cols
# Col 1: Brand
draw.text((60, fy + 60), "SIPETER", fill=(255, 255, 255), font=get_font(24, True))
draw.text((60, fy + 95), "Sistem Penjualan Ternak Sapi", fill=C_GREEN, font=f_text)
draw.text((60, fy + 120), "Kampung Suka Maju, Merauke - Papua Selatan", fill=(148, 163, 184), font=f_small)
draw.text((60, fy + 140), "Menghubungkan peternak lokal langsung dengan pembeli secara transparan dan amanah.", fill=(100, 116, 139), font=f_small)

# Col 2: Navigasi
draw.text((500, fy + 60), "Navigasi Cepat", fill=(255, 255, 255), font=get_font(16, True))
draw.text((500, fy + 95), "• Beranda Publik", fill=(148, 163, 184), font=f_small)
draw.text((500, fy + 120), "• Katalog Sapi", fill=(148, 163, 184), font=f_small)
draw.text((500, fy + 145), "• Sapi Pre-Order", fill=(148, 163, 184), font=f_small)
draw.text((500, fy + 170), "• Monitoring Pemesanan", fill=(148, 163, 184), font=f_small)

# Col 3: Layanan & Verifikasi
draw.text((850, fy + 60), "Standar & Keamanan", fill=(255, 255, 255), font=get_font(16, True))
draw.text((850, fy + 95), "• Sertifikasi Mantri Hewan", fill=(148, 163, 184), font=f_small)
draw.text((850, fy + 120), "• Surat Keterangan / Jalan Desa", fill=(148, 163, 184), font=f_small)
draw.text((850, fy + 145), "• Jaminan Bebas Penyakit Mulut & Kuku", fill=(148, 163, 184), font=f_small)

# Col 4: Kontak
draw.text((1150, fy + 60), "Kontak & Lokasi", fill=(255, 255, 255), font=get_font(16, True))
draw.text((1150, fy + 95), "📍 Balai Dusun Sukamaju", fill=(148, 163, 184), font=f_small)
draw.text((1150, fy + 120), "📞 WhatsApp Peternak: 0812-3456-7890", fill=(148, 163, 184), font=f_small)
draw.text((1150, fy + 145), "✉️ email: info@sipeter-sukamaju.id", fill=(148, 163, 184), font=f_small)

# Bottom Copyright
draw.line([(60, fy + 215), (W - 60, fy + 215)], fill=(30, 41, 59))
draw.text((60, fy + 228), "© 2026 SIPETER (Sistem Penjualan Ternak Sapi Kampung Suka Maju). Hak Cipta Dilindungi Undang-Undang.", fill=(100, 116, 139), font=f_small)

# Save to public and artifact dirs
output_path = 'public/images/sketsa_halaman_awal_skeleton.png'
img.save(output_path, 'PNG')
print(f"Wireframe saved to {output_path} successfully!")

artifact_dir = '/Users/macbookair/.gemini/antigravity-ide/brain/48569085-a56e-4a69-a9fa-a1a2f95d020f'
if os.path.exists(artifact_dir):
    img.save(os.path.join(artifact_dir, 'sketsa_halaman_awal_skeleton.png'), 'PNG')
    print("Saved to artifact directory.")
