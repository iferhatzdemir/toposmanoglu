<!--
════════════════════════════════════════════════════════════════════════════════
    MODERN FOOTER COMPONENT - Gül Kurusu Paleti
    ────────────────────────────────────────────────────────────────────────────
    Architecture: BEM Methodology + Modern CSS Grid
    Accessibility: WCAG 2.1 AA Compliant
    Performance: GPU-Accelerated, Micro-animations
    Design System: Rose Pink Palette + Glassmorphism
    Features: Dark Mode, RTL Support, Motion-Safe Animations
════════════════════════════════════════════════════════════════════════════════
-->

<footer class="footer" role="contentinfo" aria-label="Site Footer">

    <!-- ============================================================
         NEWSLETTER CTA SECTION
         Modern card-based design with glassmorphism
    ============================================================ -->
    <section class="footer__newsletter" aria-labelledby="newsletter-heading">
        <div class="footer__newsletter-container container">
            <div class="footer__newsletter-card">

                <!-- Content Column -->
                <div class="footer__newsletter-content">
                    <span class="footer__newsletter-badge" aria-hidden="true">
                        GÜNCEL KALIN
                    </span>
                    <h2 id="newsletter-heading" class="footer__newsletter-title">
                        Bültenimize Abone Olun
                    </h2>
                    <p class="footer__newsletter-desc">
                        En yeni ürünler ve kampanyalardan haberdar olun
                    </p>
                </div>

                <!-- Form Column -->
                <div class="footer__newsletter-form-wrapper">
                    <form
                        action="<?=SITE?>newsletter-kayit"
                        method="POST"
                        class="footer__newsletter-form"
                        id="newsletterForm"
                        novalidate
                    >
                        <div class="footer__form-group">
                            <label for="newsletter-email" class="sr-only">E-posta adresi</label>
                            <div class="footer__input-group">
                                <svg class="footer__input-icon" aria-hidden="true" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M3 5L10 10L17 5M3 5V15H17V5H3Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <input
                                    type="email"
                                    id="newsletter-email"
                                    name="email"
                                    class="footer__input"
                                    placeholder="ornek@email.com"
                                    required
                                    aria-required="true"
                                    aria-describedby="newsletter-privacy"
                                    autocomplete="email"
                                >
                            </div>
                            <button
                                type="submit"
                                class="footer__btn footer__btn--primary"
                                aria-label="Bültene abone ol"
                            >
                                <span class="footer__btn-content">
                                    <svg class="footer__btn-icon" aria-hidden="true" width="18" height="18" viewBox="0 0 18 18">
                                        <path d="M16 2L8 10M16 2L11 16L8 10M16 2L2 7L8 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="footer__btn-text">ABONE OL</span>
                                </span>
                                <span class="footer__btn-loader" aria-hidden="true"></span>
                            </button>
                        </div>

                        <small id="newsletter-privacy" class="footer__form-privacy">
                            <svg class="footer__privacy-icon" aria-hidden="true" width="14" height="14" viewBox="0 0 14 14">
                                <path d="M7 1L3 3V6C3 9 7 11 7 11C7 11 11 9 11 6V3L7 1Z" stroke="currentColor" stroke-width="1.2" fill="none"/>
                            </svg>
                            Gizliliğiniz bizim için önemlidir. E-posta adresiniz üçüncü şahıslarla paylaşılmayacaktır.
                        </small>
                    </form>
                </div>

            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="footer__newsletter-deco" aria-hidden="true">
            <span class="footer__deco-circle footer__deco-circle--1"></span>
            <span class="footer__deco-circle footer__deco-circle--2"></span>
            <span class="footer__deco-circle footer__deco-circle--3"></span>
        </div>
    </section>

    <!-- ============================================================
         MAIN FOOTER CONTENT
         Semantic grid layout with accessible navigation
    ============================================================ -->
    <div class="footer__main">
        <div class="container">
            <div class="footer__grid">

                <!-- Company Info Block -->
                <div class="footer__col footer__col--brand">
                    <div class="footer__brand">
                        <a href="<?=SITE?>" class="footer__logo-link" aria-label="Ana sayfaya dön">
                            <img
                                src="<?=SITE?>assets/img/logo.png"
                                alt="<?=$ayar['site_title']?>"
                                class="footer__logo"
                                width="150"
                                height="50"
                                loading="lazy"
                            >
                        </a>
                        <p class="footer__tagline">
                            Taze, organik ve doğal ürünlerle sağlıklı yaşamınıza katkı sağlıyoruz.
                        </p>

                        <!-- Social Media -->
                        <nav class="footer__social" aria-label="Sosyal medya linkleri">
                            <?php if(!empty($ayar['facebook'])): ?>
                            <a href="<?=$ayar['facebook']?>" class="footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="Facebook'ta takip edin">
                                <svg width="20" height="20" viewBox="0 0 20 20" aria-hidden="true"><path d="M20 10C20 4.477 15.523 0 10 0S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" fill="currentColor"/></svg>
                            </a>
                            <?php endif; ?>

                            <?php if(!empty($ayar['twitter'])): ?>
                            <a href="<?=$ayar['twitter']?>" class="footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="Twitter'da takip edin">
                                <svg width="20" height="20" viewBox="0 0 20 20" aria-hidden="true"><path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" fill="currentColor"/></svg>
                            </a>
                            <?php endif; ?>

                            <?php if(!empty($ayar['instagram'])): ?>
                            <a href="<?=$ayar['instagram']?>" class="footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="Instagram'da takip edin">
                                <svg width="20" height="20" viewBox="0 0 20 20" aria-hidden="true"><path d="M10 0C7.284 0 6.944.012 5.877.06 4.813.11 4.086.278 3.45.525a4.896 4.896 0 00-1.772 1.153A4.908 4.908 0 00.525 3.45C.278 4.086.109 4.813.06 5.877.012 6.944 0 7.284 0 10s.012 3.056.06 4.123c.05 1.064.218 1.791.465 2.427a4.883 4.883 0 001.153 1.772 4.915 4.915 0 001.772 1.153c.636.247 1.363.416 2.427.465 1.067.048 1.407.06 4.123.06s3.056-.012 4.123-.06c1.064-.05 1.791-.218 2.427-.465a4.89 4.89 0 001.772-1.153 4.904 4.904 0 001.153-1.772c.247-.636.416-1.363.465-2.427.048-1.067.06-1.407.06-4.123s-.012-3.056-.06-4.123c-.05-1.064-.218-1.791-.465-2.427a4.88 4.88 0 00-1.153-1.772A4.897 4.897 0 0016.55.525C15.914.278 15.187.109 14.123.06 13.056.012 12.716 0 10 0zm0 1.802c2.67 0 2.987.01 4.041.059.976.045 1.505.207 1.858.344.466.182.8.399 1.15.748.35.35.566.684.748 1.15.137.353.3.882.344 1.857.048 1.055.058 1.37.058 4.04 0 2.671-.01 2.987-.058 4.042-.045.975-.207 1.504-.344 1.857a3.097 3.097 0 01-.748 1.15c-.35.35-.684.566-1.15.748-.353.137-.882.3-1.857.344-1.054.048-1.37.058-4.041.058-2.67 0-2.987-.01-4.04-.058-.976-.045-1.505-.207-1.858-.344a3.098 3.098 0 01-1.15-.748 3.098 3.098 0 01-.748-1.15c-.137-.353-.3-.882-.344-1.857-.048-1.055-.058-1.37-.058-4.041 0-2.67.01-2.986.058-4.04.045-.976.207-1.505.344-1.858.182-.466.399-.8.748-1.15.35-.35.684-.566 1.15-.748.353-.137.882-.3 1.857-.344 1.055-.048 1.37-.058 4.041-.058zM10 13.33A3.33 3.33 0 1110 6.67a3.33 3.33 0 010 6.66zm0-8.462a5.132 5.132 0 100 10.264 5.132 5.132 0 000-10.264zm6.538-.203a1.2 1.2 0 11-2.4 0 1.2 1.2 0 012.4 0z" fill="currentColor"/></svg>
                            </a>
                            <?php endif; ?>

                            <?php if(!empty($ayar['linkedin'])): ?>
                            <a href="<?=$ayar['linkedin']?>" class="footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn'de takip edin">
                                <svg width="20" height="20" viewBox="0 0 20 20" aria-hidden="true"><path d="M18.52 0H1.476C.66 0 0 .645 0 1.44v17.12C0 19.355.66 20 1.476 20h17.044c.816 0 1.48-.645 1.48-1.44V1.44C20 .645 19.336 0 18.52 0zM5.924 17.04H2.97V7.5h2.954v9.54zM4.447 6.195a1.71 1.71 0 110-3.42 1.71 1.71 0 010 3.42zM17.04 17.04h-2.952v-4.64c0-1.105-.02-2.526-1.538-2.526-1.54 0-1.776 1.202-1.776 2.444v4.722H7.822V7.5h2.832v1.305h.04c.394-.747 1.356-1.538 2.792-1.538 2.987 0 3.539 1.966 3.539 4.522v5.251z" fill="currentColor"/></svg>
                            </a>
                            <?php endif; ?>

                            <?php if(!empty($ayar['youtube'])): ?>
                            <a href="<?=$ayar['youtube']?>" class="footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="YouTube'da takip edin">
                                <svg width="20" height="20" viewBox="0 0 20 20" aria-hidden="true"><path d="M19.582 4.726s-.193-1.363-.784-1.963c-.75-.785-1.591-.788-1.976-.834C14.07 1.73 10.002 1.73 10.002 1.73h-.004s-4.068 0-6.82.199c-.385.046-1.225.049-1.976.834-.59.6-.784 1.963-.784 1.963S0 6.311 0 7.896v1.483c0 1.585.418 3.17.418 3.17s.193 1.363.784 1.963c.75.785 1.735.76 2.174.842 1.577.151 6.624.198 6.624.198s4.072-.006 6.822-.205c.385-.046 1.225-.049 1.976-.834.59-.6.784-1.963.784-1.963S20 10.964 20 9.38V7.896c0-1.585-.418-3.17-.418-3.17zM7.938 12.26V6.087l5.267 3.097-5.267 3.076z" fill="currentColor"/></svg>
                            </a>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>

                <!-- Quick Links -->
                <nav class="footer__col footer__col--accordion" aria-labelledby="quick-links-heading">
                    <h3 id="quick-links-heading" class="footer__heading footer__heading--toggle">
                        <span class="footer__heading-text">Hızlı Erişim</span>
                        <button class="footer__toggle-btn" aria-label="Menüyü aç/kapat" aria-expanded="false">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </h3>
                    <ul class="footer__list" role="list">
                        <li><a href="<?=SITE?>" class="footer__link">Ana Sayfa</a></li>
                        <li><a href="<?=SITE?>hakkimizda.html" class="footer__link">Hakkımızda</a></li>
                        <li><a href="<?=SITE?>urunler.html" class="footer__link">Ürünler</a></li>
                        <li><a href="<?=SITE?>kampanyalar.html" class="footer__link">Kampanyalar</a></li>
                        <li><a href="<?=SITE?>blog.html" class="footer__link">Blog</a></li>
                        <li><a href="<?=SITE?>iletisim.html" class="footer__link">İletişim</a></li>
                    </ul>
                </nav>

                <!-- Customer Service -->
                <nav class="footer__col footer__col--accordion" aria-labelledby="service-links-heading">
                    <h3 id="service-links-heading" class="footer__heading footer__heading--toggle">
                        <span class="footer__heading-text">Müşteri Hizmetleri</span>
                        <button class="footer__toggle-btn" aria-label="Menüyü aç/kapat" aria-expanded="false">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </h3>
                    <ul class="footer__list" role="list">
                        <li><a href="<?=SITE?>siparis-takibi.html" class="footer__link">Sipariş Takibi</a></li>
                        <li><a href="<?=SITE?>kargo-bilgileri.html" class="footer__link">Kargo Bilgileri</a></li>
                        <li><a href="<?=SITE?>iade-degisim.html" class="footer__link">İade & Değişim</a></li>
                        <li><a href="<?=SITE?>sss.html" class="footer__link">Sıkça Sorulanlar</a></li>
                        <li><a href="<?=SITE?>garanti-kosullari.html" class="footer__link">Garanti Koşulları</a></li>
                    </ul>
                </nav>

                <!-- My Account -->
                <nav class="footer__col footer__col--accordion" aria-labelledby="account-links-heading">
                    <h3 id="account-links-heading" class="footer__heading footer__heading--toggle">
                        <span class="footer__heading-text">Hesabım</span>
                        <button class="footer__toggle-btn" aria-label="Menüyü aç/kapat" aria-expanded="false">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </h3>
                    <ul class="footer__list" role="list">
                        <li><a href="<?=SITE?>hesabim.html" class="footer__link">Hesap Bilgilerim</a></li>
                        <li><a href="<?=SITE?>siparislerim.html" class="footer__link">Siparişlerim</a></li>
                        <li><a href="<?=SITE?>favorilerim.html" class="footer__link">Favorilerim</a></li>
                        <li><a href="<?=SITE?>adreslerim.html" class="footer__link">Adreslerim</a></li>
                        <li><a href="<?=SITE?>cikis.html" class="footer__link">Çıkış Yap</a></li>
                    </ul>
                </nav>

                <!-- Contact Info -->
                <div class="footer__col footer__col--contact footer__col--accordion">
                    <h3 class="footer__heading footer__heading--toggle">
                        <span class="footer__heading-text">İletişim</span>
                        <button class="footer__toggle-btn" aria-label="Menüyü aç/kapat" aria-expanded="false">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </h3>
                    <address class="footer__contact">
                        <?php if(!empty($ayar['telefon'])): ?>
                        <a href="tel:<?=preg_replace('/[^0-9+]/', '', $ayar['telefon'])?>" class="footer__contact-item">
                            <span class="footer__contact-icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true">
                                    <path d="M17 13.5V16C17 16.5523 16.5523 17 16 17C7.71573 17 1 10.2843 1 2C1 1.44772 1.44772 1 2 1H4.5C5.05228 1 5.5 1.44772 5.5 2C5.5 3.06155 5.71035 4.07141 6.09258 5C6.17672 5.22827 6.12965 5.48376 5.97046 5.66889L4.41125 7.50755C5.59178 9.72825 7.27175 11.4082 9.49245 12.5887L11.3311 11.0295C11.5162 10.8704 11.7717 10.8233 12 10.9074C12.9286 11.2896 13.9385 11.5 15 11.5C15.5523 11.5 16 11.9477 16 12.5V15C16 15.5523 15.5523 16 15 16Z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="footer__contact-text"><?=$ayar['telefon']?></span>
                        </a>
                        <?php endif; ?>

                        <?php if(!empty($ayar['email'])): ?>
                        <a href="mailto:<?=$ayar['email']?>" class="footer__contact-item">
                            <span class="footer__contact-icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true">
                                    <path d="M3 4L9 9L15 4M3 4V14H15V4H3Z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="footer__contact-text"><?=$ayar['email']?></span>
                        </a>
                        <?php endif; ?>

                        <?php if(!empty($ayar['adres'])): ?>
                        <div class="footer__contact-item">
                            <span class="footer__contact-icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true">
                                    <path d="M9 1C6.23858 1 4 3.23858 4 6C4 9 9 14 9 14C9 14 14 9 14 6C14 3.23858 11.7614 1 9 1ZM9 8C7.89543 8 7 7.10457 7 6C7 4.89543 7.89543 4 9 4C10.1046 4 11 4.89543 11 6C11 7.10457 10.1046 8 9 8Z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="footer__contact-text"><?=stripslashes($ayar['adres'])?></span>
                        </div>
                        <?php endif; ?>

                        <?php if(!empty($ayar['calisma_saatleri'])): ?>
                        <div class="footer__contact-item">
                            <span class="footer__contact-icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true">
                                    <circle cx="9" cy="9" r="7" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <path d="M9 5V9L12 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="footer__contact-text"><?=stripslashes($ayar['calisma_saatleri'])?></span>
                        </div>
                        <?php endif; ?>
                    </address>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================================
         COPYRIGHT BAR
         Legal links and copyright notice
    ============================================================ -->
    <div class="footer__bottom">
        <div class="container">
            <div class="footer__bottom-grid">
                <!-- Copyright -->
                <div class="footer__copyright">
                    <p>
                        &copy; <?=date('Y')?>
                        <a href="<?=SITE?>" class="footer__site-link"><?=$ayar['site_title']?></a>
                        - Tüm Hakları Saklıdır
                    </p>
                </div>

                <!-- Legal Links -->
                <nav class="footer__legal" aria-label="Yasal linkler">
                    <a href="<?=SITE?>gizlilik-politikasi.html" class="footer__legal-link">Gizlilik Politikası</a>
                    <span class="footer__separator" aria-hidden="true">•</span>
                    <a href="<?=SITE?>kullanim-kosullari.html" class="footer__legal-link">Kullanım Koşulları</a>
                    <span class="footer__separator" aria-hidden="true">•</span>
                    <a href="<?=SITE?>kvkk.html" class="footer__legal-link">KVKK</a>
                    <span class="footer__separator" aria-hidden="true">•</span>
                    <a href="<?=SITE?>cerez-politikasi.html" class="footer__legal-link">Çerez Politikası</a>
                </nav>
            </div>
        </div>
    </div>

    <!-- ============================================================
         SCROLL TO TOP BUTTON
         Accessibility-enhanced with progress indicator
    ============================================================ -->
    <button
        type="button"
        id="scrollToTop"
        class="footer__scroll-top"
        aria-label="Sayfanın başına dön"
        data-visible="false"
    >
        <svg class="footer__scroll-icon" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 19V5M12 5L5 12M12 5L19 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <svg class="footer__scroll-progress" viewBox="0 0 100 100" aria-hidden="true">
            <circle cx="50" cy="50" r="48" />
        </svg>
    </button>

