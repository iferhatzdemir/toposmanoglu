<!-- ============================================
     ADMIN PANEL HEADER - Özgıda Toposmanoğlu
     Modern, Responsive, AdminLTE Based
     ============================================ -->

<style>
/* ========================================
   DESIGN SYSTEM - Color Variables
   ======================================== */
:root {
    /* Rose Theme - Primary Colors */
    --rose-50: #FFF1F2;
    --rose-100: #FFE4E6;
    --rose-200: #FECDD3;
    --rose-300: #FDA4AF;
    --rose-400: #FB7185;
    --rose-500: #F43F5E;
    --rose-600: #E11D48;
    --rose-700: #BE123C;
    --rose-800: #9F1239;
    --rose-900: #881337;

    /* Neutral Grays */
    --gray-50: #F9FAFB;
    --gray-100: #F3F4F6;
    --gray-200: #E5E7EB;
    --gray-300: #D1D5DB;
    --gray-400: #9CA3AF;
    --gray-500: #6B7280;
    --gray-600: #4B5563;
    --gray-700: #374151;
    --gray-800: #1F2937;
    --gray-900: #111827;

    /* Semantic Colors */
    --primary: var(--rose-600);
    --primary-hover: var(--rose-700);
    --primary-light: var(--rose-100);
    --danger: #DC2626;
    --success: #16A34A;
    --warning: #EA580C;
    --info: #0891B2;

    /* Background & Text */
    --bg-primary: #FFFFFF;
    --bg-secondary: var(--gray-50);
    --text-primary: var(--gray-900);
    --text-secondary: var(--gray-600);
    --text-muted: var(--gray-500);

    /* Borders & Shadows */
    --border-color: var(--gray-200);
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);

    /* Animation */
    --duration-150: 150ms;
    --duration-300: 300ms;
    --ease-out: cubic-bezier(0, 0, 0.2, 1);
    --ease-in-out: cubic-bezier(0.4, 0, 0.2, 1);

    /* Spacing */
    --spacing-xs: 0.25rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;

    /* Border Radius */
    --radius-sm: 0.25rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-full: 9999px;
}

/* ========================================
   HEADER ENHANCEMENT
   ======================================== */

