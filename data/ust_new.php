<style>
/* ═══════════════════════════════════════════════════════════
   GÜL KURUSU TEMA - Özgıda Toposmanoğlu  
   Tutarlı desktop ve mobil tasarım
════════════════════════════════════════════════════════════ */

:root {
    --rose-primary: #D4A5A5;
    --rose-light: #E8C4C4;
    --rose-dark: #B88B8B;
    --neutral-dark: #5A4A4A;
    --neutral-medium: #8B7B7B;
    --neutral-light: #F5F0F0;
}

/* Desktop + Mobil Ortak Stiller */
header.version_1 .main_header,
header.version_1 .main_nav {
    background: #fff;
    border-bottom: 1px solid var(--neutral-light);
}

.phone_top { color: var(--neutral-dark) !important; }
.phone_top:hover { color: var(--rose-primary) !important; }
.phone_top strong { color: var(--rose-dark) !important; }

/* Arama Kutusu */
.custom-search-input {
    background: var(--neutral-light) !important;
    border: 1px solid rgba(212,165,165,0.2);
    border-radius: 25px;
}
.custom-search-input:hover {
    border-color: rgba(212,165,165,0.4);
    box-shadow: 0 2px 12px rgba(212,165,165,0.15);
}
.custom-search-input button:hover {
    color: var(--rose-primary) !important;
}

/* Sepet Badge */
header ul.top_tools a.cart_bt strong {
    background: linear-gradient(135deg, var(--rose-primary), var(--rose-dark)) !important;
    color: #fff !important;
    width: 20px !important;
    height: 20px !important;
    border-radius: 50%;
    font-size: 10px !important;
    position: absolute !important;
    top: 0 !important;
    right: -5px !important;
}

/* Nav Hover */
header ul.top_tools a:hover,
.main-menu ul li a:hover {
    color: var(--rose-primary) !important;
}

/* Kategoriler */
.categories ul li:hover > span a {
    color: var(--rose-primary) !important;
}

/* Butonlar */
.btn_1 {
    background: linear-gradient(135deg, var(--rose-primary), var(--rose-dark)) !important;
    color: #fff !important;
}
.btn_1.outline {
    background: transparent !important;
    border: 2px solid var(--rose-primary) !important;
    color: var(--rose-primary) !important;
}

/* Mobil */
@media (max-width: 991px) {
    header .main_nav ul.top_tools {
        display: flex !important;
        gap: 5px !important;
        height: 60px !important;
    }
    header .main_nav ul.top_tools > li a {
        width: 40px !important;
        height: 40px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 50%;
    }
    header .main_nav ul.top_tools > li a:hover {
        background: var(--neutral-light) !important;
    }
    header .main_nav ul.top_tools a.cart_bt strong {
        width: 18px !important;
        height: 18px !important;
        font-size: 9px !important;
    }
}
</style>