</footer>

<!-- ============================================================
     JAVASCRIPT - Progressive Enhancement
     Modular, debounced, performance-optimized
============================================================ -->
<script>
(function() {
    'use strict';

    // Utility: Debounce
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // ═══════════════════════════════════════════════════════════
    // Newsletter Form Handler
    // ═══════════════════════════════════════════════════════════
    const newsletterForm = document.getElementById('newsletterForm');

    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = this;
            const submitBtn = form.querySelector('.footer__btn--primary');
            const btnContent = submitBtn.querySelector('.footer__btn-content');
            const btnLoader = submitBtn.querySelector('.footer__btn-loader');
            const emailInput = form.querySelector('#newsletter-email');

            // Validation
            if (!emailInput.validity.valid) {
                emailInput.focus();
                return;
            }

            // UI State: Loading
            submitBtn.disabled = true;
            submitBtn.setAttribute('aria-busy', 'true');
            btnContent.style.opacity = '0';
            btnLoader.style.display = 'block';

            try {
                const formData = new FormData(form);
                const response = await fetch('<?=SITE?>newsletter-kayit', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // Success State
                    submitBtn.classList.add('footer__btn--success');
                    btnLoader.style.display = 'none';
                    btnContent.innerHTML = '<svg width="18" height="18" viewBox="0 0 18 18"><path d="M15 5L7 13L3 9" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Başarılı!</span>';
                    btnContent.style.opacity = '1';

                    form.reset();

                    // Reset after 3s
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.removeAttribute('aria-busy');
                        submitBtn.classList.remove('footer__btn--success');
                        btnContent.innerHTML = '<svg class="footer__btn-icon" width="18" height="18" viewBox="0 0 18 18"><path d="M16 2L8 10M16 2L11 16L8 10M16 2L2 7L8 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span class="footer__btn-text">ABONE OL</span>';
                    }, 3000);
                } else {
                    throw new Error(data.message || 'Bir hata oluştu');
                }
            } catch (error) {
                // Error State
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                console.error('Newsletter error:', error);

                submitBtn.disabled = false;
                submitBtn.removeAttribute('aria-busy');
                btnLoader.style.display = 'none';
                btnContent.style.opacity = '1';
            }
        });
    }

    // ═══════════════════════════════════════════════════════════
    // Scroll to Top Button
    // ═══════════════════════════════════════════════════════════
    const scrollBtn = document.getElementById('scrollToTop');
    const scrollProgress = scrollBtn?.querySelector('.footer__scroll-progress circle');

    if (scrollBtn && scrollProgress) {
        const circumference = 2 * Math.PI * 48;
        scrollProgress.style.strokeDasharray = circumference;

        const handleScroll = debounce(() => {
            const scrollPercentage = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            const offset = circumference - (scrollPercentage / 100) * circumference;
            scrollProgress.style.strokeDashoffset = offset;

            if (window.scrollY > 300) {
                scrollBtn.setAttribute('data-visible', 'true');
            } else {
                scrollBtn.setAttribute('data-visible', 'false');
            }
        }, 10);

        window.addEventListener('scroll', handleScroll, { passive: true });

        scrollBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // ═══════════════════════════════════════════════════════════
    // Intersection Observer for Animations
    // ═══════════════════════════════════════════════════════════
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('footer__col--visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        document.querySelectorAll('.footer__col').forEach(el => {
            observer.observe(el);
        });
    }

    // ═══════════════════════════════════════════════════════════
    // Mobile Footer Accordion
    // ═══════════════════════════════════════════════════════════
    function initFooterAccordion() {
        // Only enable accordion on mobile devices
        if (window.innerWidth > 767) {
            return;
        }

        const toggleButtons = document.querySelectorAll('.footer__toggle-btn');

        toggleButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const heading = this.closest('.footer__heading');
                const content = heading.nextElementSibling;
                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                // Toggle aria-expanded
                this.setAttribute('aria-expanded', !isExpanded);

                // Toggle open class on content
                if (content) {
                    content.classList.toggle('footer__list--open');
                    content.classList.toggle('footer__contact--open');
                }

                // Toggle active class on button for rotation
                this.classList.toggle('footer__toggle-btn--active');
            });
        });
    }

    // Initialize on load
    initFooterAccordion();

    // Re-initialize on resize (with debounce)
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            // Remove all open states when resizing to desktop
            if (window.innerWidth > 767) {
                document.querySelectorAll('.footer__list, .footer__contact').forEach(el => {
                    el.classList.remove('footer__list--open', 'footer__contact--open');
                });
                document.querySelectorAll('.footer__toggle-btn').forEach(btn => {
                    btn.setAttribute('aria-expanded', 'false');
                    btn.classList.remove('footer__toggle-btn--active');
                });
            }
        }, 150);
    });

})();
</script>