/* Main Header Styling */
.main-header {
    background: linear-gradient(135deg, var(--bg-primary) 0%, var(--gray-50) 100%) !important;
    border-bottom: 1px solid var(--border-color) !important;
    box-shadow: var(--shadow-md) !important;
    transition: all var(--duration-300) var(--ease-out);
    position: sticky;
    top: 0;
    z-index: 1030;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

/* Remove default navbar classes conflict */
.main-header.navbar-white {
    background: transparent !important;
}

/* Left Navigation Items */
.main-header .navbar-nav .nav-item .nav-link {
    color: var(--text-primary) !important;
    transition: all var(--duration-150) var(--ease-out);
    border-radius: var(--radius-md);
    padding: var(--spacing-sm) var(--spacing-md);
    font-weight: 500;
    position: relative;
    overflow: hidden;
}

.main-header .navbar-nav .nav-item .nav-link:hover {
    background: var(--primary-light) !important;
    color: var(--primary) !important;
    transform: translateY(-1px);
}

.main-header .navbar-nav .nav-item .nav-link:active {
    transform: translateY(0);
}

/* Menu Toggle Button */
.main-header .nav-link[data-widget="pushmenu"] {
    position: relative;
}

.main-header .nav-link[data-widget="pushmenu"]:hover {
    background: var(--primary-light) !important;
}

.main-header .nav-link[data-widget="pushmenu"] i {
    transition: transform var(--duration-300) var(--ease-in-out);
}

.main-header .nav-link[data-widget="pushmenu"]:hover i {
    transform: rotate(90deg);
}

/* ========================================
   MESSAGES DROPDOWN ENHANCEMENT
   ======================================== */

/* Messages Icon Container */
.main-header .nav-item.dropdown .nav-link {
    position: relative;
    padding: var(--spacing-sm) var(--spacing-md);
    border-radius: var(--radius-full);
    transition: all var(--duration-300) var(--ease-out);
}

.main-header .nav-item.dropdown .nav-link:hover {
    background: var(--primary-light);
    transform: scale(1.05);
}

.main-header .nav-item.dropdown .nav-link i {
    font-size: 1.25rem;
    color: var(--text-primary);
    transition: color var(--duration-150) var(--ease-out);
}

.main-header .nav-item.dropdown .nav-link:hover i {
    color: var(--primary);
    animation: messageRing 0.5s ease-in-out;
}

/* Badge Styling */
.main-header .navbar-badge {
    position: absolute;
    top: 2px;
    right: 2px;
    padding: 0.25em 0.5em;
    font-size: 0.625rem;
    font-weight: 700;
    line-height: 1;
    background: linear-gradient(135deg, var(--danger), #B91C1C);
    border: 2px solid var(--bg-primary);
    border-radius: var(--radius-full);
    animation: badgePulse 2s ease-in-out infinite;
    box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
}

/* Dropdown Menu Enhancement */
.main-header .dropdown-menu {
    border: none;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    margin-top: var(--spacing-sm);
    animation: dropdownSlideIn var(--duration-300) var(--ease-out);
    max-height: 400px;
    overflow-y: auto;
    overflow-x: hidden;
}

/* Message Item Styling */
.main-header .dropdown-item {
    padding: var(--spacing-md);
    transition: all var(--duration-150) var(--ease-out);
    border-left: 3px solid transparent;
}

.main-header .dropdown-item:hover {
    background: var(--gray-50);
    border-left-color: var(--primary);
    transform: translateX(4px);
}

.main-header .dropdown-item:active {
    background: var(--primary-light);
}

/* Media Object in Dropdown */
.main-header .media {
    display: flex;
    align-items: flex-start;
}

.main-header .media .img-circle {
    border: 2px solid var(--primary-light);
    transition: all var(--duration-300) var(--ease-out);
    box-shadow: var(--shadow-sm);
}

.main-header .dropdown-item:hover .img-circle {
    border-color: var(--primary);
    transform: scale(1.05);
    box-shadow: var(--shadow-md);
}

.main-header .media-body {
    flex: 1;
    min-width: 0;
}

.main-header .dropdown-item-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: var(--spacing-xs);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.main-header .dropdown-item-title .fa-star {
    color: var(--warning);
    animation: starTwinkle 1.5s ease-in-out infinite;
}

.main-header .media-body p {
    margin-bottom: var(--spacing-xs);
    color: var(--text-secondary);
    line-height: 1.4;
}

.main-header .text-muted {
    color: var(--text-muted) !important;
    font-size: 0.75rem;
}

/* Dropdown Divider */
.main-header .dropdown-divider {
    margin: 0;
    border-color: var(--border-color);
}

/* Dropdown Footer */
.main-header .dropdown-footer {
    background: var(--gray-50);
    color: var(--primary);
    font-weight: 600;
    text-align: center;
    padding: var(--spacing-md);
    border-top: 1px solid var(--border-color);
    transition: all var(--duration-150) var(--ease-out);
}

.main-header .dropdown-footer:hover {
    background: var(--primary);
    color: var(--bg-primary);
    transform: none;
    border-left-color: transparent;
}

/* ========================================
   LOGOUT BUTTON ENHANCEMENT
   ======================================== */

.main-header .nav-item .nav-link[href*="cikis"] {
    background: linear-gradient(135deg, var(--danger), #B91C1C);
    color: var(--bg-primary) !important;
    border-radius: var(--radius-full);
    padding: var(--spacing-sm) var(--spacing-md);
    margin-left: var(--spacing-sm);
    transition: all var(--duration-300) var(--ease-out);
    box-shadow: var(--shadow-sm);
}

.main-header .nav-item .nav-link[href*="cikis"]:hover {
    background: linear-gradient(135deg, #B91C1C, #991B1B);
    transform: translateY(-2px) scale(1.05);
    box-shadow: var(--shadow-md);
}

.main-header .nav-item .nav-link[href*="cikis"]:active {
    transform: translateY(0) scale(1);
}

.main-header .nav-item .nav-link[href*="cikis"] i {
    color: var(--bg-primary) !important;
    font-size: 1.1rem;
}

/* ========================================
   ANIMATIONS & KEYFRAMES
   ======================================== */

/* Message Icon Ring Animation */
@keyframes messageRing {
    0%, 100% { transform: rotate(0deg); }
    10%, 30% { transform: rotate(-10deg); }
    20%, 40% { transform: rotate(10deg); }
    50% { transform: rotate(-5deg); }
    60% { transform: rotate(5deg); }
    70% { transform: rotate(0deg); }
}

/* Badge Pulse Animation */
@keyframes badgePulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.9;
    }
}

/* Dropdown Slide In */
@keyframes dropdownSlideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Star Twinkle */
@keyframes starTwinkle {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.6;
        transform: scale(0.9);
    }
}

/* ========================================
   RESPONSIVE DESIGN
   ======================================== */

@media (max-width: 576px) {
    /* Hide text on small screens */
    .main-header .nav-item.d-none.d-sm-inline-block {
        display: none !important;
    }

    /* Adjust dropdown width */
    .main-header .dropdown-menu-lg {
        min-width: 280px;
        max-width: calc(100vw - 2rem);
    }

    /* Smaller spacing */
    .main-header .dropdown-item {
        padding: var(--spacing-sm);
    }

    .main-header .media .img-size-50 {
        width: 40px !important;
        height: 40px !important;
    }
}

@media (max-width: 768px) {
    .main-header {
        padding: var(--spacing-xs) var(--spacing-sm);
    }

    .main-header .navbar-nav .nav-link {
        padding: var(--spacing-xs) var(--spacing-sm);
    }
}

/* ========================================
   SCROLLBAR STYLING (for dropdown)
   ======================================== */

.main-header .dropdown-menu::-webkit-scrollbar {
    width: 6px;
}

.main-header .dropdown-menu::-webkit-scrollbar-track {
    background: var(--gray-100);
}

.main-header .dropdown-menu::-webkit-scrollbar-thumb {
    background: var(--gray-300);
    border-radius: var(--radius-full);
}

.main-header .dropdown-menu::-webkit-scrollbar-thumb:hover {
    background: var(--gray-400);
}

/* ========================================
   ACCESSIBILITY ENHANCEMENTS
   ======================================== */

.main-header .nav-link:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
</style>

<!-- ============================================
     MAIN NAVIGATION BAR
     ============================================ -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- ==================== LEFT NAVBAR LINKS ==================== -->
    <ul class="navbar-nav">

        <!-- Sidebar Toggle Button -->
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Menüyü Aç/Kapat">
                <i class="fas fa-bars"></i>
            </a>
        </li>

        <!-- Homepage Link (Hidden on small screens) -->
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=SITE?>" class="nav-link" aria-label="Ana Sayfaya Git">
                <i class="fas fa-home mr-1"></i>
                Anasayfa
            </a>
        </li>

    </ul>

    <!-- ==================== RIGHT NAVBAR LINKS ==================== -->
    <ul class="navbar-nav ml-auto">

        <!-- ==================== MESSAGES DROPDOWN ==================== -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Mesajlar">
                <i class="far fa-comments"></i>
                <?php
                // Get unread messages count
                $yenimesajlar = $VT->VeriGetir("mesajlar", "WHERE durum=?", array(1), "ORDER BY ID DESC");
                if($yenimesajlar !== false && count($yenimesajlar) > 0) {
                ?>
                    <span class="badge badge-danger navbar-badge" aria-label="<?=count($yenimesajlar)?> yeni mesaj">
                        <?=count($yenimesajlar)?>
                    </span>
                <?php
                }
                ?>
            </a>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <?php
                // Get last 3 messages
                $mesajlar = $VT->VeriGetir("mesajlar", "", "", "ORDER BY ID DESC", 3);

                if($mesajlar !== false && count($mesajlar) > 0) {
                    foreach($mesajlar as $mesaj) {
                        // Format message preview
                        $adsoyad = stripslashes($mesaj["adsoyad"]);
                        $metinPreview = mb_substr(stripslashes(strip_tags($mesaj["metin"])), 0, 35, "UTF-8") . "...";
                        $tarih = date("d.m.Y H:i", strtotime($mesaj["tarih"]));
                        $mesajUrl = SITE . "mesaj-detay/" . $mesaj["ID"];
                ?>
                    <a href="<?=$mesajUrl?>" class="dropdown-item">
                        <!-- Message Item -->
                        <div class="media">
                            <img src="<?=SITE?>dist/img/user1-128x128.jpg"
                                 alt="<?=$adsoyad?>"
                                 class="img-size-50 mr-3 img-circle"
                                 loading="lazy">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    <?=$adsoyad?>
                                    <?php if($mesaj["durum"] == 1) { ?>
                                        <span class="float-right text-sm text-danger">
                                            <i class="fas fa-star" aria-label="Yeni"></i>
                                        </span>
                                    <?php } ?>
                                </h3>
                                <p class="text-sm"><?=$metinPreview?></p>
                                <p class="text-sm text-muted">
                                    <i class="far fa-clock mr-1"></i>
                                    <?=$tarih?>
                                </p>
                            </div>
                        </div>
                        <!-- End Message Item -->
                    </a>
                    <div class="dropdown-divider"></div>
                <?php
                    }
                } else {
                ?>
                    <!-- No Messages -->
                    <div class="dropdown-item text-center text-muted py-4">
                        <i class="far fa-envelope mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mb-0">Henüz mesaj bulunmamaktadır</p>
                    </div>
                    <div class="dropdown-divider"></div>
                <?php
                }
                ?>

                <!-- View All Messages Link -->
                <a href="<?=SITE?>mesajlar" class="dropdown-item dropdown-footer">
                    <i class="fas fa-envelope-open-text mr-2"></i>
                    Tüm Mesajları Görüntüle
                </a>
            </div>
        </li>

        <!-- ==================== LOGOUT BUTTON ==================== -->
        <li class="nav-item">
            <a class="nav-link" href="<?=SITE?>cikis" role="button" aria-label="Çıkış Yap" title="Çıkış Yap">
                <i class="fa fa-sign-out-alt"></i>
            </a>
        </li>

    </ul>
</nav>

