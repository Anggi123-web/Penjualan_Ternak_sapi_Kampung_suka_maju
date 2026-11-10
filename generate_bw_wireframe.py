import os
from PIL import Image, ImageDraw, ImageFont

font_path = '/System/Library/Fonts/Supplemental/Arial.ttf'
def get_font(size, bold=False):
    try:
        return ImageFont.truetype(font_path, size)
    except:
        return ImageFont.load_default()

f_logo = get_font(20, True)
f_nav = get_font(16, True)
f_h1 = get_font(26, True)
f_h2 = get_font(22, True)
f_card = get_font(18, True)
f_sub = get_font(14, False)
f_small = get_font(12, False)

# ═══════════════════════════════════════════════════════════════════
# 1. GENERATE SKETSA HITAM PUTIH (PERSIS SEPERTI GAMBAR USER)
# ═══════════════════════════════════════════════════════════════════
W = 1200
H = 1250
img = Image.new('RGB', (W, H), color=(255, 255, 255))
draw = ImageDraw.Draw(img)

C_BG = (255, 255, 255)
C_GREY_BOX = (212, 212, 216)    # #d4d4d8 flat grey
C_GREY_LIGHT = (229, 231, 235)  # #e5e7eb
C_BLACK = (0, 0, 0)
C_BORDER_DARK = (50, 50, 50)
C_BORDER_INPUT = (180, 180, 180)
C_DOT_ACTIVE = (120, 120, 120)
C_DOT_INACTIVE = (210, 210, 210)