<style>
/*
════════════════════════════════════════════════════════════════════════════════
    FOOTER STYLES - Enterprise CSS Architecture
    ────────────────────────────────────────────────────────────────────────────
    Methodology: BEM + ITCSS + Atomic Design
    Performance: GPU-Accelerated, Critical CSS Inline
    Browser Support: ES6+ browsers, Progressive Enhancement
════════════════════════════════════════════════════════════════════════════════
*/

/* ═══════════════════════════════════════════════════════════
   DESIGN TOKENS - Gül Kurusu Paleti
   CSS Custom Properties for theming and maintenance
════════════════════════════════════════════════════════════ */
:root {
    /* Rose Pink Color Palette */
    --footer-rose-50: #fff1f3;
    --footer-rose-100: #ffe4e8;
    --footer-rose-200: #fecdd3;
    --footer-rose-300: #fda4af;
    --footer-rose-400: #fb7185;
    --footer-rose-500: #f43f5e; /* Primary accent */
    --footer-rose-600: #e11d48;
    --footer-rose-700: #be123c;
    --footer-rose-800: #9f1239;
    --footer-rose-900: #881337;
    
    /* Neutral Colors */
    --footer-ink-900: #0f172a; /* Dark text */
    --footer-ink-700: #1f2937;
    --footer-gray-500: #6b7280;
    --footer-gray-200: #e5e7eb;
    --footer-white: #ffffff;
    --footer-black: #000000;
    
    /* Semantic Color Mappings */
    --footer-primary: var(--footer-rose-500);
    --footer-primary-dark: var(--footer-rose-600);
    --footer-primary-light: var(--footer-rose-400);
    --footer-accent: var(--footer-rose-400);
    --footer-accent-light: var(--footer-rose-300);
    --footer-accent-dark: var(--footer-rose-600);
    --footer-dark: var(--footer-ink-900);
    --footer-darker: #0a0f1a;

    /* Semantic Colors */
    --footer-text-primary: rgba(255, 255, 255, 0.95);
    --footer-text-secondary: rgba(255, 255, 255, 0.8);
    --footer-text-muted: rgba(255, 255, 255, 0.65);
    --footer-text-dark: rgba(0, 0, 0, 0.87);

    /* Spacing Scale (8pt grid) */
    --footer-space-xs: 0.5rem;
    --footer-space-sm: 1rem;
    --footer-space-md: 1.5rem;
    --footer-space-lg: 2rem;
    --footer-space-xl: 3rem;
    --footer-space-2xl: 4rem;
    --footer-space-3xl: 6rem;

    /* Typography Scale */
    --footer-text-xs: clamp(0.75rem, 0.7rem + 0.2vw, 0.875rem);
    --footer-text-sm: clamp(0.875rem, 0.825rem + 0.2vw, 1rem);
    --footer-text-base: clamp(1rem, 0.95rem + 0.2vw, 1.125rem);
    --footer-text-lg: clamp(1.125rem, 1.05rem + 0.3vw, 1.25rem);
    --footer-text-xl: clamp(1.25rem, 1.15rem + 0.4vw, 1.5rem);
    --footer-text-2xl: clamp(1.5rem, 1.35rem + 0.6vw, 2rem);
    --footer-text-3xl: clamp(2rem, 1.75rem + 1vw, 2.5rem);

    /* Border Radius */
    --footer-radius-sm: 0.375rem;
    --footer-radius-md: 0.5rem;
    --footer-radius-lg: 0.75rem;
    --footer-radius-xl: 1rem;
    --footer-radius-full: 9999px;

    /* Shadows */
    --footer-shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
    --footer-shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
    --footer-shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
    --footer-shadow-xl: 0 12px 32px rgba(0, 0, 0, 0.2);

    /* Transitions */
    --footer-transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
    --footer-transition-base: 250ms cubic-bezier(0.4, 0, 0.2, 1);
    --footer-transition-slow: 350ms cubic-bezier(0.4, 0, 0.2, 1);
    --footer-transition-spring: 400ms cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Dark Mode Support */
[data-theme="dark"] {
    --footer-rose-50: #1f0f13;
    --footer-rose-100: #2d1419;
    --footer-rose-200: #3d1a22;
    --footer-rose-300: #4d202b;
    --footer-rose-400: #5d2634;
    --footer-rose-500: #f43f5e; /* Keep primary accent */
    --footer-rose-600: #fb7185;
    --footer-rose-700: #fda4af;
    --footer-rose-800: #fecdd3;
    --footer-rose-900: #ffe4e8;
    --footer-ink-900: #f8fafc;
    --footer-ink-700: #e2e8f0;
    --footer-gray-500: #94a3b8;
    --footer-gray-200: #334155;
    --footer-white: #0f172a;
    --footer-black: #ffffff;
    
    /* Update semantic mappings for dark mode */
    --footer-primary: var(--footer-rose-500);
    --footer-primary-dark: var(--footer-rose-400);
    --footer-primary-light: var(--footer-rose-600);
    --footer-accent: var(--footer-rose-400);
    --footer-accent-light: var(--footer-rose-300);
    --footer-accent-dark: var(--footer-rose-600);
    --footer-dark: var(--footer-ink-900);
    --footer-darker: #0a0f1a;
}

/* ═══════════════════════════════════════════════════════════
   SCREEN READER ONLY (Accessibility Utility)
════════════════════════════════════════════════════════════ */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
}

