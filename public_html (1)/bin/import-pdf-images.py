#!/usr/bin/env python3
"""
One-time import: converts the extracted PDF product photos into WEBP
and places them in assets/images/products/{slug}/, matching each PDF
section to the corresponding product page. Source JPGs/PNGs come from
/tmp/pdf_extract (produced by bin/extract-pdf-images step, not checked
in). Safe to re-run - overwrites with the same numbered filenames.
"""
import os
from PIL import Image

SRC = "/tmp/pdf_extract"
DEST_ROOT = os.path.join(os.path.dirname(__file__), "..", "assets", "images", "products")
MAX_DIM = 1600

MAPPING = {
    "container-houses": ["p03_i01", "p03_i02"],
    "prefabricated-buildings": ["p03_i03", "p04_i01", "p04_i02", "p04_i03", "p04_i04", "p04_i05", "p04_i06"],
    "electrical-enclosures": ["p05_i01", "p05_i02", "p05_i03"],
    "grp-water-tanks": ["p05_i04", "p05_i05"],
    "flanges-fittings": ["p06_i01", "p06_i02", "p06_i03", "p06_i04", "p07_i01", "p07_i02", "p07_i03", "p07_i04"],
    "motors-pumps-valves": [
        "p07_i05", "p07_i06",
        "p08_i01", "p08_i02", "p08_i03", "p08_i04", "p08_i05", "p08_i06", "p08_i07", "p08_i08",
        "p09_i01", "p09_i02", "p09_i03",
        "p10_i01", "p10_i02", "p10_i03", "p10_i04", "p10_i05",
    ],
    "chequered-plates": ["p10_i06", "p10_i07"],
    "electronics": ["p11_i01", "p11_i02", "p12_i01", "p12_i02", "p19_i01"],
    "perforated-sheets": ["p13_i01", "p13_i02"],
    "building-materials": [
        "p13_i03", "p13_i04",
        "p14_i01", "p14_i02", "p14_i03", "p14_i04", "p14_i05", "p14_i06",
        "p15_i01", "p15_i02",
        "p16_i01", "p16_i02",
        "p17_i01", "p17_i02", "p17_i03", "p17_i04",
    ],
    "electrical-plumbing": ["p18_i01", "p18_i02", "p18_i03", "p18_i04", "p18_i05", "p18_i06", "p18_i07"],
    "anchor-bolts": ["p19_i02", "p19_i03", "p19_i04", "p19_i05", "p19_i06", "p19_i07", "p19_i08"],
    "hdpe-vibrating-screen-plates": ["p20_i01", "p20_i02"],
    "paper-core-end-plugs": ["p20_i03", "p20_i04", "p20_i05", "p21_i01", "p21_i02"],
    "silos-tanks": ["p22_i01", "p22_i02", "p22_i03", "p22_i04", "p22_i05", "p22_i06", "p22_i07", "p22_i08"],
    "packing-items": ["p23_i01", "p23_i02", "p23_i03", "p23_i04", "p24_i01", "p24_i02", "p24_i03", "p24_i04"],
    "light-poles": ["p24_i05", "p25_i01", "p25_i02", "p25_i03", "p25_i04", "p25_i05"],
    "granites-natural-stones": ["p25_i06", "p25_i07", "p26_i01", "p26_i02", "p26_i03"],
    "athangudi-tiles": ["p26_i04", "p26_i05", "p26_i06", "p27_i01", "p27_i02", "p27_i03", "p27_i04", "p27_i05"],
    "paver-blocks": ["p27_i06", "p27_i07", "p28_i01", "p28_i02", "p28_i03", "p28_i04"],
}


def find_source(basename):
    for ext in (".jpg", ".jpeg", ".png"):
        p = os.path.join(SRC, basename + ext)
        if os.path.isfile(p):
            return p
    raise FileNotFoundError(basename)


total = 0
for slug, basenames in MAPPING.items():
    dest_dir = os.path.join(DEST_ROOT, slug)
    os.makedirs(dest_dir, exist_ok=True)
    for idx, basename in enumerate(basenames, start=1):
        src_path = find_source(basename)
        img = Image.open(src_path)
        if img.mode in ("RGBA", "P", "LA"):
            bg = Image.new("RGB", img.size, (255, 255, 255))
            img = img.convert("RGBA")
            bg.paste(img, mask=img.split()[-1])
            img = bg
        else:
            img = img.convert("RGB")

        w, h = img.size
        if max(w, h) > MAX_DIM:
            scale = MAX_DIM / max(w, h)
            img = img.resize((int(w * scale), int(h * scale)), Image.LANCZOS)

        dest_path = os.path.join(dest_dir, f"{idx:02d}.webp")
        img.save(dest_path, "WEBP", quality=82, method=6)
        total += 1
    print(f"{slug}: {len(basenames)} image(s) -> {dest_dir}")

print(f"\nTotal images written: {total}")