def draw_centered_text(cx, cy, text, font, fill=C_BLACK):
    bbox = draw.textbbox((0, 0), text, font=font)
    tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
    draw.text((cx - tw // 2, cy - th // 2), text, font=font, fill=fill)

# ─── NAVBAR ───
ny = 40
# Logo Box
draw.rectangle([(60, ny), (220, ny + 70)], fill=C_GREY_BOX, outline=C_BORDER_DARK, width=2)
draw_centered_text(140, ny + 35, "LOGO", f_logo)

# Nav Links
draw.text((320, ny + 25), "Beranda", font=f_nav, fill=C_BLACK)
draw.text((440, ny + 25), "Catalog", font=f_nav, fill=C_BLACK)
draw.text((560, ny + 25), "About", font=f_nav, fill=C_BLACK)

# Search Bar
draw.text((700, ny + 25), "Cari", font=f_nav, fill=C_BLACK)
draw.rounded_rectangle([(745, ny + 15), (960, ny + 55)], radius=8, fill=(255, 255, 255), outline=C_BORDER_INPUT, width=2)

# Login
draw.text((1030, ny + 25), "Login", font=get_font(18, True), fill=C_BLACK)

# ─── SECTION 1: HERO SECTION ───
hy = ny + 105
draw.rounded_rectangle([(60, hy), (W - 60, hy + 260)], radius=16, fill=C_GREY_BOX)
draw_centered_text(W // 2, hy + 130, "Hero Section", f_h1)

# ─── SECTION 2: EDUKASI & INFO ───
ey = hy + 310
draw_centered_text(W // 2, ey, "Edukasi& Info", f_h2)
draw_centered_text(W // 2, ey + 30, "Informasi seputar perawatan sapi dan regulasi pembelian", f_sub)

# 2 Cards Side-by-side
card_w = (W - 120 - 40) // 2  # ~520px
card_h = 160
c1_x1 = 60
c1_x2 = c1_x1 + card_w
c2_x1 = c1_x2 + 40
c2_x2 = c2_x1 + card_w
card_y = ey + 60

# Card 1
draw.rounded_rectangle([(c1_x1, card_y), (c1_x2, card_y + card_h)], radius=16, fill=C_GREY_BOX)
draw_centered_text((c1_x1 + c1_x2) // 2, card_y + card_h // 2, "Pamflet Informasi", f_card)
# Text below card 1
draw_centered_text((c1_x1 + c1_x2) // 2, card_y + card_h + 20, "Edukasi& info", get_font(11, True))
draw_centered_text((c1_x1 + c1_x2) // 2, card_y + card_h + 38, "Informasi seputar perawatan sapi dan regulasi pembelian", get_font(11, False))

# Card 2
draw.rounded_rectangle([(c2_x1, card_y), (c2_x2, card_y + card_h)], radius=16, fill=C_GREY_BOX)
draw_centered_text((c2_x1 + c2_x2) // 2, card_y + card_h // 2, "Pamflet Informasi", f_card)
# Text below card 2
draw_centered_text((c2_x1 + c2_x2) // 2, card_y + card_h + 20, "Edukasi& info", get_font(11, True))
draw_centered_text((c2_x1 + c2_x2) // 2, card_y + card_h + 38, "Informasi seputar perawatan sapi dan regulasi pembelian", get_font(11, False))

# Pagination indicators
dot_y = card_y + card_h + 65
dot_cx = W // 2
draw.rounded_rectangle([(dot_cx - 45, dot_y), (dot_cx - 15, dot_y + 8)], radius=4, fill=C_DOT_ACTIVE)
draw.rounded_rectangle([(dot_cx - 5, dot_y), (dot_cx + 10, dot_y + 8)], radius=4, fill=C_DOT_INACTIVE)
draw.rounded_rectangle([(dot_cx + 20, dot_y), (dot_cx + 35, dot_y + 8)], radius=4, fill=C_DOT_INACTIVE)
draw.rounded_rectangle([(dot_cx + 45, dot_y), (dot_cx + 60, dot_y + 8)], radius=4, fill=C_DOT_INACTIVE)

# ─── SECTION 3: UPDATE CATALOG ───
uy = dot_y + 40
draw_centered_text(W // 2, uy, "Update Catalog", f_h2)
draw_centered_text(W // 2, uy + 30, "Informasi seputar perawatan sapi dan regulasi pembelian", f_sub)

# 4 Catalog Cards Side-by-side
cat_w = (W - 120 - (3 * 25)) // 4  # ~250px
cat_h = 240
cat_y = uy + 65

for i in range(4):
    cx1 = 60 + i * (cat_w + 25)
    cx2 = cx1 + cat_w
    draw.rounded_rectangle([(cx1, cat_y), (cx2, cat_y + cat_h)], radius=16, fill=C_GREY_BOX)
    draw_centered_text((cx1 + cx2) // 2, cat_y + cat_h // 2, "Catalog", f_card)

output1 = 'public/images/sketsa_hitam_putih.png'
img.save(output1, 'PNG')
print(f"Saved {output1}")

# Also copy to artifacts dir
artifact_dir = '/Users/macbookair/.gemini/antigravity-ide/brain/48569085-a56e-4a69-a9fa-a1a2f95d020f'
img.save(os.path.join(artifact_dir, 'sketsa_hitam_putih.png'), 'PNG')

# ═══════════════════════════════════════════════════════════════════
# 2. GENERATE SKETSA HITAM PUTIH LENGKAP (FULL BERANDA EXTENDED)
# ═══════════════════════════════════════════════════════════════════
W = 1200
H = 2650
img_full = Image.new('RGB', (W, H), color=(255, 255, 255))
d = ImageDraw.Draw(img_full)

def draw_c_text(cx, cy, text, font, fill=C_BLACK):
    bbox = d.textbbox((0, 0), text, font=font)
    tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
    d.text((cx - tw // 2, cy - th // 2), text, font=font, fill=fill)

# Navbar
ny = 40
d.rectangle([(60, ny), (220, ny + 70)], fill=C_GREY_BOX, outline=C_BORDER_DARK, width=2)
draw_c_text(140, ny + 35, "LOGO", f_logo)
d.text((300, ny + 25), "Beranda", font=f_nav, fill=C_BLACK)
d.text((410, ny + 25), "Catalog", font=f_nav, fill=C_BLACK)
d.text((520, ny + 25), "Pemesanan", font=f_nav, fill=C_BLACK)
d.text((650, ny + 25), "About", font=f_nav, fill=C_BLACK)
d.text((750, ny + 25), "Cari", font=f_nav, fill=C_BLACK)
d.rounded_rectangle([(795, ny + 15), (980, ny + 55)], radius=8, fill=(255, 255, 255), outline=C_BORDER_INPUT, width=2)
d.text((1040, ny + 25), "Login", font=get_font(18, True), fill=C_BLACK)

# 1. Hero Section
hy = ny + 105
d.rounded_rectangle([(60, hy), (W - 60, hy + 260)], radius=16, fill=C_GREY_BOX)
draw_c_text(W // 2, hy + 130, "Hero Section", f_h1)

# 2. Trust Bar (4 Pilar)
ty = hy + 290
draw_c_text(W // 2, ty, "Keunggulan & Jaminan Transaksi", f_h2)
t_w = (W - 120 - 45) // 4
t_h = 90
t_y = ty + 30
trust_titles = ["100% Sertifikasi", "Langsung Peternak", "Garansi Kirim", "Transaksi Aman & DP"]
for i in range(4):
    tx1 = 60 + i * (t_w + 15)
    tx2 = tx1 + t_w
    d.rounded_rectangle([(tx1, t_y), (tx2, t_y + t_h)], radius=12, fill=C_GREY_BOX)
    draw_c_text((tx1 + tx2) // 2, t_y + t_h // 2, trust_titles[i], f_small)

# 3. Edukasi & Info
ey = t_y + 130
draw_c_text(W // 2, ey, "Edukasi& Info", f_h2)
draw_c_text(W // 2, ey + 30, "Informasi seputar perawatan sapi dan regulasi pembelian", f_sub)

card_w = (W - 120 - 40) // 2
card_h = 160
c1_x1, c1_x2 = 60, 60 + card_w
c2_x1, c2_x2 = c1_x2 + 40, c1_x2 + 40 + card_w
card_y = ey + 60

d.rounded_rectangle([(c1_x1, card_y), (c1_x2, card_y + card_h)], radius=16, fill=C_GREY_BOX)
draw_c_text((c1_x1 + c1_x2) // 2, card_y + card_h // 2, "Pamflet Informasi 1", f_card)
draw_c_text((c1_x1 + c1_x2) // 2, card_y + card_h + 20, "Edukasi& info", get_font(11, True))
draw_c_text((c1_x1 + c1_x2) // 2, card_y + card_h + 38, "Informasi seputar perawatan sapi dan regulasi pembelian", get_font(11, False))

d.rounded_rectangle([(c2_x1, card_y), (c2_x2, card_y + card_h)], radius=16, fill=C_GREY_BOX)
draw_c_text((c2_x1 + c2_x2) // 2, card_y + card_h // 2, "Pamflet Informasi 2", f_card)
draw_c_text((c2_x1 + c2_x2) // 2, card_y + card_h + 20, "Edukasi& info", get_font(11, True))
draw_c_text((c2_x1 + c2_x2) // 2, card_y + card_h + 38, "Informasi seputar perawatan sapi dan regulasi pembelian", get_font(11, False))

# Pagination
dot_y = card_y + card_h + 65
d.rounded_rectangle([(W//2 - 45, dot_y), (W//2 - 15, dot_y + 8)], radius=4, fill=C_DOT_ACTIVE)
d.rounded_rectangle([(W//2 - 5, dot_y), (W//2 + 10, dot_y + 8)], radius=4, fill=C_DOT_INACTIVE)
d.rounded_rectangle([(W//2 + 20, dot_y), (W//2 + 35, dot_y + 8)], radius=4, fill=C_DOT_INACTIVE)
d.rounded_rectangle([(W//2 + 45, dot_y), (W//2 + 60, dot_y + 8)], radius=4, fill=C_DOT_INACTIVE)

# 4. Update Catalog (Ready Stock & Pre-Order)
uy = dot_y + 40
draw_c_text(W // 2, uy, "Update Catalog Sapi", f_h2)
draw_c_text(W // 2, uy + 30, "Daftar hewan ternak sapi terbaru siap kirim dan pre-order", f_sub)

cat_w = (W - 120 - 45) // 4
cat_h = 240
cat_y = uy + 65
cats = ["Catalog (Order)", "Catalog (Order)", "Catalog (Pre-Order)", "Catalog (Pre-Order)"]
for i in range(4):
    cx1 = 60 + i * (cat_w + 15)
    cx2 = cx1 + cat_w
    d.rounded_rectangle([(cx1, cat_y), (cx2, cat_y + cat_h)], radius=16, fill=C_GREY_BOX)
    draw_c_text((cx1 + cx2) // 2, cat_y + cat_h // 2, cats[i], f_small)

# 5. Promo Banner (16:5)
by = cat_y + cat_h + 50
d.rounded_rectangle([(60, by), (W - 60, by + 180)], radius=16, fill=C_GREY_BOX)
draw_c_text(W // 2, by + 90, "Banner Promo & Info Kampung (16:5)", f_h2)

# 6. Pre-Order Catalog Showcase
py = by + 220
draw_c_text(W // 2, py, "Katalog Pre-Order Qurban 2026", f_h2)
draw_c_text(W // 2, py + 30, "Pemesanan sapi lebih awal dengan perawatan hingga hari raya", f_sub)
po_w = (W - 120 - 40) // 3
po_h = 230
po_y = py + 65
for i in range(3):
    px1 = 60 + i * (po_w + 20)
    px2 = px1 + po_w
    d.rounded_rectangle([(px1, po_y), (px2, po_y + po_h)], radius=16, fill=C_GREY_BOX)
    draw_c_text((px1 + px2) // 2, po_y + po_h // 2, f"Catalog Pre-Order {i+1}", f_card)

# 7. Footer
fy = po_y + po_h + 60
d.rectangle([(0, fy), (W, H)], fill=C_GREY_BOX)
draw_c_text(W // 2, fy + 50, "Footer Section", f_h1)
draw_c_text(W // 2, fy + 85, "Tentang SIPETER  •  Navigasi Cepat  •  Kontak & Lokasi Balai Dusun Sukamaju", f_sub)
draw_c_text(W // 2, fy + 120, "© 2026 SIPETER (Sistem Penjualan Ternak Sapi Kampung Suka Maju)", f_small)

output2 = 'public/images/sketsa_beranda_lengkap_hitam_putih.png'
img_full.save(output2, 'PNG')
img_full.save(os.path.join(artifact_dir, 'sketsa_beranda_lengkap_hitam_putih.png'), 'PNG')
print(f"Saved {output2}")