/* ═══════════════════════════════════════════════════════════
   FOOTER WRAPPER - Gül Kurusu Gradient
════════════════════════════════════════════════════════════ */
.footer {
    background: linear-gradient(180deg, var(--footer-rose-50) 0%, var(--footer-white) 100%);
    color: var(--footer-ink-900);
    position: relative;
    overflow: hidden;
}

/* Dark mode footer background */
[data-theme="dark"] .footer {
    background: linear-gradient(180deg, var(--footer-ink-900) 0%, var(--footer-ink-700) 100%);
    color: var(--footer-white);
}

/* ═══════════════════════════════════════════════════════════
   NEWSLETTER SECTION - Gül Kurusu Glassmorphism
════════════════════════════════════════════════════════════ */
.footer__newsletter {
    position: relative;
    background: linear-gradient(135deg, var(--footer-rose-100) 0%, var(--footer-rose-200) 50%, var(--footer-rose-100) 100%);
    padding: clamp(3rem, 5vw, 5rem) 0;
    overflow: hidden;
    border-top: 1px solid var(--footer-rose-200);
    border-bottom: 1px solid var(--footer-rose-200);
}

/* Dark mode newsletter */
[data-theme="dark"] .footer__newsletter {
    background: linear-gradient(135deg, var(--footer-ink-700) 0%, var(--footer-ink-900) 50%, var(--footer-ink-700) 100%);
    border-top: 1px solid var(--footer-gray-200);
    border-bottom: 1px solid var(--footer-gray-200);
}

