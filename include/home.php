    <!--==============================
      Hero Slider - Özgıda Toposmanoğlu
    ==============================-->
    <style>
    /* Hero Slider */
    .ozgida-hero-slider {
        position: relative;
        width: 100%;
        min-height: 600px;
        overflow: hidden;
        background: linear-gradient(135deg, #FFF1F2 0%, #FFE4E6 100%);
    }

    .ozgida-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 1s ease, visibility 1s ease;
    }

    .ozgida-slide.active {
        opacity: 1;
        visibility: visible;
        z-index: 1;
    }

    .ozgida-slide-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
    }

    .ozgida-slide-bg img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        animation: kenBurns 15s ease-out infinite alternate;
    }

    @keyframes kenBurns {
        0% { transform: scale(1); }
        100% { transform: scale(1.08); }
    }

    /* Overlay for better text readability */
    .ozgida-slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.2) 50%, transparent 100%);
        z-index: 1;
        opacity: 0.7;
    }

    .ozgida-slide-content {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        align-items: center;
        padding: 80px 0;
    }

    .ozgida-slide-inner {
        max-width: 650px;
    }

    .ozgida-slide-title {
        font-size: 4rem;
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        color: #FFFFFF;
        text-shadow: 2px 2px 12px rgba(0, 0, 0, 0.3), 0 0 40px rgba(244, 63, 94, 0.3);
        animation: slideUpFade 1s ease-out;
    }

    @keyframes slideUpFade {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .ozgida-slide-desc {
        font-size: 1.25rem;
        color: #F3F4F6;
        margin-bottom: 2rem;
        line-height: 1.7;
        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
        animation: slideUpFade 1s ease-out 0.3s both;
    }

    .ozgida-slide-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem 2.5rem;
        background: linear-gradient(135deg, #F43F5E 0%, #E11D48 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.125rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 20px rgba(244, 63, 94, 0.3);
        animation: slideUpFade 1s ease-out 0.5s both;
    }

    .ozgida-slide-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(244, 63, 94, 0.5);
        background: linear-gradient(135deg, #E11D48 0%, #BE123C 100%);
        color: white;
    }

    .ozgida-slide-btn i {
        transition: transform 0.3s ease;
    }

    .ozgida-slide-btn:hover i {
        transform: translateX(6px);
    }

    /* Navigation */
    .ozgida-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        background: rgba(255, 255, 255, 0.95);
        border: none;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        font-size: 1.25rem;
        color: #881337;
    }

    .ozgida-nav:hover {
        background: #F43F5E;
        color: white;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 6px 20px rgba(244, 63, 94, 0.4);
    }

    .ozgida-nav-prev { left: 2rem; }
    .ozgida-nav-next { right: 2rem; }

    /* Pagination */
    .ozgida-pagination {
        position: absolute;
        bottom: 2.5rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        display: flex;
        gap: 0.75rem;
    }

    .ozgida-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        border: 2px solid white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .ozgida-dot:hover {
        background: rgba(244, 63, 94, 0.7);
        transform: scale(1.2);
    }

    .ozgida-dot.active {
        background: #F43F5E;
        width: 36px;
        border-radius: 8px;
    }

    /* Responsive Design - Mobile First */
    @media (max-width: 1200px) {
        .ozgida-slide-title { font-size: 3rem; }
        .ozgida-slide-inner { max-width: 550px; }
    }

    @media (max-width: 992px) {
        .ozgida-hero-slider { min-height: 500px; }
        .ozgida-slide-title { font-size: 2.5rem; }
        .ozgida-slide-desc { font-size: 1.125rem; }
        .ozgida-slide-inner { max-width: 100%; padding: 2rem; }
        .ozgida-slide-content { padding: 60px 0; }
        .ozgida-nav { width: 48px; height: 48px; font-size: 1rem; }
        .ozgida-nav-prev { left: 1rem; }
        .ozgida-nav-next { right: 1rem; }
    }

    @media (max-width: 768px) {
        .ozgida-hero-slider { min-height: 450px; }
        .ozgida-slide-title { font-size: 2rem; margin-bottom: 1rem; }
        .ozgida-slide-desc { font-size: 1rem; margin-bottom: 1.5rem; }
        .ozgida-slide-btn { padding: 1rem 2rem; font-size: 1rem; }
        .ozgida-slide-content { padding: 40px 0; }
        .ozgida-pagination { bottom: 1.5rem; }
        .ozgida-dot { width: 10px; height: 10px; }
        .ozgida-dot.active { width: 24px; }
    }

    @media (max-width: 576px) {
        .ozgida-hero-slider { min-height: 400px; }
        .ozgida-slide-title { font-size: 1.5rem; }
        .ozgida-slide-desc { font-size: 0.875rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .ozgida-slide-btn { padding: 0.875rem 1.75rem; font-size: 0.9375rem; gap: 0.5rem; }
        .ozgida-slide-inner { padding: 1.5rem; }
        .ozgida-nav { width: 40px; height: 40px; font-size: 0.875rem; }
        .ozgida-nav-prev { left: 0.5rem; }
        .ozgida-nav-next { right: 0.5rem; }
        .ozgida-pagination { bottom: 1rem; gap: 0.5rem; }
    }

    @media (max-width: 400px) {
        .ozgida-hero-slider { min-height: 350px; }
        .ozgida-slide-title { font-size: 1.25rem; }
        .ozgida-slide-desc { display: none; }
        .ozgida-slide-btn { padding: 0.75rem 1.5rem; font-size: 0.875rem; }
        .ozgida-slide-inner { padding: 1rem; }
    }

    /* Touch Optimization */
    @media (hover: none) and (pointer: coarse) {
        .ozgida-nav { width: 52px; height: 52px; }
        .ozgida-dot { width: 16px; height: 16px; }
        .ozgida-dot.active { width: 32px; }
        .ozgida-slide-btn { padding: 1.125rem 2.25rem; }
    }
    </style>

    <section class="ozgida-hero-slider">
        <?php
        $banners = $VT->VeriGetir("banner", "WHERE durum=?", array(1), "ORDER BY sirano ASC");
        $hasBanners = ($banners !== false && count($banners) > 0);

        if($hasBanners) {
            foreach($banners as $index => $banner) {
                $isActive = ($index === 0) ? 'active' : '';
                $title = !empty($banner["baslik"]) ? stripslashes($banner["baslik"]) : "";
                $desc = !empty($banner["aciklama"]) ? stripslashes($banner["aciklama"]) : "";
                $btnText = !empty($banner["butontext"]) ? stripslashes($banner["butontext"]) : "Alışverişe Başla";
                $link = !empty($banner["link"]) ? $banner["link"] : SITE . "urunler";
                $image = SITE . "images/banner/" . $banner["resim"];
                $mobileImage = !empty($banner["resim_mobil"]) ? SITE . "images/banner/" . $banner["resim_mobil"] : $image;
                $altText = !empty($title) ? $title : "Özgıda Toposmanoğlu Bannerı";
                ?>
                <div class="ozgida-slide <?=$isActive?>" data-slide="<?=$index?>">
                    <picture class="ozgida-slide-bg">
                        <source srcset="<?=$mobileImage?>" media="(max-width: 991px)">
                        <img src="<?=$image?>" alt="<?=$altText?>" loading="<?=$index === 0 ? 'eager' : 'lazy'?>">
                    </picture>

                    <div class="ozgida-slide-content">
                        <div class="container">
                            <div class="ozgida-slide-inner">
                                <?php if(!empty($title)): ?>
                                    <h1 class="ozgida-slide-title"><?=$title?></h1>
                                <?php endif; ?>
                                <?php if(!empty($desc)): ?>
                                    <p class="ozgida-slide-desc"><?=$desc?></p>
                                <?php endif; ?>
                                <a href="<?=$link?>" class="ozgida-slide-btn">
                                    <?=$btnText?>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="ozgida-slide active">
                <picture class="ozgida-slide-bg">
                    <source srcset="<?=SITE?>img/hero/hero-bg-7-1.jpg" media="(max-width: 991px)">
                    <img src="<?=SITE?>img/hero/hero-bg-7-1.jpg" alt="Özgıda Toposmanoğlu">
                </picture>

                <div class="ozgida-slide-content">
                    <div class="container">
                        <div class="ozgida-slide-inner">
                            <h1 class="ozgida-slide-title">Doğal ve Organik Ürünler</h1>
                            <p class="ozgida-slide-desc">Isparta'nın en kaliteli gül ürünleri, reçelleri ve şifalı karışımları</p>
                            <a href="<?=SITE?>urunler" class="ozgida-slide-btn">
                                Alışverişe Başla
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <?php if($hasBanners && count($banners) > 1): ?>
            <button class="ozgida-nav ozgida-nav-prev" onclick="ozgidaSlider.prev()" aria-label="Önceki">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="ozgida-nav ozgida-nav-next" onclick="ozgidaSlider.next()" aria-label="Sonraki">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div class="ozgida-pagination">
                <?php foreach($banners as $index => $banner): ?>
                    <span class="ozgida-dot <?=$index === 0 ? 'active' : ''?>"
                          onclick="ozgidaSlider.goTo(<?=$index?>)"
                          data-slide="<?=$index?>"></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <?php if($hasBanners && count($banners) > 1): ?>
    <script>
    const ozgidaSlider = {
        current: 0,
        total: <?=count($banners)?>,
        interval: null,
        touchStartX: 0,
        touchEndX: 0,

        init() {
            this.startAutoplay();
            this.initKeyboard();
            this.initTouch();
            this.initMousePause();
        },

        // Keyboard navigation
        initKeyboard() {
            document.addEventListener('keydown', (e) => {
                if(e.key === 'ArrowLeft') this.prev();
                if(e.key === 'ArrowRight') this.next();
                if(e.key === 'Escape') this.stopAutoplay();
            });
        },

        // Touch/Swipe support
        initTouch() {
            const slider = document.querySelector('.ozgida-hero-slider');

            slider.addEventListener('touchstart', (e) => {
                this.touchStartX = e.changedTouches[0].screenX;
                this.stopAutoplay();
            }, {passive: true});

            slider.addEventListener('touchend', (e) => {
                this.touchEndX = e.changedTouches[0].screenX;
                this.handleSwipe();
                this.startAutoplay();
            }, {passive: true});
        },

        handleSwipe() {
            const swipeThreshold = 50;
            const diff = this.touchStartX - this.touchEndX;

            if(Math.abs(diff) > swipeThreshold) {
                if(diff > 0) {
                    this.next(); // Swipe left
                } else {
                    this.prev(); // Swipe right
                }
            }
        },

        // Mouse pause
        initMousePause() {
            const slider = document.querySelector('.ozgida-hero-slider');
            slider.addEventListener('mouseenter', () => this.stopAutoplay());
            slider.addEventListener('mouseleave', () => this.startAutoplay());
        },

        goTo(index) {
            if(index === this.current) return;

            // Remove active classes
            document.querySelectorAll('.ozgida-slide, .ozgida-dot').forEach(el => {
                el.classList.remove('active');
            });

            // Add active classes
            const slides = document.querySelectorAll('.ozgida-slide');
            const dots = document.querySelectorAll('.ozgida-dot');

            if(slides[index]) {
                slides[index].classList.add('active');
                // Trigger animation restart
                const content = slides[index].querySelector('.ozgida-slide-inner');
                if(content) {
                    content.style.animation = 'none';
                    setTimeout(() => {
                        content.style.animation = '';
                    }, 10);
                }
            }
            if(dots[index]) dots[index].classList.add('active');

            this.current = index;

            // Announce for screen readers
            this.announceSlide(index);
        },

        announceSlide(index) {
            const slides = document.querySelectorAll('.ozgida-slide');
            if(slides[index]) {
                const title = slides[index].querySelector('.ozgida-slide-title');
                if(title && 'speechSynthesis' in window) {
                    // Optional: screen reader announcement (can be disabled)
                    // speechSynthesis.cancel();
                    // const utterance = new SpeechSynthesisUtterance(`Slide ${index + 1} of ${this.total}`);
                    // speechSynthesis.speak(utterance);
                }
            }
        },

        next() {
            this.goTo((this.current + 1) % this.total);
        },

        prev() {
            this.goTo((this.current - 1 + this.total) % this.total);
        },

        startAutoplay() {
            this.stopAutoplay();
            this.interval = setInterval(() => this.next(), 5000);
        },

        stopAutoplay() {
            if(this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
        }
    };

    // Initialize slider
    if(document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => ozgidaSlider.init());
    } else {
        ozgidaSlider.init();
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        ozgidaSlider.stopAutoplay();
    });
    </script>
    <?php endif; ?>
    <!--==============================
      About Us Area
    ==============================-->
    <section class="sec-bg10  space-top space-md-bottom" data-bg-src="assets/img/bg/bg-1.png">
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-lg-6">
                    <div class="img-box5">
                        <div class="img-1">
                            <img src="assets/img/about/about-1.png" alt="image">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-30">
                    <span class="sub-title4">Özgıda Toposmanoğlu Nedir?</span>
                    <h2 class="sec-title4">Doğal Gıda Doğayla Uyum İçinde Üretilir</h2>
                    <div class="row">
                        <div class="col-xl-10">
                            <p class="sec-text mb-lg-5 pe-lg-3">Isparta'nın bereketli topraklarında, geleneksel yöntemlerle ürettiğimiz gül reçeli, tahin, pekmez ve helva ürünlerimiz ile sofranıza lezzet ve sağlık getiriyoruz. %100 doğal, katkısız ve el emeği göz nuru ürünlerimiz ile ailenizin sağlığına değer katıyoruz.</p>
                        </div>
                    </div>
                    <div class="block-schedule">
                        <img src="assets/img/icons/ab-icon-0088.png" alt="Çalışma Saatleri">
                        <p class="text">Pazartesi - Cumartesi: 9:00 - 18:00 | Pazar: Kapalı</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
    Categories Area
    ==============================-->
    <section class=" space-md-bottom" data-bg-src="assets/img/shape/cat-bg-656.png">
        <div class="container">
            <div class="section-title text-center">
                <div class="sec-icon"><img src="assets/img/icons/sec-icon-2.png" alt="icon"></div>
                <span class="sub-title4">Neler Sunuyoruz</span>
                <h2 class="sec-title3">Popüler Kategoriler</h2>
            </div>
            <div class="row justify-content-center vs-carousel dots-style2" data-slide-show="5" data-lg-slide-show="4" data-md-slide-show="3" data-sm-slide-show="1" data-infinite="false" data-dots="true">
                <?php
                // Sadece aktif olan ve 'urunler' tablosuna ait kategorileri çek
                $kategoriler = $VT->VeriGetir("kategoriler", "WHERE durum=? AND tablo=?", array(1, "urunler"), "ORDER BY sirano ASC LIMIT 6");
                if($kategoriler != false) {
                    for($i=0; $i<count($kategoriler); $i++) {
                        // Her kategori için aktif ürün sayısını hesapla
                        $urunSayisi = $VT->VeriGetir("urunler", "WHERE kategori=? AND durum=?", array($kategoriler[$i]["ID"], 1), "");
                        $urunSayisiText = ($urunSayisi != false) ? count($urunSayisi) : 0;

                        // Resim yolu - eğer resim varsa kullan, yoksa varsayılan resim kullan
                        $resimYolu = !empty($kategoriler[$i]["resim"]) ? "assets/img/icons/".$kategoriler[$i]["resim"] : "assets/img/icons/cat-icon-1-".($i%5+1).".png";
                ?>
                <div class="col-auto cat-style1">
                    <div class="cat-body">
                        <div class="cat-shape"></div>
                        <div class="cat-img">
                            <img src="<?=$resimYolu?>" alt="<?=stripslashes($kategoriler[$i]["baslik"])?>">
                        </div>
                        <h3 class="cat-title"><?=stripslashes($kategoriler[$i]["baslik"])?></h3>
                        <p class="cat-text"><?=$urunSayisiText?> Ürün</p>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <!--==============================
    Video Area
    ==============================-->
    <?php
    if (empty($introVideoUrl)) {
        $introVideoUrl = 'https://www.youtube.com/watch?v=_sI_Ps7JSEk';
    }

    if (empty($introVideoEmbedAutoplay)) {
        $introVideoEmbedAutoplay = 'https://www.youtube.com/embed/_sI_Ps7JSEk?autoplay=1&mute=1&rel=0&showinfo=0';
    }
    ?>
    <section class=" sec-bg6">
        <div class="container">
            <div class="row gx-xl-0 gy-30">
                <div class="col-lg-6 col-xl-7">
                    <div class="video-box">
                        <img src="assets/img/video/video-1-1.jpg" alt="Video image">
                        <a href="<?=htmlspecialchars($introVideoUrl, ENT_QUOTES, 'UTF-8')?>" class="play-btn style2 popup-video" data-intro-video-open="true" data-intro-video-src="<?=htmlspecialchars($introVideoEmbedAutoplay, ENT_QUOTES, 'UTF-8')?>"><i class="fas fa-play"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5">
                    <div class="banner-style2" data-bg-src="assets/img/shape/banner-0749.jpg">
                        <div class="banner-shape"></div>
                        <div class="banner-logo">
                            <img src="assets/img/banner/img-7984.png" alt="Kampanya">
                        </div>
                        <h2 class="banner-title">%70'e Varan İndirim</h2>
                        <p class="banner-text">Tüm Doğal Gıda Ürünlerinde Geçerli</p>
                        <a href="<?=SITE?>urunler" class="vs-btn style5">Alışverişe Başla<i class="far fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
    Feature Products
    ==============================-->
    <section class=" vs-shop-wrapper  space-bottom sec-bg5" data-bg-src="assets/img/shape/bg-9754.png">
        <div class="section-title text-center">
            <div class="sec-icon"><img src="assets/img/icons/sec-icon-2.png" alt="icon"></div>
            <span class="sub-title4">%100 Doğal Gıda</span>
            <h2 class="sec-title3">Öne Çıkan Ürünler</h2>
        </div>
        <div class="nav filter-menu3" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
            <button class="nav-link active" id="v-pills-Trending-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Trending" type="button" role="tab" aria-controls="v-pills-Trending" aria-selected="true"><i class="fas fa-fire-alt"></i>Popüler</button>
            <button class="nav-link" id="v-pills-Newest-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Newest" type="button" role="tab" aria-controls="v-pills-Newest" aria-selected="false"><i class="far fa-plus"></i>Yeni Ürünler</button>
        </div>
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-Trending" role="tabpanel" aria-labelledby="v-pills-Trending-tab">
                <div class="container">
                    <div class="row vs-carousel dots-style2" data-slide-show="4" data-sm-slide-show="1" data-dots="true">
                        <?php
                        // Vitrin ürünleri (trend ürünler)
                        $trendUrunler = $VT->VeriGetir("urunler", "WHERE durum=1 AND vitrindurum=1", "", "ORDER BY ID DESC LIMIT 8");
                        if($trendUrunler != false) {
                            for($i=0; $i<count($trendUrunler); $i++) {
                                // İndirim hesaplama
                                $normalFiyat = $trendUrunler[$i]["fiyat"];
                                $indirimFiyat = $trendUrunler[$i]["indirimliFiyat"];
                                $indirimOrani = 0;
                                if($indirimFiyat > 0 && $indirimFiyat < $normalFiyat) {
                                    $indirimOrani = round((($normalFiyat - $indirimFiyat) / $normalFiyat) * 100);
                                }

                                // Ürün resmi
                                $urunResim = !empty($trendUrunler[$i]["resim"]) ? "images/urunler/".$trendUrunler[$i]["resim"] : "assets/img/shop/product-4-".($i%10+1).".png";
                        ?>
                        <div class="col-xl-3">
                            <div class="vs-product-box4">
                                <div class="product-img">
                                    <a href="urun/<?=$trendUrunler[$i]["seflink"]?>"><img src="<?=$urunResim?>" alt="<?=stripslashes($trendUrunler[$i]["baslik"])?>" class="w-100"></a>
                                    <?php if($trendUrunler[$i]["vitrindurum"] == 1) { ?>
                                    <span class="product-tag1">Popüler</span>
                                    <?php } ?>
                                    <div class="product-rating-box">5.0<div class="star-rating" role="img" aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5</span></div>
                                    </div>
                                    <div class="actions-btn">
                                        <a href="<?=$urunResim?>" class="icon-btn popup-image"><i class="far fa-search"></i></a>
                                        <a href="<?=SITE?>favorilerim" class="icon-btn"><i class="fal fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4 class="product-title"><a href="urun/<?=$trendUrunler[$i]["seflink"]?>"><?=stripslashes($trendUrunler[$i]["baslik"])?></a></h4>
                                    <div class="product-quantity">
                                        Ağırlık: <span class="text"><?=$trendUrunler[$i]["kurus"]?>kg</span>
                                    </div>
                                    <span class="price">
                                        <strong>₺<?=number_format($indirimFiyat > 0 ? $indirimFiyat : $normalFiyat, 2)?></strong>
                                        <?php if($indirimFiyat > 0 && $indirimFiyat < $normalFiyat) { ?>
                                        <del>₺<?=number_format($normalFiyat, 2)?></del>
                                        <?php } ?>
                                    </span>
                                    <?php if($indirimOrani > 0) { ?>
                                    <span class="product-discount">(%<?=$indirimOrani?> indirim)</span>
                                    <?php } ?>
                                </div>
                                <a href="sepet-ekle/<?=$trendUrunler[$i]["ID"]?>" class="product-cart-btn">Sepete Ekle<i class="fal fa-cart-plus"></i></a>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-Newest" role="tabpanel" aria-labelledby="v-pills-Newest-tab">
                <div class="container">
                    <div class="row vs-carousel dots-style2" data-slide-show="4" data-sm-slide-show="1" data-dots="true">
                        <?php
                        // En yeni ürünler (tarih sıralaması)
                        $yeniUrunler = $VT->VeriGetir("urunler", "WHERE durum=1", "", "ORDER BY tarih DESC LIMIT 8");
                        if($yeniUrunler != false) {
                            for($j=0; $j<count($yeniUrunler); $j++) {
                                // İndirim hesaplama
                                $normalFiyat = $yeniUrunler[$j]["fiyat"];
                                $indirimFiyat = $yeniUrunler[$j]["indirimliFiyat"];
                                $indirimOrani = 0;
                                if($indirimFiyat > 0 && $indirimFiyat < $normalFiyat) {
                                    $indirimOrani = round((($normalFiyat - $indirimFiyat) / $normalFiyat) * 100);
                                }

                                // Ürün resmi
                                $urunResim = !empty($yeniUrunler[$j]["resim"]) ? "images/urunler/".$yeniUrunler[$j]["resim"] : "assets/img/shop/product-4-".($j%10+1).".png";
                        ?>
                        <div class="col-xl-3">
                            <div class="vs-product-box4">
                                <div class="product-img">
                                    <a href="urun/<?=$yeniUrunler[$j]["seflink"]?>"><img src="<?=$urunResim?>" alt="<?=stripslashes($yeniUrunler[$j]["baslik"])?>" class="w-100"></a>
                                    <?php if($yeniUrunler[$j]["vitrindurum"] == 1) { ?>
                                    <span class="product-tag1">Popüler</span>
                                    <?php } ?>
                                    <div class="product-rating-box">5.0<div class="star-rating" role="img" aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5</span></div>
                                    </div>
                                    <div class="actions-btn">
                                        <a href="<?=$urunResim?>" class="icon-btn popup-image"><i class="far fa-search"></i></a>
                                        <a href="<?=SITE?>favorilerim" class="icon-btn"><i class="fal fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4 class="product-title"><a href="urun/<?=$yeniUrunler[$j]["seflink"]?>"><?=stripslashes($yeniUrunler[$j]["baslik"])?></a></h4>
                                    <div class="product-quantity">
                                        Ağırlık: <span class="text"><?=$yeniUrunler[$j]["kurus"]?>kg</span>
                                    </div>
                                    <span class="price">
                                        <strong>₺<?=number_format($indirimFiyat > 0 ? $indirimFiyat : $normalFiyat, 2)?></strong>
                                        <?php if($indirimFiyat > 0 && $indirimFiyat < $normalFiyat) { ?>
                                        <del>₺<?=number_format($normalFiyat, 2)?></del>
                                        <?php } ?>
                                    </span>
                                    <?php if($indirimOrani > 0) { ?>
                                    <span class="product-discount">(%<?=$indirimOrani?> indirim)</span>
                                    <?php } ?>
                                </div>
                                <a href="sepet-ekle/<?=$yeniUrunler[$j]["ID"]?>" class="product-cart-btn">Sepete Ekle<i class="fal fa-cart-plus"></i></a>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
      How it works
    ==============================-->
    <section class="  space-top">
        <div class="shape-mockup jump-reverse d-none d-xl-block" data-right="5%" data-bottom="14%"><img src="assets/img/shape/shape-8879.png" alt="shape"></div>
        <div class="shape-mockup jump d-none d-xl-block" data-right="11.5%" data-top="18%"><img src="assets/img/shape/shape-7636.png" alt="shape"></div>
        <div class="container">
            <div class="row gx-80">
                <div class="col-lg-6 col-xl-6 mb-30">
                    <div class="img-box6">
                        <div class="img-1">
                            <img src="assets/img/about/about-2.jpg"   alt="image">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-6 mb-30">
                    <span class="sub-title4">Nasıl Çalışır?</span>
                    <h2 class="sec-title4 mb-4 pb-1">Özgida Toposman Oğlu ile organik gıda serüveninize başlamaya hazır mısınız?</h2>
                    <h3 class="text-theme h4 mb-4 pb-1">Başlamak için bilmeniz gereken her şey burada.</h3>
                    <div class="ozgida-steps-list">
                        <div class="ozgida-step-item" data-step="1">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <p>Minimum 200₺ sipariş + Ücretsiz kargo fırsatı</p>
                            </div>
                        </div>
                        <div class="ozgida-step-item" data-step="2">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <p>Siparişinizi teslimat gününden 1 gün öncesine kadar değiştirebilirsiniz</p>
                            </div>
                        </div>
                        <div class="ozgida-step-item" data-step="3">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <p>Hiçbir taahhüt yok – istediğiniz zaman iptal edebilirsiniz</p>
                            </div>
                        </div>
                        <div class="ozgida-step-item" data-step="4">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <p>Mobil uygulamamızla tek dokunuşla alışveriş yapın</p>
                            </div>
                        </div>
                        <div class="ozgida-step-item" data-step="5">
                            <div class="step-number">5</div>
                            <div class="step-content">
                                <p>Evde olmasanız bile güvenli bir yere teslimat</p>
                            </div>
                        </div>
                        <div class="ozgida-step-item" data-step="6">
                            <div class="step-number">6</div>
                            <div class="step-content">
                                <p>%100 organik ve sertifikalı ürünler garantisi</p>
                            </div>
                        </div>
                        <div class="ozgida-step-item" data-step="7">
                            <div class="step-number">7</div>
                            <div class="step-content">
                                <p>Türkiye'nin dört bir yanından doğal üreticilerden direkt tedarik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
    Gallery
  ============================== -->
<section class="space-md">
    <div class="container">
        <div class="row gx-70 align-items-center justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center mb-30">
                <span class="sub-title4">Sosyal Medyada Biz</span>
                <h2 class="sec-title4 px-md-5 mb-4 pb-4">Bizi Takip Et, En Yeni Paylaşımları Kaçırma!</h2>
                <p class="lead mb-4">
                    Güncel haberler, etkinlikler ve özel içerikler için sosyal medyada bize katıl.  
                    Her paylaşımda markamızın ruhunu yakalayın!
                </p>
                <div class="block-social">
                    <a class="facebook" href="#"><i class="fab fa-facebook-f"></i>Facebook</a>
                    <a class="twitter" href="#"><i class="fab fa-twitter"></i>Twitter</a>
                    <a class="linkedin" href="#"><i class="fab fa-linkedin-in"></i>LinkedIn</a>
                    <a class="instagram" href="#"><i class="fab fa-instagram"></i>Instagram</a>
                </div>
            </div>

            <div class="col-xl-6 mb-20">
                <div class="row filter-active2 gallery-wrap1 gx-10">
                    <?php
                    $veriler = $VT->VeriGetir("resimler", "WHERE tablo=?", array("galeri"), "ORDER BY ID DESC LIMIT 4");
                    if ($veriler && count($veriler) > 0) {
                        for ($i = 0; $i < count($veriler); $i++) {
                            $galeriResim = !empty($veriler[$i]["resim"]) ? SITE."images/resimler/".$veriler[$i]["resim"] : "assets/img/gallery/gal-3-".($i+1).".jpg";
                    ?>
                    <div class="col-md-6 col-xl-auto grid-item">
                        <div class="gallery-style1">
                            <div class="gal-img">
                                <img src="<?=$galeriResim?>" alt="Galeri Görseli" class="w-100">
                            </div>
                            <a href="<?=$galeriResim?>" class="gal-icon popup-image"><i class="far fa-eye"></i></a>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                        for ($i = 1; $i <= 4; $i++) {
                            $fallback = "assets/img/gallery/gal-3-$i.jpg";
                    ?>
                    <div class="col-md-6 col-xl-auto grid-item">
                        <div class="gallery-style1">
                            <div class="gal-img">
                                <img src="<?=$fallback?>" alt="Galeri Görseli" class="w-100">
                            </div>
                            <a href="<?=$fallback?>" class="gal-icon popup-image"><i class="far fa-eye"></i></a>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
            </div>
        </div>
    </div>
</section>


    <style>
    /* Galeri Resimleri - 892x786 Boyut */
    .gallery-style1 .gal-img img {
        width: 892px !important;
        height: 786px !important;
        object-fit: cover;
        border-radius: 8px;
    }

    /* Responsive düzenlemeler */
    @media (max-width: 1400px) {
        .gallery-style1 .gal-img img {
            width: 100% !important;
            height: auto !important;
            aspect-ratio: 892 / 786;
        }
    }

    @media (max-width: 768px) {
        .gallery-style1 .gal-img img {
            width: 100% !important;
            height: auto !important;
            aspect-ratio: 4 / 3;
        }
    }

    .video-hero {
        position: relative;
        overflow: hidden;
        background-color: #000;
    }

    .video-hero .video-background {
        position: absolute;
        inset: 0;
        z-index: 0;
    }

    .video-hero .video-background .video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .video-hero .video-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 1;
    }

    .video-hero .container {
        position: relative;
        z-index: 2;
    }

    /* Nasıl Çalışır - Modern Steps */
    .ozgida-steps-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .ozgida-step-item {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .ozgida-step-item:hover {
        transform: translateX(8px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .ozgida-step-item .step-number {
        flex-shrink: 0;
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    /* Gül kurusu renk tonları - artan sırada */
    .ozgida-step-item[data-step="1"] .step-number {
        background: linear-gradient(135deg, #FDF6F6 0%, #FAE8E9 100%);
        color: #8B5A5F;
        border: 2px solid #D4A5A5;
    }

    .ozgida-step-item[data-step="2"] .step-number {
        background: linear-gradient(135deg, #FAE8E9 0%, #F5D5D6 100%);
        color: #7B4A4F;
    }

    .ozgida-step-item[data-step="3"] .step-number {
        background: linear-gradient(135deg, #F5D5D6 0%, #EEBFC1 100%);
        color: #6B3A3F;
    }

    .ozgida-step-item[data-step="4"] .step-number {
        background: linear-gradient(135deg, #EEBFC1 0%, #D4A5A5 100%);
        color: #fff;
    }

    .ozgida-step-item[data-step="5"] .step-number {
        background: linear-gradient(135deg, #D4A5A5 0%, #C98A8F 100%);
        color: #fff;
    }

    .ozgida-step-item[data-step="6"] .step-number {
        background: linear-gradient(135deg, #C98A8F 0%, #AF6D72 100%);
        color: #fff;
    }

    .ozgida-step-item[data-step="7"] .step-number {
        background: linear-gradient(135deg, #AF6D72 0%, #8B5A5F 100%);
        color: #fff;
    }

    .ozgida-step-item:hover .step-number {
        transform: scale(1.1) rotate(5deg);
    }

    .ozgida-step-item .step-content {
        flex: 1;
    }

    .ozgida-step-item .step-content p {
        margin: 0;
        font-size: 16px;
        line-height: 1.6;
        color: #4A5D42;
        font-weight: 500;
    }

    /* Responsive - Mobil */
    @media (max-width: 768px) {
        .ozgida-step-item {
            padding: 15px;
            gap: 15px;
        }

        .ozgida-step-item .step-number {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }

        .ozgida-step-item .step-content p {
            font-size: 14px;
        }

        .ozgida-step-item:hover {
            transform: translateX(4px);
        }
    }
    </style>

    <!--==============================
    CTA Wrapper
    ==============================-->
    <section class=" space-top sec-bg7 video-hero">
        <div class="video-background">
            <!-- Video dosyasını assets/video/hero-video.mp4 yoluna ekleyerek arka planı güncelleyebilirsiniz. -->
            <video class="video" autoplay muted loop playsinline poster="assets/img/bg/cat-bg-4584.jpg">
                <source src="assets/video/hero-video.mp4" type="video/mp4">
            </video>
        </div>
        <div class="video-overlay"></div>
        <div class="container text-center">
            <span class="sub-title4 text-white">%100 Doğal ve Geleneksel</span>
            <h2 class="sec-title3 text-color2">Özgıda Toposmanoğlu</h2>
            <div class="row justify-content-center mb-xl-4 pb-1">
                <div class="col-md-9 col-lg-8 col-xl-6">
                    <p class="sec-text text-white">Isparta'nın geleneksel lezzetleri ile gül reçeli, tahin, pekmez ve helva üretiminde kalite ve doğallığı bir arada sunuyoruz</p>
                </div>
            </div>
            <div class="row justify-content-center gy-3 pt-2">
                <div class="col-auto">
                    <a href="hakkimizda.html" class="vs-btn style5">Daha Fazla<i class="fas fa-angle-right"></i></a>
                </div>
                <div class="col-auto">
                    <a href="tel:+902462273131" class="vs-btn style4"><i class="fas fa-phone-alt"></i>0246 227 31 31</a>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
    Menu Area
    ==============================-->
    <section class=" sec-bg8">
        <div class="container vs-container_style2">
            <div class="row gx-0 vs-carousel" data-slide-show="3" data-sm-slide-show="1">
                <?php
                $kategoriler = $VT->VeriGetir("kategoriler", "WHERE durum=?", array(1), "ORDER BY sirano ASC LIMIT 3");
                if($kategoriler != false) {
                    $catIndex = 1;
                    for($i = 0; $i < count($kategoriler); $i++) {
                        $katResim = !empty($kategoriler[$i]["resim"]) ? "images/kategoriler/".$kategoriler[$i]["resim"] : "assets/img/category/cat-749-".$catIndex.".jpg";
                        $katLink = !empty($kategoriler[$i]["seflink"]) ? "kategori/".$kategoriler[$i]["seflink"] : "kategori/".$kategoriler[$i]["ID"];

                        // CSS sınıfları
                        $cssClass = "";
                        $textClass = "";
                        $bgImage = "";

                        if($catIndex == 1) {
                            $cssClass = "cat-style2 no-1";
                            $textClass = "";
                        } elseif($catIndex == 2) {
                            $cssClass = "cat-style2";
                            $textClass = "text-white";
                            $bgImage = 'data-bg-src="assets/img/shape/cat-bg-794.jpg"';
                        } else {
                            $cssClass = "cat-style2 no-3";
                            $textClass = "";
                        }
                ?>
                <div class="col-lg-4">
                    <div class="<?=$cssClass?>" <?=$bgImage?>>
                        <div class="cat-body">
                            <h3 class="cat-title <?=$textClass?>"><?=stripslashes($kategoriler[$i]["baslik"])?></h3>
                            <a href="<?=$katLink?>" class="cat-link <?=$textClass?>">Ürünleri İncele</a>
                            <div class="cat-shape"><img src="assets/img/icons/cat-shape-1-<?=$catIndex?>.png" alt="Shape"></div>
                            <div class="cat-img">
                                <img src="<?=$katResim?>" alt="<?=stripslashes($kategoriler[$i]["baslik"])?>">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                        $catIndex++;
                    }
                } else {
                    // Fallback: Varsayılan statik içerik
                ?>
                <div class="col-lg-4">
                    <div class="cat-style2 no-1">
                        <div class="cat-body">
                            <h3 class="cat-title">Gül Reçeli</h3>
                            <a href="urunler.html" class="cat-link">Ürünleri İncele</a>
                            <div class="cat-shape"><img src="assets/img/icons/cat-shape-1-1.png" alt="Shape"></div>
                            <div class="cat-img">
                                <img src="assets/img/category/cat-749-1.jpg" alt="icon">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cat-style2" data-bg-src="assets/img/shape/cat-bg-794.jpg">
                        <div class="cat-body">
                            <h3 class="cat-title text-white">Tahin<br>& Pekmez</h3>
                            <a href="urunler.html" class="cat-link text-white">Ürünleri İncele</a>
                            <div class="cat-shape"><img src="assets/img/icons/cat-shape-1-2.png" alt="Shape"></div>
                            <div class="cat-img">
                                <img src="assets/img/category/cat-749-2.jpg" alt="icon">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cat-style2 no-3">
                        <div class="cat-body">
                            <h3 class="cat-title">Helva<br>Çeşitleri</h3>
                            <a href="urunler.html" class="cat-link">Ürünleri İncele</a>
                            <div class="cat-shape"><img src="assets/img/icons/cat-shape-1-3.png" alt="Shape"></div>
                            <div class="cat-img">
                                <img src="assets/img/category/cat-749-3.jpg" alt="icon">
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!--==============================
    Testimonial Area
    ==============================-->
    <section class=" space-top">
        <div class="shape-mockup jump d-none d-md-none" data-bottom="14%" data-left="41.5%"><img src="assets/img/shape/shape-5656.png" alt="shape"></div>
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-lg-6 col-xl-7 position-relative">
                    <div class="testi-img1 vs-carousel" id="testiImg" data-asnavfor="#testiconent" data-slide-show="1" data-lg-slide-show="1" data-md-slide-show="1" data-sm-slide-show="1" data-fade="true">
                        <?php
                        // Testimonials'ı burada da çek (tutarlılık için)
                        $testimonials_images = $VT->VeriGetir("testimonials", "WHERE durum=? AND onay_durumu=?", array(1, "onaylandi"), "ORDER BY sirano ASC LIMIT 5");
                        if($testimonials_images != false) {
                            for($i = 0; $i < count($testimonials_images); $i++) {
                                $testiResim = !empty($testimonials_images[$i]["resim"]) ? "images/testimonials/".$testimonials_images[$i]["resim"] : "assets/img/testimonial/testi-4-".($i+1).".png";
                        ?>
                        <div>
                            <div class="img">
                                <img src="<?=$testiResim?>" alt="<?=stripslashes($testimonials_images[$i]["ad_soyad"])?> testimonial image">
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            // Fallback resimleri
                            for($k = 1; $k <= 3; $k++) {
                        ?>
                        <div>
                            <div class="img">
                                <img src="assets/img/testimonial/testi-4-<?=$k?>.png" alt="Müşteri görüşü">
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="testi-slideTab" data-asnavfor="#testiImg">
                        <?php
                        if($testimonials_images != false) {
                            for($i = 0; $i < count($testimonials_images); $i++) {
                                $avatarResim = !empty($testimonials_images[$i]["resim"]) ? "images/testimonials/thumb_".$testimonials_images[$i]["resim"] : "assets/img/testimonial/avater-4-".($i+1).".png";
                                $activeClass = ($i == 0) ? "active" : "";
                        ?>
                        <button class="tab-btn <?=$activeClass?>" type="button"><img src="<?=$avatarResim?>" alt="<?=stripslashes($testimonials_images[$i]["ad_soyad"])?>"></button>
                        <?php
                            }
                        } else {
                            // Fallback butonları
                            for($k = 1; $k <= 3; $k++) {
                                $activeClass = ($k == 1) ? "active" : "";
                        ?>
                        <button class="tab-btn <?=$activeClass?>" type="button"><img src="assets/img/testimonial/avater-4-<?=$k?>.png" alt="Müşteri"></button>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5">
                    <span class="sub-title4">Müşteri Yorumları</span>
                    <h2 class="sec-title4 pe-xl-5 mb-lg-4 pb-lg-2">Güvenli, Doğal ve %100 Organik</h2>
                    <div class="mb-4">
                        <a href="<?=ANASITE?>yorum-gonder" class="vs-btn style2">
                            <i class="fas fa-comment"></i> Yorum Gönder
                        </a>
                    </div>
                    <div class="vs-carousel" id="testiconent" data-asnavfor="#testiImg" data-slide-show="1" data-lg-slide-show="1" data-md-slide-show="1" data-sm-slide-show="1" data-fade="true">
                        <?php
                        $testimonials = $VT->VeriGetir("testimonials", "WHERE durum=? AND onay_durumu=?", array(1, "onaylandi"), "ORDER BY sirano ASC LIMIT 5");
                        if($testimonials != false) {
                            for($i = 0; $i < count($testimonials); $i++) {
                                // Yıldız sistemi - FontAwesome iconları kullan
                                $yildizlar = "";
                                $puan = intval($testimonials[$i]["puan"]);
                                for($j = 1; $j <= 5; $j++) {
                                    if($j <= $puan) {
                                        $yildizlar .= '<i class="fas fa-star text-warning"></i>';
                                    } else {
                                        $yildizlar .= '<i class="far fa-star text-muted"></i>';
                                    }
                                }

                                // Yorum metnini kısalt (150 karakter)
                                $yorumMetni = stripslashes($testimonials[$i]["yorum"]);
                                if(strlen($yorumMetni) > 150) {
                                    $yorumMetni = substr($yorumMetni, 0, 150) . "...";
                                }

                                // Google link varsa göster
                                $googleBadge = "";
                                if(!empty($testimonials[$i]["google_link"])) {
                                    $googleBadge = ' <small><a href="'.$testimonials[$i]["google_link"].'" target="_blank" class="text-primary"><i class="fab fa-google"></i> Google\'da görüntüle</a></small>';
                                }
                        ?>
                        <div>
                            <div class="testi-style1">
                                <p class="testi-text">"<?=$yorumMetni?>"</p>
                                <div class="testi-bottom">
                                    <div class="testi-quote"><img src="assets/img/icons/quote-icon-478.png" alt=""></div>
                                    <div class="media-body">
                                        <h3 class="testi-name h4"><?=stripslashes($testimonials[$i]["ad_soyad"])?></h3>
                                        <div class="testi-rating mb-1"><?=$yildizlar?> <small class="text-muted">(<?=$puan?>/5)</small></div>
                                        <p class="testi-degi">Özgıda Toposmanoğlu'nu tavsiye ediyor<?=$googleBadge?></p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt"></i> <?=date("d.m.Y", strtotime($testimonials[$i]["tarih"]))?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            // Fallback: Varsayılan testimonials
                        ?>
                        <div>
                            <div class="testi-style1">
                                <p class="testi-text">"Özgıda Toposmanoğlu'nun doğal gıda ürünlerinden çok memnunuz. Özellikle organik zeytinyağları gerçekten kaliteli. Müşteri hizmetleri de çok ilgili..."</p>
                                <div class="testi-bottom">
                                    <div class="testi-quote"><img src="assets/img/icons/quote-icon-478.png" alt=""></div>
                                    <div class="media-body">
                                        <h3 class="testi-name h4">Mehmet Yılmaz</h3>
                                        <div class="testi-rating mb-1">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <small class="text-muted">(5/5)</small>
                                        </div>
                                        <p class="testi-degi">Özgıda Toposmanoğlu'nu tavsiye ediyor</p>
                                        <small class="text-muted"><i class="fas fa-calendar-alt"></i> 15.12.2024</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="testi-style1">
                                <p class="testi-text">"Geçen hafta online sipariş verdim, ürünler çok taze geldi. Ambalajlama da özenli yapılmış. Fiyatlar da oldukça makul. Bu firmadan alışveriş yapmaya devam edeceğim..."</p>
                                <div class="testi-bottom">
                                    <div class="testi-quote"><img src="assets/img/icons/quote-icon-478.png" alt=""></div>
                                    <div class="media-body">
                                        <h3 class="testi-name h4">Ayşe Demir</h3>
                                        <div class="testi-rating mb-1">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <small class="text-muted">(5/5)</small>
                                        </div>
                                        <p class="testi-degi">Özgıda Toposmanoğlu'nu tavsiye ediyor</p>
                                        <small class="text-muted"><i class="fas fa-calendar-alt"></i> 14.12.2024</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="testi-style1">
                                <p class="testi-text">"Yıllardır doğal ürün arıyordum, sonunda güvenebileceğim bir firma buldum. Bal ve reçelleri harika! Kargo da çok hızlı geldi..."</p>
                                <div class="testi-bottom">
                                    <div class="testi-quote"><img src="assets/img/icons/quote-icon-478.png" alt=""></div>
                                    <div class="media-body">
                                        <h3 class="testi-name h4">Ali Kaya</h3>
                                        <div class="testi-rating mb-1">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="far fa-star text-muted"></i>
                                            <small class="text-muted">(4/5)</small>
                                        </div>
                                        <p class="testi-degi">Özgıda Toposmanoğlu'nu tavsiye ediyor</p>
                                        <small class="text-muted"><i class="fas fa-calendar-alt"></i> 13.12.2024</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
        Blog Area
    ==============================-->
    <section class="vs-blog-wrapper space">
        <div class="section-title text-center">
            <div class="sec-icon"><img src="assets/img/icons/sec-icon-2.png" alt="icon"></div>
            <span class="sub-title4">Haberler & İpuçları</span>
            <h2 class="sec-title3">Son Makaleler</h2>
        </div>
        <div class="container">
            <div class="row vs-carousel" data-slide-show="3" data-sm-slide-show="1">
                <?php
                // Blog yazılarını veritabanından çek
                $bloglar = $VT->VeriGetir("bloglar", "WHERE durum=?", array(1), "ORDER BY tarih DESC LIMIT 4");
                if($bloglar != false && count($bloglar) > 0) {
                    for($i = 0; $i < count($bloglar); $i++) {
                        // Blog resmi kontrolü
                        $blogResim = !empty($bloglar[$i]["resim"]) ? "images/blog/".$bloglar[$i]["resim"] : "assets/img/blog/blog-5-".($i+1).".jpg";

                        // Blog başlığını kısalt (50 karakter)
                        $baslik = stripslashes($bloglar[$i]["baslik"]);
                        if(strlen($baslik) > 50) {
                            $baslik = substr($baslik, 0, 50) . "...";
                        }

                        // Blog özeti oluştur (120 karakter)
                        $ozet = strip_tags(stripslashes($bloglar[$i]["metin"]));
                        if(strlen($ozet) > 120) {
                            $ozet = substr($ozet, 0, 120) . "...";
                        }

                        // SEF link oluştur
                        $sefLink = !empty($bloglar[$i]["seflink"]) ? $bloglar[$i]["seflink"] : "blog-detay-".$bloglar[$i]["ID"];
                        $blogUrl = SITE."blog/".$sefLink;

                        // Tarih formatla
                        $tarih = !empty($bloglar[$i]["tarih"]) ? date("d M Y", strtotime($bloglar[$i]["tarih"])) : date("d M Y");
                ?>
                <div class="col-xl-4">
                    <div class="vs-blog blog-style2">
                        <div class="blog-img image-scale-hover">
                            <a href="<?=$blogUrl?>"><img src="<?=$blogResim?>" alt="<?=$baslik?>" class="w-100"></a>
                        </div>
                        <div class="blog-content">
                            <div class="blog-avater">
                                <img src="assets/img/blog/blog-auth-1-1.jpg" alt="Yazar">
                            </div>
                            <a href="<?=$blogUrl?>" class="blog-date"><?=$tarih?></a>
                            <div class="blog-meta">
                                <a href="<?=$blogUrl?>">Özgıda Toposmanoğlu</a>
                                <a href="<?=$blogUrl?>">Devamını Oku</a>
                            </div>
                            <h3 class="blog-title"><a href="<?=$blogUrl?>"><?=$baslik?></a></h3>
                            <?php if(!empty($ozet)) { ?>
                            <p class="blog-excerpt"><?=$ozet?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                    // Fallback: Varsayılan blog yazıları (veritabanında blog yoksa)
                ?>
                <div class="col-xl-4">
                    <div class="vs-blog blog-style2">
                        <div class="blog-img image-scale-hover">
                            <a href="blog-detay.html"><img src="assets/img/blog/blog-5-1.jpg" alt="Blog Image" class="w-100"></a>
                        </div>
                        <div class="blog-content">
                            <div class="blog-avater">
                                <img src="assets/img/blog/blog-auth-1-1.jpg" alt="Blog author">
                            </div>
                            <a href="blog-detay.html" class="blog-date"><?=date("d M Y")?></a>
                            <div class="blog-meta">
                                <a href="blog-detay.html">Özgıda Toposmanoğlu</a>
                                <a href="blog-detay.html">Devamını Oku</a>
                            </div>
                            <h3 class="blog-title"><a href="blog-detay.html">Doğal Gıda Ürünlerinin Faydaları</a></h3>
                            <p class="blog-excerpt">Doğal ve organik gıda ürünlerinin sağlığımıza olan etkilerini ve günlük yaşantımızdaki önemini keşfedin...</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="vs-blog blog-style2">
                        <div class="blog-img image-scale-hover">
                            <a href="blog-detay.html"><img src="assets/img/blog/blog-5-2.jpg" alt="Blog Image" class="w-100"></a>
                        </div>
                        <div class="blog-content">
                            <div class="blog-avater">
                                <img src="assets/img/blog/blog-auth-1-1.jpg" alt="Blog author">
                            </div>
                            <a href="blog-detay.html" class="blog-date"><?=date("d M Y", strtotime("-1 day"))?></a>
                            <div class="blog-meta">
                                <a href="blog-detay.html">Özgıda Toposmanoğlu</a>
                                <a href="blog-detay.html">Devamını Oku</a>
                            </div>
                            <h3 class="blog-title"><a href="blog-detay.html">Geleneksel Türk Lezzetleri</a></h3>
                            <p class="blog-excerpt">Yüzyıllardır süregelen geleneksel Türk mutfağının eşsiz lezzetlerini modern yaşama taşıyoruz...</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="vs-blog blog-style2">
                        <div class="blog-img image-scale-hover">
                            <a href="blog-detay.html"><img src="assets/img/blog/blog-5-3.jpg" alt="Blog Image" class="w-100"></a>
                        </div>
                        <div class="blog-content">
                            <div class="blog-avater">
                                <img src="assets/img/blog/blog-auth-1-1.jpg" alt="Blog author">
                            </div>
                            <a href="blog-detay.html" class="blog-date"><?=date("d M Y", strtotime("-2 days"))?></a>
                            <div class="blog-meta">
                                <a href="blog-detay.html">Özgıda Toposmanoğlu</a>
                                <a href="blog-detay.html">Devamını Oku</a>
                            </div>
                            <h3 class="blog-title"><a href="blog-detay.html">Kaliteli Gıda Seçimi Nasıl Yapılır?</a></h3>
                            <p class="blog-excerpt">Günlük yaşamınızda kaliteli ve sağlıklı gıda ürünleri seçmenize yardımcı olacak pratik ipuçları...</p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="text-center pt-3 mt-1">
            <a href="<?=SITE?>blog" class="vs-btn style3">Tüm Haberleri Gör<i class="far fa-angle-right"></i></a>
        </div>
    </section>
 