/* Newsletter Decorative Circles */
.footer__newsletter-deco {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}

.footer__deco-circle {
    position: absolute;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
    border-radius: 50%;
    will-change: transform;
}

.footer__deco-circle--1 {
    width: 200px;
    height: 200px;
    top: -100px;
    right: 10%;
    animation: float-slow 10s ease-in-out infinite;
}

.footer__deco-circle--2 {
    width: 150px;
    height: 150px;
    bottom: -75px;
    left: 15%;
    animation: float-slow 12s ease-in-out infinite 2s;
}

.footer__deco-circle--3 {
    width: 100px;
    height: 100px;
    top: 50%;
    left: 5%;
    animation: float-slow 8s ease-in-out infinite 4s;
}

@keyframes float-slow {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(20px, -20px) rotate(120deg); }
    66% { transform: translate(-20px, -10px) rotate(240deg); }
}

.footer__newsletter-container {
    position: relative;
    z-index: 1;
}

.footer__newsletter-card {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: clamp(2rem, 4vw, 4rem);
    align-items: center;
}

/* Newsletter Content */
.footer__newsletter-content {
    display: flex;
    flex-direction: column;
    gap: var(--footer-space-md);
}

.footer__newsletter-badge {
    display: inline-block;
    align-self: flex-start;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, rgba(244, 63, 94, 0.1), rgba(251, 113, 133, 0.2));
    backdrop-filter: blur(10px);
    border: 1px solid rgba(244, 63, 94, 0.3);
    border-radius: var(--footer-radius-full);
    font-size: var(--footer-text-xs);
    font-weight: 800;
    letter-spacing: 0.15em;
    color: var(--footer-rose-700);
    box-shadow: 0 2px 12px rgba(244, 63, 94, 0.2);
    transition: all var(--footer-transition-base);
}

.footer__newsletter-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(244, 63, 94, 0.3);
}

.footer__newsletter-title {
    font-size: clamp(1.75rem, 3vw, 2.5rem);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.02em;
    color: var(--footer-ink-900);
    margin: 0;
    text-shadow: 0 2px 8px rgba(244, 63, 94, 0.1);
    background: linear-gradient(135deg, var(--footer-ink-900), var(--footer-rose-600));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.footer__newsletter-desc {
    font-size: var(--footer-text-base);
    line-height: 1.6;
    color: var(--footer-gray-500);
    max-width: 28ch;
    margin: 0;
}

/* Dark mode newsletter text */
[data-theme="dark"] .footer__newsletter-title {
    color: var(--footer-white);
    background: linear-gradient(135deg, var(--footer-white), var(--footer-rose-400));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

[data-theme="dark"] .footer__newsletter-desc {
    color: var(--footer-gray-500);
}

/* Newsletter Form */
.footer__newsletter-form-wrapper {
    flex: 1;
}

.footer__form-group {
    display: flex;
    flex-direction: column;
    gap: var(--footer-space-md);
}

.footer__input-group {
    display: flex;
    gap: var(--footer-space-sm);
    align-items: stretch;
}

.footer__input-icon {
    position: absolute;
    left: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(0, 0, 0, 0.4);
    width: 20px;
    height: 20px;
    pointer-events: none;
    transition: color var(--footer-transition-base);
}

.footer__input {
    flex: 1;
    padding: 1.25rem 1.5rem 1.25rem 3.5rem;
    background: rgba(255, 255, 255, 0.95);
    border: 2px solid var(--footer-rose-200);
    border-radius: var(--footer-radius-full);
    font-size: var(--footer-text-base);
    font-weight: 500;
    color: var(--footer-ink-900);
    outline: none;
    transition: all var(--footer-transition-base);
    box-shadow: 0 4px 16px rgba(244, 63, 94, 0.08);
    backdrop-filter: blur(10px);
    will-change: transform, box-shadow;
}

.footer__input::placeholder {
    color: rgba(0, 0, 0, 0.4);
}

.footer__input:focus {
    background: var(--footer-white);
    border-color: var(--footer-rose-400);
    box-shadow: 0 8px 24px rgba(244, 63, 94, 0.15);
    transform: translateY(-2px);
}

.footer__input:focus + .footer__input-icon {
    color: var(--footer-rose-500);
}

.footer__btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 1.25rem 2.5rem;
    background: linear-gradient(135deg, var(--footer-rose-500) 0%, var(--footer-rose-600) 100%);
    border: 2px solid var(--footer-rose-400);
    border-radius: var(--footer-radius-full);
    font-size: var(--footer-text-sm);
    font-weight: 800;
    letter-spacing: 0.1em;
    color: var(--footer-white);
    cursor: pointer;
    outline: none;
    overflow: hidden;
    transition: all var(--footer-transition-base);
    box-shadow: 0 4px 20px rgba(244, 63, 94, 0.3);
    will-change: transform, box-shadow;
}

.footer__btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.footer__btn:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 8px 32px rgba(244, 63, 94, 0.4);
    border-color: var(--footer-rose-300);
    background: linear-gradient(135deg, var(--footer-rose-600) 0%, var(--footer-rose-700) 100%);
}

.footer__btn:hover::before {
    transform: translateX(100%);
}

.footer__btn:active {
    transform: translateY(-1px) scale(1);
}

.footer__btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    pointer-events: none;
}

.footer__btn-content {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    transition: opacity var(--footer-transition-base);
}

.footer__btn-icon {
    width: 18px;
    height: 18px;
}

.footer__btn-loader {
    position: absolute;
    display: none;
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: var(--footer-white);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.footer__btn--success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.footer__form-privacy {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    font-size: var(--footer-text-xs);
    color: rgba(0, 0, 0, 0.65);
    line-height: 1.5;
    padding-left: 0.5rem;
}

.footer__privacy-icon {
    flex-shrink: 0;
    width: 14px;
    height: 14px;
    margin-top: 0.125rem;
    color: rgba(0, 0, 0, 0.5);
}

/* ═══════════════════════════════════════════════════════════
   MAIN FOOTER CONTENT
   CSS Grid Layout with Auto-fit
════════════════════════════════════════════════════════════ */
.footer__main {
    padding: clamp(3rem, 6vw, 6rem) 0 clamp(2rem, 4vw, 3rem);
    position: relative;
}

.footer__main::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--footer-rose-400), var(--footer-rose-500), var(--footer-rose-400), transparent);
    opacity: 0.3;
}

.footer__grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: clamp(2rem, 4vw, 3rem);
}

/* Grid Column Variations */
.footer__col--brand {
    grid-column: span 2;
}

@media (max-width: 991px) {
    .footer__col--brand {
        grid-column: span 1;
    }
}

/* Footer Columns */
.footer__col {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.footer__col--visible {
    opacity: 1;
    transform: translateY(0);
}

/* Brand Section */
.footer__brand {
    display: flex;
    flex-direction: column;
    gap: var(--footer-space-lg);
}

.footer__logo-link {
    display: inline-block;
    transition: transform var(--footer-transition-base);
}

.footer__logo-link:hover {
    transform: scale(1.05);
}

.footer__logo {
    max-height: 50px;
    width: auto;
    filter: drop-shadow(0 2px 8px rgba(232, 180, 184, 0.25));
}

.footer__tagline {
    font-size: var(--footer-text-sm);
    line-height: 1.7;
    color: var(--footer-text-secondary);
    margin: 0;
    max-width: 32ch;
}

/* Social Links */
.footer__social {
    display: flex;
    gap: var(--footer-space-sm);
    flex-wrap: wrap;
}

.footer__social-link {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
    color: var(--footer-white);
    transition: all var(--footer-transition-spring);
    will-change: transform;
}

.footer__social-link::before {
    content: '';
    position: absolute;
    inset: -2px;
    background: linear-gradient(135deg, var(--footer-accent), var(--footer-accent-light));
    border-radius: 50%;
    opacity: 0;
    transition: opacity var(--footer-transition-base);
    z-index: -1;
}

.footer__social-link:hover {
    transform: translateY(-4px) rotate(5deg);
    color: var(--footer-white);
}

.footer__social-link:hover::before {
    opacity: 1;
}

.footer__social-link svg {
    width: 20px;
    height: 20px;
    transition: transform var(--footer-transition-base);
}

.footer__social-link:hover svg {
    transform: scale(1.1);
}

/* Headings */
.footer__heading {
    margin: 0 0 var(--footer-space-lg);
    font-size: var(--footer-text-base);
    font-weight: 800;
    letter-spacing: 0.1em;
    color: var(--footer-ink-900);
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--footer-space-sm);
}

/* Dark mode headings */
[data-theme="dark"] .footer__heading {
    color: var(--footer-white);
}

.footer__heading-text {
    position: relative;
}

.footer__heading-text::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 32px;
    height: 3px;
    background: linear-gradient(90deg, var(--footer-rose-400), var(--footer-rose-500));
    border-radius: 2px;
}

/* Mobile Accordion Toggle Button */
.footer__toggle-btn {
    display: none; /* Hidden by default on desktop */
    background: none;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    color: var(--footer-rose-500);
    transition: all var(--footer-transition-base);
    margin: -0.5rem -0.5rem -0.5rem 0;
}

.footer__toggle-btn svg {
    display: block;
    transition: transform var(--footer-transition-base);
}

.footer__toggle-btn--active svg {
    transform: rotate(180deg);
}

.footer__toggle-btn:hover {
    color: var(--footer-rose-600);
    transform: scale(1.1);
}

.footer__toggle-btn:focus {
    outline: 2px solid var(--footer-rose-500);
    outline-offset: 2px;
    border-radius: 4px;
}

/* Navigation Lists */
.footer__list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: var(--footer-space-sm);
}

.footer__link {
    position: relative;
    display: inline-block;
    font-size: var(--footer-text-sm);
    color: var(--footer-gray-500);
    text-decoration: none;
    transition: all var(--footer-transition-base);
    padding-left: 0;
}

.footer__link::before {
    content: '';
    position: absolute;
    left: -12px;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 4px;
    background: var(--footer-rose-400);
    border-radius: 50%;
    opacity: 0;
    transition: all var(--footer-transition-base);
}

.footer__link:hover {
    color: var(--footer-rose-500);
    padding-left: 12px;
}

.footer__link:hover::before {
    opacity: 1;
    left: 0;
}

/* Contact Section */
.footer__contact {
    display: flex;
    flex-direction: column;
    gap: var(--footer-space-md);
    font-style: normal;
}

.footer__contact-item {
    display: flex;
    align-items: flex-start;
    gap: var(--footer-space-sm);
    padding: var(--footer-space-sm);
    background: rgba(244, 63, 94, 0.02);
    border-radius: var(--footer-radius-md);
    transition: all var(--footer-transition-base);
    text-decoration: none;
    color: var(--footer-gray-500);
}

.footer__contact-item:hover {
    background: rgba(244, 63, 94, 0.08);
    transform: translateX(4px);
}

.footer__contact-icon {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--footer-rose-400), var(--footer-rose-600));
    border-radius: 50%;
    color: var(--footer-white);
    transition: all var(--footer-transition-spring);
}

.footer__contact-item:hover .footer__contact-icon {
    transform: rotate(360deg) scale(1.1);
}

.footer__contact-text {
    flex: 1;
    font-size: var(--footer-text-sm);
    line-height: 1.6;
    color: inherit;
}

/* ═══════════════════════════════════════════════════════════
   FOOTER BOTTOM (Copyright Bar)
════════════════════════════════════════════════════════════ */
.footer__bottom {
    background: rgba(244, 63, 94, 0.05);
    padding: var(--footer-space-lg) 0;
    border-top: 1px solid var(--footer-rose-200);
    position: relative;
}

.footer__bottom::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--footer-rose-400), var(--footer-rose-500), var(--footer-rose-400), transparent);
    opacity: 0.4;
}

.footer__bottom-grid {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: var(--footer-space-lg);
}

.footer__copyright p {
    margin: 0;
    font-size: var(--footer-text-sm);
    color: var(--footer-gray-500);
}

.footer__site-link {
    color: var(--footer-rose-500);
    font-weight: 700;
    text-decoration: none;
    position: relative;
    transition: color var(--footer-transition-base);
}

.footer__site-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--footer-rose-400);
    transition: width var(--footer-transition-base);
}

.footer__site-link:hover {
    color: var(--footer-rose-600);
}

.footer__site-link:hover::after {
    width: 100%;
}

/* Legal Links */
.footer__legal {
    display: flex;
    align-items: center;
    gap: var(--footer-space-sm);
    flex-wrap: wrap;
}

.footer__legal-link {
    font-size: var(--footer-text-sm);
    color: var(--footer-gray-500);
    text-decoration: none;
    position: relative;
    transition: color var(--footer-transition-base);
}

.footer__legal-link::before {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: var(--footer-rose-400);
    transition: width var(--footer-transition-base);
}

.footer__legal-link:hover {
    color: var(--footer-rose-500);
}

.footer__legal-link:hover::before {
    width: 100%;
}

.footer__separator {
    color: rgba(255, 255, 255, 0.2);
    font-weight: 300;
}

/* ═══════════════════════════════════════════════════════════
   SCROLL TO TOP BUTTON
   With progress indicator
════════════════════════════════════════════════════════════ */
.footer__scroll-top {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 1000;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--footer-rose-500), var(--footer-rose-400));
    border: none;
    border-radius: 50%;
    color: var(--footer-white);
    cursor: pointer;
    outline: none;
    box-shadow: 0 4px 16px rgba(244, 63, 94, 0.4);
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px) scale(0.8);
    transition: all var(--footer-transition-spring);
    will-change: transform, opacity;
}

.footer__scroll-top[data-visible="true"] {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

.footer__scroll-top:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 8px 24px rgba(244, 63, 94, 0.6);
}

.footer__scroll-top:active {
    transform: translateY(-2px) scale(0.98);
}

.footer__scroll-icon {
    position: relative;
    z-index: 2;
}

.footer__scroll-progress {
    position: absolute;
    top: -2px;
    left: -2px;
    width: calc(100% + 4px);
    height: calc(100% + 4px);
    transform: rotate(-90deg);
    pointer-events: none;
}

.footer__scroll-progress circle {
    fill: none;
    stroke: var(--footer-white);
    stroke-width: 2;
    stroke-linecap: round;
    transition: stroke-dashoffset 0.1s linear;
}

/* ═══════════════════════════════════════════════════════════
   RESPONSIVE DESIGN
   Mobile-first, fluid typography
════════════════════════════════════════════════════════════ */
@media (max-width: 991px) {
    .footer__newsletter-card {
        grid-template-columns: 1fr;
        gap: var(--footer-space-xl);
        text-align: center;
    }

    .footer__newsletter-content {
        align-items: center;
    }

    .footer__newsletter-desc {
        max-width: 100%;
    }

    .footer__input-group {
        flex-direction: column;
    }

    .footer__grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }
}

@media (max-width: 767px) {
    /* Mobile Accordion Styles */
    .footer__toggle-btn {
        display: flex; /* Show toggle button on mobile */
        align-items: center;
        justify-content: center;
    }

    .footer__heading--toggle {
        cursor: pointer;
        margin-bottom: var(--footer-space-sm);
    }

    .footer__list,
    .footer__contact {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transform: translateY(-10px);
        transition: all var(--footer-transition-slow);
    }

    .footer__list--open,
    .footer__contact--open {
        max-height: 500px; /* Large enough to accommodate content */
        opacity: 1;
        transform: translateY(0);
        margin-bottom: var(--footer-space-lg);
        padding-top: var(--footer-space-sm);
    }

    /* Ensure brand column accordion doesn't apply */
    .footer__col--brand .footer__toggle-btn {
        display: none;
    }

    .footer__col--brand .footer__brand,
    .footer__col--brand .footer__tagline,
    .footer__col--brand .footer__social {
        max-height: none;
        opacity: 1;
        transform: none;
    }

    .footer__bottom-grid {
        flex-direction: column;
        text-align: center;
        gap: var(--footer-space-md);
    }

    .footer__legal {
        flex-direction: column;
        gap: var(--footer-space-sm);
    }

    .footer__separator {
        display: none;
    }

    .footer__scroll-top {
        width: 48px;
        height: 48px;
        bottom: 1.5rem;
        right: 1.5rem;
    }
}

/* ═══════════════════════════════════════════════════════════
   ACCESSIBILITY
   WCAG 2.1 AA Compliant
════════════════════════════════════════════════════════════ */
.footer a:focus,
.footer button:focus {
    outline: 3px solid var(--footer-rose-500);
    outline-offset: 3px;
}

.footer a:focus:not(:focus-visible),
.footer button:focus:not(:focus-visible) {
    outline: none;
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    .footer {
        border-top: 2px solid var(--footer-white);
    }

    .footer__link,
    .footer__legal-link {
        text-decoration: underline;
    }
}

/* ═══════════════════════════════════════════════════════════
   RTL SUPPORT
   Right-to-left language support
════════════════════════════════════════════════════════════ */
:dir(rtl) .footer__link {
    padding-left: 0;
    padding-right: 0;
}

:dir(rtl) .footer__link::before {
    left: auto;
    right: -12px;
}

:dir(rtl) .footer__link:hover {
    padding-left: 0;
    padding-right: 12px;
}

:dir(rtl) .footer__link:hover::before {
    left: auto;
    right: 0;
}

:dir(rtl) .footer__contact-item:hover {
    transform: translateX(-4px);
}

:dir(rtl) .footer__heading-text::after {
    left: auto;
    right: 0;
}

:dir(rtl) .footer__site-link::after {
    left: auto;
    right: 0;
}

/* Print Styles */
@media print {
    .footer__newsletter,
    .footer__scroll-top {
        display: none;
    }
}
</style>

<!--********************************
    Modern Footer Component - Gül Kurusu Paleti
    Production Ready - v3.0.0
    Features: Dark Mode, RTL Support, Micro-animations
    Color Palette: Rose Pink (#f43f5e) + Neutrals
******************************** -->
