<!--
═══════════════════════════════════════════════════════════
  ÖZGIDA TOPOSMANOĞLU - E-COMMERCE HEADER V3.0
  Professional, Clean, E-commerce Standard - Dusty Rose Theme

  Fixes:
  - ✅ Desktop: Logo | Menu | Search | Icons (horizontal)
  - ✅ Mobile: Hamburger | Logo | Icons (3 sections)
  - ✅ Sticky category bar removed (too much)
  - ✅ Clean spacing, no cluttered buttons
  - ✅ Modern e-commerce layout (Trendyol/Hepsiburada style)
═══════════════════════════════════════════════════════════
-->

<style>
/* ═══════════════════════════════════════════════════════════
   DESIGN SYSTEM - Clean E-commerce Variables
════════════════════════════════════════════════════════════ */

:root {
    /* 🌹 DUSTY ROSE - Ana Renk Paleti */
    --rose-900: #8B5A5F;
    --rose-800: #A16A6F;
    --rose-700: #B87A7F;
    --rose-600: #C98A8F;
    --rose-500: #D99A9F;
    --rose-400: #E3AEAF;
    --rose-300: #ECC2C3;
    --rose-200: #F5D6D7;
    --rose-100: #FAE8E9;
    --rose-50: #FDF6F6;

    /* 🍃 SAGE GREEN - İkincil Renk Paleti */
    --green-900: #4A5D42;
    --green-800: #5C7054;
    --green-700: #6E8366;
    --green-600: #809678;
    --green-500: #92A98A;
    --green-400: #A4BC9C;
    --green-300: #B9CCAF;
    --green-200: #CEDCC3;
    --green-100: #E3EDD7;
    --green-50: #F1F7EB;

    /* 🎨 TERRACOTTA - Accent */
    --terracotta-600: #C07B6B;
    --terracotta-400: #D9A394;
    --terracotta-200: #F0DED8;

    /* 🟤 WARM NEUTRALS */
    --warm-gray-900: #3D3835;
    --warm-gray-700: #6B6460;
    --warm-gray-500: #948F8C;
    --warm-gray-300: #D1CDCB;
    --warm-gray-100: #F0EFEE;
    --cream: #FAF8F6;

    /* Neutrals */
    --white: #ffffff;
    --black: #1a1a1a;
    --gray-900: #2d2d2d;
    --gray-700: #4a4a4a;
    --gray-500: #737373;
    --gray-300: #d4d4d4;
    --gray-200: #e5e5e5;
    --gray-100: #f5f5f5;
    --gray-50: #fafafa;

    /* Spacing (8px base) */
    --space-1: 0.5rem;
    /* 8px */
    --space-2: 1rem;
    /* 16px */
    --space-3: 1.5rem;
    /* 24px */
    --space-4: 2rem;
    /* 32px */

    /* Transitions */
    --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
    --transition-base: 200ms cubic-bezier(0.4, 0, 0.2, 1);

    /* Shadows */
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
    --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);

    /* Z-index scale */
    --z-sticky: 100;
    --z-dropdown: 200;
    --z-overlay: 300;
    --z-mobile-menu: 400;
}

/* ═══════════════════════════════════════════════════════════
   BASE RESET
════════════════════════════════════════════════════════════ */

.ecom-header * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* Skip Link */
.skip-to-content {
    position: absolute;
    top: -100px;
    left: var(--space-2);
    background: var(--black);
    color: var(--white);
    padding: var(--space-1) var(--space-2);
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 600;
    z-index: 9999;
    transition: top var(--transition-base);
}

.skip-to-content:focus {
    top: var(--space-1);
}

/* ═══════════════════════════════════════════════════════════
   TOP ANNOUNCEMENT BAR (Optional Promo)
════════════════════════════════════════════════════════════ */

.ecom-topbar {
    background: linear-gradient(90deg, var(--green-100), var(--green-50));
    border-bottom: 1px solid var(--green-300);
    font-size: 13px;
    color: var(--gray-900);
    padding: var(--space-1) 0;
    text-align: center;
}

.ecom-topbar__text {
    font-weight: 500;
}

/* ═══════════════════════════════════════════════════════════
   MAIN HEADER (Desktop/Mobile Responsive)
════════════════════════════════════════════════════════════ */

.ecom-header {
    background: var(--white);
    border-bottom: 1px solid var(--gray-200);
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: var(--shadow-sm);
}

.ecom-header__container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 var(--space-2);
}

.ecom-header__inner {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    height: 80px;
    gap: var(--space-3);
}

/* ═══════════════════════════════════════════════════════════
   LEFT SECTION: Hamburger (mobile) + Navigation
════════════════════════════════════════════════════════════ */

.ecom-header__left {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    justify-content: flex-start;
}

/* Hamburger (Mobile Only) */
.ecom-hamburger {
    display: none;
    width: 40px;
    height: 40px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    position: relative;
    z-index: 10;
    flex-shrink: 0;
}

.ecom-hamburger__line {
    display: block;
    width: 24px;
    height: 2px;
    background: var(--gray-900);
    position: absolute;
    left: 8px;
    transition: all var(--transition-base);
}

.ecom-hamburger__line:nth-child(1) {
    top: 12px;
}

.ecom-hamburger__line:nth-child(2) {
    top: 19px;
}

.ecom-hamburger__line:nth-child(3) {
    top: 26px;
}

.ecom-hamburger[aria-expanded="true"] .ecom-hamburger__line:nth-child(1) {
    top: 19px;
    transform: rotate(45deg);
}

.ecom-hamburger[aria-expanded="true"] .ecom-hamburger__line:nth-child(2) {
    opacity: 0;
}

.ecom-hamburger[aria-expanded="true"] .ecom-hamburger__line:nth-child(3) {
    top: 19px;
    transform: rotate(-45deg);
}

/* ═══════════════════════════════════════════════════════════
   CENTER SECTION: Logo (Centered)
════════════════════════════════════════════════════════════ */

.ecom-logo {
    flex-shrink: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.ecom-logo__link {
    display: block;
    line-height: 0;
}

.ecom-logo__img {
    height: 50px !important;
    width: auto !important;
    max-width: none !important;
    max-height: none !important;
}

/* ═══════════════════════════════════════════════════════════
   NAVIGATION: Desktop Navigation (Hidden in grid, shown separately)
════════════════════════════════════════════════════════════ */

.ecom-nav {
    display: none;
    /* Will be shown separately below header */
}

.ecom-nav__list {
    display: flex;
    align-items: center;
    gap: var(--space-1);
    list-style: none;
}

.ecom-nav__item {
    position: relative;
}

.ecom-nav__link,
.ecom-nav__button {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: var(--space-1) var(--space-2);
    color: var(--gray-900);
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    background: none;
    border: none;
    cursor: pointer;
    border-radius: 6px;
    transition: all var(--transition-fast);
    white-space: nowrap;
}

.ecom-nav__link:hover,
.ecom-nav__button:hover {
    color: var(--green-600);
    background: var(--green-50);
}

.ecom-nav__link--active {
    color: var(--green-600);
    font-weight: 600;
}

/* Dropdown Icon */
.ecom-nav__icon {
    width: 14px;
    height: 14px;
    transition: transform var(--transition-fast);
}

.ecom-nav__button[aria-expanded="true"] .ecom-nav__icon {
    transform: rotate(180deg);
}

/* Dropdown Menu */
.ecom-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: 8px;
    box-shadow: var(--shadow-lg);
    min-width: 200px;
    padding: var(--space-1);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: all var(--transition-base);
    z-index: var(--z-dropdown);
}

.ecom-dropdown[aria-hidden="false"] {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.ecom-dropdown__list {
    list-style: none;
}

.ecom-dropdown__item {
    margin: 0;
}

.ecom-dropdown__link {
    display: block;
    padding: var(--space-1) var(--space-2);
    color: var(--gray-700);
    text-decoration: none;
    font-size: 14px;
    border-radius: 4px;
    transition: all var(--transition-fast);
}

.ecom-dropdown__link:hover {
    background: var(--green-50);
    color: var(--green-600);
}

/* ═══════════════════════════════════════════════════════════
   RIGHT SECTION: Search + Icons
════════════════════════════════════════════════════════════ */

.ecom-header__right {
    display: flex;
    align-items: center;
    gap: var(--space-1);
}

/* Search (Desktop) */
.ecom-search {
    position: relative;
    width: 280px;
}

.ecom-search__input {
    width: 100%;
    height: 40px;
    padding: 0 40px 0 var(--space-2);
    border: 1px solid var(--gray-300);
    border-radius: 20px;
    font-size: 14px;
    outline: none;
    transition: all var(--transition-fast);
}

.ecom-search__input:focus {
    border-color: var(--green-600);
    box-shadow: 0 0 0 3px rgba(139, 157, 131, 0.1);
}

.ecom-search__button {
    position: absolute;
    right: 0;
    top: 0;
    width: 40px;
    height: 40px;
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-500);
    transition: color var(--transition-fast);
}

.ecom-search__button:hover {
    color: var(--green-600);
}

.ecom-search__icon {
    width: 20px;
    height: 20px;
}

/* Icons (Wishlist, Cart, Account) */
.ecom-icons {
    display: flex;
    align-items: center;
    gap: 4px;
}

.ecom-icon-btn {
    position: relative;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    cursor: pointer;
    border-radius: 8px;
    color: var(--gray-700);
    transition: all var(--transition-fast);
    text-decoration: none;
}

.ecom-icon-btn:hover {
    background: var(--green-50);
    color: var(--green-600);
}

.ecom-icon-btn svg {
    width: 22px;
    height: 22px;
}

/* Cart Badge */
.ecom-badge {
    position: absolute;
    top: 4px;
    right: 4px;
    min-width: 18px;
    height: 18px;
    background: var(--rose-600);
    color: var(--white);
    border-radius: 9px;
    font-size: 11px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
    line-height: 1;
}

/* Account Dropdown */
.ecom-account-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: 8px;
    box-shadow: var(--shadow-lg);
    min-width: 240px;
    padding: var(--space-2);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: all var(--transition-base);
    z-index: var(--z-dropdown);
}

.ecom-account-dropdown[aria-hidden="false"] {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.ecom-account-dropdown__header {
    padding-bottom: var(--space-2);
    border-bottom: 1px solid var(--gray-200);
    margin-bottom: var(--space-2);
}

.ecom-account-dropdown__welcome {
    font-size: 14px;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: var(--space-1);
}

.ecom-account-dropdown__list {
    list-style: none;
}

.ecom-account-dropdown__item {
    margin-bottom: 4px;
}

.ecom-account-dropdown__link {
    display: flex;
    align-items: center;
    gap: var(--space-1);
    padding: var(--space-1) var(--space-2);
    color: var(--gray-700);
    text-decoration: none;
    font-size: 14px;
    border-radius: 6px;
    transition: all var(--transition-fast);
}

.ecom-account-dropdown__link:hover {
    background: var(--green-50);
    color: var(--green-600);
}

.ecom-account-dropdown__link svg {
    width: 16px;
    height: 16px;
}

.ecom-btn-primary {
    display: block;
    width: 100%;
    padding: var(--space-1) var(--space-2);
    background: linear-gradient(135deg, var(--rose-600) 0%, var(--rose-500) 100%);
    color: var(--white);
    text-align: center;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    border-radius: 8px;
    transition: all var(--transition-fast);
    box-shadow: 0 2px 6px rgba(201, 138, 143, 0.25);
}

.ecom-btn-primary:hover {
    background: linear-gradient(135deg, var(--rose-700) 0%, var(--rose-600) 100%);
    box-shadow: 0 4px 12px rgba(201, 138, 143, 0.35);
    color: var(--white);
    transform: translateY(-1px);
}

/* ═══════════════════════════════════════════════════════════
   CATEGORY BAR (Below Header - Optional)
════════════════════════════════════════════════════════════ */

.ecom-categorybar {
    background: var(--white);
    border-bottom: 1px solid var(--gray-200);
    padding: var(--space-1) 0;
    position: relative;
    z-index: 99;
}

.ecom-categorybar__container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 var(--space-2);
}

.ecom-categorybar__inner {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

/* Category Dropdown Button */
.ecom-category-btn {
    display: flex;
    align-items: center;
    gap: var(--space-1);
    padding: var(--space-1) var(--space-2);
    background: linear-gradient(135deg, var(--green-600) 0%, var(--green-500) 100%);
    color: var(--white);
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition-fast);
    white-space: nowrap;
    box-shadow: 0 2px 6px rgba(128, 150, 120, 0.25);
}

.ecom-category-btn:hover {
    background: linear-gradient(135deg, var(--green-700) 0%, var(--green-600) 100%);
    box-shadow: 0 4px 12px rgba(128, 150, 120, 0.35);
    transform: translateY(-1px);
}

.ecom-category-btn svg {
    width: 18px;
    height: 18px;
}

/* Category Mega Menu */
.ecom-category-menu {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: 8px;
    box-shadow: var(--shadow-lg);
    width: 280px;
    max-height: 500px;
    overflow-y: auto;
    padding: var(--space-2);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: all var(--transition-base);
    z-index: var(--z-dropdown);
}

.ecom-category-menu[aria-hidden="false"] {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.ecom-category-menu__list {
    list-style: none;
}

.ecom-category-menu__item {
    margin-bottom: var(--space-1);
}

.ecom-category-menu__link {
    display: block;
    padding: var(--space-1) var(--space-2);
    color: var(--gray-900);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    border-radius: 6px;
    background: var(--gray-50);
    transition: all var(--transition-fast);
}

.ecom-category-menu__link:hover {
    background: var(--green-50);
    color: var(--green-600);
}

/* Subcategories */
.ecom-category-menu__sublist {
    list-style: none;
    margin-top: var(--space-1);
    padding-left: var(--space-2);
}

.ecom-category-menu__subitem {
    margin-bottom: 4px;
}

.ecom-category-menu__sublink {
    display: block;
    padding: 6px var(--space-2);
    color: var(--gray-600);
    text-decoration: none;
    font-size: 13px;
    border-radius: 4px;
    transition: all var(--transition-fast);
}

.ecom-category-menu__sublink:hover {
    background: var(--green-50);
    color: var(--green-600);
    padding-left: calc(var(--space-2) + 4px);
}

/* ═══════════════════════════════════════════════════════════
   MOBILE NAVIGATION (Slide-in Drawer)
════════════════════════════════════════════════════════════ */

.ecom-mobile-nav {
    position: fixed;
    top: 0;
    left: -100%;
    width: 300px;
    height: 100vh;
    background: var(--white);
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
    overflow-y: auto;
    transition: left 300ms ease-in-out;
    z-index: 9999 !important;
    padding: var(--space-3);
    display: block !important;
    visibility: visible !important;
}

.ecom-mobile-nav[aria-hidden="false"] {
    left: 0 !important;
    transform: translateX(0) !important;
}

.ecom-mobile-nav[aria-hidden="true"] {
    left: -100% !important;
    transform: translateX(0) !important;
}

/* Mobile Nav Header */
.ecom-mobile-nav__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: var(--space-3);
    padding-bottom: var(--space-2);
    border-bottom: 1px solid var(--gray-200);
}

.ecom-mobile-nav__title {
    font-size: 18px;
    font-weight: 600;
    color: var(--gray-900);
}

.ecom-mobile-nav__close {
    width: 32px;
    height: 32px;
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-700);
}

.ecom-mobile-nav__close svg {
    width: 24px;
    height: 24px;
}

/* Mobile Nav List */
.ecom-mobile-nav__list {
    list-style: none;
}

.ecom-mobile-nav__item {
    margin-bottom: var(--space-1);
}

.ecom-mobile-nav__link,
.ecom-mobile-nav__button {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: var(--space-2);
    color: var(--gray-900);
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    background: none;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.ecom-mobile-nav__link:hover,
.ecom-mobile-nav__button:hover {
    background: var(--green-50);
    color: var(--green-600);
}

.ecom-mobile-nav__button svg {
    width: 16px;
    height: 16px;
    transition: transform var(--transition-fast);
}

.ecom-mobile-nav__button[aria-expanded="true"] svg {
    transform: rotate(180deg);
}

/* Mobile Submenu */
.ecom-mobile-submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height var(--transition-base);
    padding-left: var(--space-2);
}

.ecom-mobile-submenu[aria-hidden="false"] {
    max-height: 500px;
}

.ecom-mobile-submenu__list {
    list-style: none;
    padding-top: var(--space-1);
}

.ecom-mobile-submenu__item {
    margin-bottom: 4px;
}

.ecom-mobile-submenu__link {
    display: block;
    padding: var(--space-1) var(--space-2);
    color: var(--gray-600);
    text-decoration: none;
    font-size: 14px;
    border-radius: 4px;
    transition: all var(--transition-fast);
}

.ecom-mobile-submenu__link:hover {
    background: var(--green-50);
    color: var(--green-600);
}

/* Mobile Search */
.ecom-mobile-search {
    margin-top: var(--space-3);
    padding-top: var(--space-3);
    border-top: 1px solid var(--gray-200);
}

.ecom-mobile-search__form {
    position: relative;
}

.ecom-mobile-search__input {
    width: 100%;
    height: 44px;
    padding: 0 44px 0 var(--space-2);
    border: 1px solid var(--gray-300);
    border-radius: 22px;
    font-size: 14px;
    outline: none;
}

.ecom-mobile-search__button {
    position: absolute;
    right: 0;
    top: 0;
    width: 44px;
    height: 44px;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--gray-500);
}

/* Overlay */
.ecom-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    visibility: hidden;
    transition: opacity 300ms ease-in-out, visibility 300ms ease-in-out;
    z-index: 9998 !important;
    backdrop-filter: blur(2px);
    display: block !important;
}

.ecom-overlay[aria-hidden="false"] {
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: auto !important;
}

.ecom-overlay[aria-hidden="true"] {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

/* ═══════════════════════════════════════════════════════════
   MOBILE RESPONSIVE
════════════════════════════════════════════════════════════ */

@media (max-width: 991px) {

    /* Hide hamburger - zaten bottom nav'da var */
    .ecom-hamburger {
        display: none !important;
    }

    /* Hide desktop nav */
    .ecom-nav {
        display: none !important;
    }

    /* Hide desktop search */
    .ecom-search {
        display: none !important;
    }

    /* Hide right section (icons) - zaten bottom nav'da var */
    .ecom-header__right {
        display: none !important;
    }

    /* Adjust header height */
    .ecom-header__inner {
        height: 70px;
        display: flex !important;
        justify-content: center !important;
        grid-template-columns: 1fr !important;
    }

    /* Logo ortada - tek başına */
    .ecom-header__left {
        justify-content: center;
        width: 100%;
    }

    .ecom-logo {
        width: 100%;
        text-align: center;
    }

    .ecom-logo__img {
        height: 42px !important;
        max-width: none !important;
        max-height: none !important;
    }

    /* Hide category bar on mobile */
    .ecom-categorybar {
        display: none !important;
    }
}

@media (max-width: 480px) {
    .ecom-header__container {
        padding: 0 var(--space-1);
    }

    .ecom-mobile-nav {
        width: 100%;
        left: -100%;
    }

    .ecom-topbar {
        font-size: 11px;
    }
}

/* ═══════════════════════════════════════════════════════════
   ACCESSIBILITY
════════════════════════════════════════════════════════════ */

*:focus-visible {
    outline: 2px solid var(--green-600);
    outline-offset: 2px;
}

@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
    }
}

/* ═══════════════════════════════════════════════════════════
   UTILITY
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
   SLIDER / MAIN CONTENT FIX - Logo overlap çözümü
════════════════════════════════════════════════════════════ */

/* Ana içerik alanı navbar altında başlasın */
#main-content,
.slider-area,
.hero-slider,
.main-wrapper,
.ozgida-hero-slider {
    position: relative;
    z-index: 1;
    margin-top: 0 !important;
    padding-top: 0 !important;
}

/* Body overflow kontrolü */
body {
    position: relative;
    overflow-x: hidden;
}

/* Slider navbar altında kalmalı */
.ozgida-hero-slider {
    z-index: 1 !important;
    position: relative !important;
}

/* Navbar üstte sabit kalmalı */
.ecom-header {
    position: sticky !important;
    top: 0 !important;
    z-index: 1000 !important;
}

/* Eğer slider absolute positioning kullanıyorsa */
.slider-area .slider-item,
.hero-slider .slide,
.ozgida-slide {
    padding-top: 0 !important;
    margin-top: 0 !important;
}
</style>

<!-- ═══════════════════════════════════════════════════════════
     HTML STRUCTURE
════════════════════════════════════════════════════════════ -->

<?php
// XSS Protection
function safe($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Current URI
$current_uri = $_SERVER['REQUEST_URI'] ?? '/';

// Cart count
$cart_count = !empty($_SESSION["sepet"]) ? count($_SESSION["sepet"]) : 0;

// User
$user_logged_in = !empty($_SESSION["uyeID"]);
$user_name = $_SESSION["uyeAdi"] ?? '';
?>

<!-- Skip Link -->
<a href="#main-content" class="skip-to-content">İçeriğe atla</a>

<!-- Top Announcement Bar -->
<div class="ecom-topbar">
    <div class="ecom-topbar__text">
        ✨ 3000₺ üzeri kargo BEDAVA • 30 gün iade garantisi
    </div>
</div>

<!-- Main Header -->
<header class="ecom-header" role="banner">
    <div class="ecom-header__container">
        <div class="ecom-header__inner">

            <!-- LEFT: Hamburger + Logo -->
            <div class="ecom-header__left">
                <button class="ecom-hamburger" aria-label="Menüyü aç" aria-expanded="false" aria-controls="mobile-nav"
                    id="hamburger-btn">
                    <span class="ecom-hamburger__line"></span>
                    <span class="ecom-hamburger__line"></span>
                    <span class="ecom-hamburger__line"></span>
                </button>

                <div class="ecom-logo">
                    <a href="<?= safe(SITE) ?>" class="ecom-logo__link" aria-label="Ana sayfa">
                        <img src="<?= safe(SITE) ?>assets/img/logo.png" alt="Toposmanoğlu" class="ecom-logo__img"
                            width="120" height="45">
                    </a>
                </div>
            </div>

            <!-- CENTER: Desktop Navigation -->
            <nav class="ecom-nav" aria-label="Ana menü">
                <ul class="ecom-nav__list">
                    <li class="ecom-nav__item">
                        <a href="<?= safe(SITE) ?>"
                            class="ecom-nav__link <?= $current_uri === '/' ? 'ecom-nav__link--active' : '' ?>">
                            Anasayfa
                        </a>
                    </li>

                    <!-- Kurumsal Dropdown -->
                    <li class="ecom-nav__item">
                        <button class="ecom-nav__button" aria-expanded="false" aria-controls="kurumsal-dropdown"
                            id="kurumsal-btn">
                            Kurumsal
                            <svg class="ecom-nav__icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="ecom-dropdown" id="kurumsal-dropdown" aria-hidden="true">
                            <ul class="ecom-dropdown__list">
                                <?php
                                $kurumsal = $VT->VeriGetir("kurumsal", "WHERE durum=?", array(1), "ORDER BY sirano ASC");
                                if ($kurumsal !== false) {
                                    foreach ($kurumsal as $item) {
                                        echo '<li class="ecom-dropdown__item">';
                                        echo '<a href="' . safe(SITE) . 'kurumsal/' . safe($item["seflink"]) . '" class="ecom-dropdown__link">';
                                        echo safe(stripslashes($item["baslik"]));
                                        echo '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </li>

                    <!-- Gizlilik Dropdown -->
                    <li class="ecom-nav__item">
                        <button class="ecom-nav__button" aria-expanded="false" aria-controls="gizlilik-dropdown"
                            id="gizlilik-btn">
                            Gizlilik
                            <svg class="ecom-nav__icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="ecom-dropdown" id="gizlilik-dropdown" aria-hidden="true">
                            <ul class="ecom-dropdown__list">
                                <?php
                                $gizlilik = $VT->VeriGetir("gizlilikpolitikasi", "WHERE durum=?", array(1), "ORDER BY sirano ASC");
                                if ($gizlilik !== false) {
                                    foreach ($gizlilik as $item) {
                                        echo '<li class="ecom-dropdown__item">';
                                        echo '<a href="' . safe(SITE) . 'gizlilik-politikasi/' . safe($item["seflink"]) . '" class="ecom-dropdown__link">';
                                        echo safe(stripslashes($item["baslik"]));
                                        echo '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </li>

                    <li class="ecom-nav__item">
                        <a href="<?= safe(SITE) ?>blog" class="ecom-nav__link">Blog</a>
                    </li>

                    <li class="ecom-nav__item">
                        <a href="<?= safe(SITE) ?>iletisim" class="ecom-nav__link">İletişim</a>
                    </li>
                </ul>
            </nav>

            <!-- RIGHT: Search + Icons -->
            <div class="ecom-header__right">

                <!-- Desktop Search -->
                <div class="ecom-search">
                    <form action="<?= safe(SITE) ?>arama" method="GET">
                        <input type="text" name="search" class="ecom-search__input"
                            placeholder="Ürün, kategori veya marka ara..." aria-label="Arama">
                        <button type="submit" class="ecom-search__button" aria-label="Ara">
                            <svg class="ecom-search__icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Icons -->
                <div class="ecom-icons">
                    <!-- Wishlist -->
                    <a href="<?= safe(SITE) ?>favorilerim" class="ecom-icon-btn" aria-label="Favorilerim">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>

                    <!-- Cart -->
                    <a href="<?= safe(SITE) ?>sepet" class="ecom-icon-btn" aria-label="Sepet (<?= $cart_count ?> ürün)">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                        <?php if ($cart_count > 0): ?>
                        <span class="ecom-badge"><?= $cart_count ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- Account -->
                    <button class="ecom-icon-btn" aria-label="Hesabım" aria-expanded="false"
                        aria-controls="account-dropdown" id="account-btn">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Account Dropdown -->
                    <div class="ecom-account-dropdown" id="account-dropdown" aria-hidden="true">
                        <?php if ($user_logged_in): ?>
                        <div class="ecom-account-dropdown__header">
                            <div class="ecom-account-dropdown__welcome">
                                Hoşgeldiniz, <?= safe($user_name) ?>
                            </div>
                        </div>
                        <?php else: ?>
                        <a href="<?= safe(SITE) ?>uyelik" class="ecom-btn-primary">Giriş Yap / Üye Ol</a>
                        <div style="height: 12px;"></div>
                        <?php endif; ?>

                        <ul class="ecom-account-dropdown__list">
                            <li class="ecom-account-dropdown__item">
                                <a href="<?= safe(SITE) ?>siparis-takip" class="ecom-account-dropdown__link">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                        <path
                                            d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                    </svg>
                                    Sipariş Takibi
                                </a>
                            </li>

                            <?php if ($user_logged_in): ?>
                            <li class="ecom-account-dropdown__item">
                                <a href="<?= safe(SITE) ?>siparislerim" class="ecom-account-dropdown__link">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z" />
                                    </svg>
                                    Siparişlerim
                                </a>
                            </li>
                            <li class="ecom-account-dropdown__item">
                                <a href="<?= safe(SITE) ?>hesabim" class="ecom-account-dropdown__link">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Hesabım
                                </a>
                            </li>
                            <li class="ecom-account-dropdown__item">
                                <a href="<?= safe(SITE) ?>cikis-yap" class="ecom-account-dropdown__link">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Çıkış Yap
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
</header>

<!-- Category Bar (Optional - Desktop Only) -->
<div class="ecom-categorybar">
    <div class="ecom-categorybar__container">
        <div class="ecom-categorybar__inner" style="position: relative; display: flex; gap: 1rem;">
            <button class="ecom-category-btn" aria-label="Kategoriler" aria-expanded="false"
                aria-controls="category-menu" id="category-btn">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                </svg>
                Tüm Kategoriler
            </button>



            <!-- Category Mega Menu -->
            <div class="ecom-category-menu" id="category-menu" aria-hidden="true">
                <ul class="ecom-category-menu__list">
                    <li class="ecom-category-menu__item">
                        <a href="<?= safe(SITE) ?>urunler" class="ecom-category-btn"
                            style="background: linear-gradient(135deg, var(--rose-600) 0%, var(--rose-500) 100%); text-decoration: none;">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 11a1 1 0 112 0 1 1 0 01-2 0zM9 15a1 1 0 112 0 1 1 0 01-2 0zM6.5 9a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM6.5 15a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM13.5 9a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM13.5 15a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            </svg>
                            Tüm Ürünler
                        </a>
                    </li>
                </ul>
                <ul class="ecom-category-menu__list">
                    <?php
                    $kategoriler = $VT->VeriGetir("kategoriler", "WHERE durum=? AND tablo=?", array(1, "urunler"), "ORDER BY sirano ASC");
                    if ($kategoriler !== false) {
                        foreach ($kategoriler as $kategori) {
                            echo '<li class="ecom-category-menu__item">';
                            echo '<a href="' . safe(SITE) . 'kategori/' . safe($kategori["seflink"]) . '" class="ecom-category-menu__link">';
                            echo safe(stripslashes($kategori["baslik"]));
                            echo '</a>';

                            // Subcategories
                            $altkategoriler = $VT->VeriGetir("kategoriler", "WHERE durum=? AND tablo=?", array(1, $kategori["seflink"]), "ORDER BY sirano ASC");
                            if ($altkategoriler !== false) {
                                echo '<ul class="ecom-category-menu__sublist">';
                                foreach ($altkategoriler as $alt) {
                                    echo '<li class="ecom-category-menu__subitem">';
                                    echo '<a href="' . safe(SITE) . 'kategori/' . safe($alt["seflink"]) . '" class="ecom-category-menu__sublink">';
                                    echo safe(stripslashes($alt["baslik"]));
                                    echo '</a></li>';
                                }
                                echo '</ul>';
                            }
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Navigation Drawer -->
<nav class="ecom-mobile-nav" id="mobile-nav" aria-hidden="true" aria-label="Mobil menü">
    <div class="ecom-mobile-nav__header">
        <div class="ecom-mobile-nav__title">Menü</div>
        <button class="ecom-mobile-nav__close" aria-label="Menüyü kapat" id="mobile-close">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <ul class="ecom-mobile-nav__list">
        <li class="ecom-mobile-nav__item">
            <a href="<?= safe(SITE) ?>" class="ecom-mobile-nav__link">Anasayfa</a>
        </li>

        <!-- Tüm Ürünler -->
        <li class="ecom-mobile-nav__item">
            <a href="<?= safe(SITE) ?>urunler" class="ecom-mobile-nav__link">Tüm Ürünler</a>
        </li>

        <!-- Kategoriler -->
        <li class="ecom-mobile-nav__item">
            <button class="ecom-mobile-nav__button" aria-expanded="false" aria-controls="mobile-kategoriler"
                id="mobile-kategoriler-btn">
                <span>Kategoriler</span>
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div class="ecom-mobile-submenu" id="mobile-kategoriler" aria-hidden="true">
                <ul class="ecom-mobile-submenu__list">
                    <?php
                    if ($kategoriler !== false) {
                        foreach ($kategoriler as $kategori) {
                            echo '<li class="ecom-mobile-submenu__item">';
                            echo '<a href="' . safe(SITE) . 'kategori/' . safe($kategori["seflink"]) . '" class="ecom-mobile-submenu__link">';
                            echo safe(stripslashes($kategori["baslik"]));
                            echo '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </li>

        <!-- Kurumsal -->
        <li class="ecom-mobile-nav__item">
            <button class="ecom-mobile-nav__button" aria-expanded="false" aria-controls="mobile-kurumsal"
                id="mobile-kurumsal-btn">
                <span>Kurumsal</span>
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div class="ecom-mobile-submenu" id="mobile-kurumsal" aria-hidden="true">
                <ul class="ecom-mobile-submenu__list">
                    <?php
                    if ($kurumsal !== false) {
                        foreach ($kurumsal as $item) {
                            echo '<li class="ecom-mobile-submenu__item">';
                            echo '<a href="' . safe(SITE) . 'kurumsal/' . safe($item["seflink"]) . '" class="ecom-mobile-submenu__link">';
                            echo safe(stripslashes($item["baslik"]));
                            echo '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </li>

        <!-- Gizlilik -->
        <li class="ecom-mobile-nav__item">
            <button class="ecom-mobile-nav__button" aria-expanded="false" aria-controls="mobile-gizlilik"
                id="mobile-gizlilik-btn">
                <span>Gizlilik</span>
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div class="ecom-mobile-submenu" id="mobile-gizlilik" aria-hidden="true">
                <ul class="ecom-mobile-submenu__list">
                    <?php
                    if ($gizlilik !== false) {
                        foreach ($gizlilik as $item) {
                            echo '<li class="ecom-mobile-submenu__item">';
                            echo '<a href="' . safe(SITE) . 'gizlilik-politikasi/' . safe($item["seflink"]) . '" class="ecom-mobile-submenu__link">';
                            echo safe(stripslashes($item["baslik"]));
                            echo '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </li>

        <li class="ecom-mobile-nav__item">
            <a href="<?= safe(SITE) ?>blog" class="ecom-mobile-nav__link">Blog</a>
        </li>

        <li class="ecom-mobile-nav__item">
            <a href="<?= safe(SITE) ?>iletisim" class="ecom-mobile-nav__link">İletişim</a>
        </li>
    </ul>

    <!-- Mobile Search -->
    <div class="ecom-mobile-search">
        <form action="<?= safe(SITE) ?>arama" method="GET" class="ecom-mobile-search__form">
            <input type="text" name="search" class="ecom-mobile-search__input" placeholder="Ürün ara..."
                aria-label="Arama">
            <button type="submit" class="ecom-mobile-search__button" aria-label="Ara">
                <svg fill="currentColor" viewBox="0 0 20 20" style="width: 20px; height: 20px;">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </form>
    </div>
</nav>

<!-- Overlay -->
<div class="ecom-overlay" id="overlay" aria-hidden="true"></div>

<script>
// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Elements
    const hamburger = document.getElementById('hamburger-btn');
    const mobileNav = document.getElementById('mobile-nav');
    const mobileClose = document.getElementById('mobile-close');
    const overlay = document.getElementById('overlay');
    const accountBtn = document.getElementById('account-btn');
    const accountDropdown = document.getElementById('account-dropdown');
    const categoryBtn = document.getElementById('category-btn');
    const categoryMenu = document.getElementById('category-menu');

    // Toggle helpers
    function toggleElement(trigger, target) {
        const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
        trigger.setAttribute('aria-expanded', !isExpanded);
        target.setAttribute('aria-hidden', isExpanded);
    }

    function closeAllDropdowns() {
        document.querySelectorAll('[aria-expanded="true"]').forEach(el => {
            el.setAttribute('aria-expanded', 'false');
        });
        document.querySelectorAll('[aria-hidden="false"]').forEach(el => {
            el.setAttribute('aria-hidden', 'true');
        });
    }

    // Mobile menu - Debug
    console.log('Hamburger:', hamburger);
    console.log('Mobile Nav:', mobileNav);
    console.log('Overlay:', overlay);

    if (hamburger && mobileNav && overlay) {
        hamburger.addEventListener('click', (e) => {
            e.preventDefault();
            console.log('Hamburger clicked!');

            const isOpen = hamburger.getAttribute('aria-expanded') === 'true';
            console.log('Current state - isOpen:', isOpen);

            if (!isOpen) {
                // OPEN MENU
                hamburger.setAttribute('aria-expanded', 'true');

                // CRITICAL: Remove aria-hidden BEFORE opening to allow focus
                mobileNav.removeAttribute('aria-hidden');
                overlay.removeAttribute('aria-hidden');

                // Force with inline styles - TRANSITION OVERRIDE
                mobileNav.style.cssText =
                    'position: fixed !important; top: 0 !important; left: 0 !important; width: 300px !important; height: 100vh !important; background: white !important; z-index: 9999 !important; display: block !important; visibility: visible !important; opacity: 1 !important; transform: translateX(0) !important; transition: transform 300ms ease-in-out !important;';

                overlay.style.cssText =
                    'position: fixed !important; top: 0 !important; left: 0 !important; width: 100% !important; height: 100% !important; background: rgba(0,0,0,0.5) !important; z-index: 9998 !important; display: block !important; visibility: visible !important; opacity: 1 !important; transition: opacity 300ms ease-in-out !important;';

                document.body.style.overflow = 'hidden';

                console.log('MENU OPENED - Check styles:');
                console.log('  left:', mobileNav.style.left);
                console.log('  display:', mobileNav.style.display);
                console.log('  visibility:', mobileNav.style.visibility);
                console.log('  z-index:', mobileNav.style.zIndex);
                console.log('  width:', mobileNav.style.width);

                // Computed styles
                const computed = window.getComputedStyle(mobileNav);
                console.log('COMPUTED:');
                console.log('  left:', computed.left);
                console.log('  display:', computed.display);
                console.log('  z-index:', computed.zIndex);
                console.log('  aria-hidden:', mobileNav.getAttribute('aria-hidden'));
            } else {
                // CLOSE MENU
                hamburger.setAttribute('aria-expanded', 'false');

                // Set aria-hidden AFTER closing animation
                setTimeout(() => {
                    mobileNav.setAttribute('aria-hidden', 'true');
                    overlay.setAttribute('aria-hidden', 'true');
                }, 300);

                // Force with inline styles - KAPATMA
                mobileNav.style.cssText =
                    'position: fixed !important; top: 0 !important; left: -100% !important; width: 300px !important; height: 100vh !important; transition: left 300ms ease-in-out !important;';
                overlay.style.cssText =
                    'opacity: 0 !important; visibility: hidden !important; transition: opacity 300ms ease-in-out !important;';

                // Remove focus from mobile menu elements
                setTimeout(() => hamburger.blur(), 100);

                document.body.style.overflow = '';

                console.log('MENU CLOSED');
            }
        });

        mobileClose.addEventListener('click', () => {
            hamburger.setAttribute('aria-expanded', 'false');

            // Force with inline styles - KAPATMA
            mobileNav.style.cssText =
                'position: fixed !important; top: 0 !important; left: -100% !important; width: 300px !important; height: 100vh !important; transition: left 300ms ease-in-out !important;';
            overlay.style.cssText =
                'opacity: 0 !important; visibility: hidden !important; transition: opacity 300ms ease-in-out !important;';

            // Set aria-hidden AFTER closing animation
            setTimeout(() => {
                mobileNav.setAttribute('aria-hidden', 'true');
                overlay.setAttribute('aria-hidden', 'true');
            }, 300);

            document.body.style.overflow = '';
        });

        overlay.addEventListener('click', () => {
            mobileClose.click();
        });
    }

    // Desktop dropdowns (Kurumsal, Gizlilik)
    ['kurumsal', 'gizlilik'].forEach(name => {
        const btn = document.getElementById(name + '-btn');
        const dropdown = document.getElementById(name + '-dropdown');
        if (btn && dropdown) {
            btn.addEventListener('click', () => toggleElement(btn, dropdown));
        }
    });

    // Account dropdown
    if (accountBtn && accountDropdown) {
        accountBtn.addEventListener('click', () => toggleElement(accountBtn, accountDropdown));
    }

    // Category menu
    if (categoryBtn && categoryMenu) {
        categoryBtn.addEventListener('click', () => toggleElement(categoryBtn, categoryMenu));
    }

    // Mobile submenus with debug
    ['mobile-kategoriler', 'mobile-kurumsal', 'mobile-gizlilik'].forEach(id => {
        const btn = document.getElementById(id + '-btn');
        const submenu = document.getElementById(id);

        console.log('Mobile submenu setup:', id, 'btn:', btn, 'submenu:', submenu);

        if (btn && submenu) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                console.log('Mobile dropdown clicked:', id);
                console.log('Before toggle - aria-expanded:', btn.getAttribute(
                'aria-expanded'));
                console.log('Before toggle - aria-hidden:', submenu.getAttribute(
                'aria-hidden'));

                toggleElement(btn, submenu);

                console.log('After toggle - aria-expanded:', btn.getAttribute('aria-expanded'));
                console.log('After toggle - aria-hidden:', submenu.getAttribute('aria-hidden'));
            });
        }
    });

    // Click outside to close
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.ecom-nav__item') &&
            !e.target.closest('.ecom-icon-btn') &&
            !e.target.closest('.ecom-categorybar__inner')) {
            closeAllDropdowns();
        }
    });

    // Escape to close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAllDropdowns();
            if (mobileNav.getAttribute('aria-hidden') === 'false') {
                mobileClose.click();
            }
        }
    });

    console.log('✅ E-commerce Header v3.0 - Professional & Clean');
});
</script>

<!-- ═══════════════════════════════════════════════════════════
     BOTTOM NAVIGATION BAR (Fixed Mobile Navigation)
════════════════════════════════════════════════════════════ -->
<style>
/* Bottom Navigation - Sabit Alt Bar */
.ecom-bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    height: 70px;
    background: var(--white);
    border-top: 1px solid var(--gray-200);
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1001;
    display: none;
    /* Sadece mobilde göster */
    padding-bottom: env(safe-area-inset-bottom);
    /* iPhone notch desteği */
}

.ecom-bottom-nav__container {
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 100%;
    max-width: 100%;
    margin: 0 auto;
    padding: 0 var(--space-1);
}

.ecom-bottom-nav__item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    text-decoration: none;
    color: var(--gray-600);
    transition: all var(--transition-fast);
    padding: var(--space-1);
    border-radius: 8px;
    position: relative;
    cursor: pointer;
    background: none;
    border: none;
}

.ecom-bottom-nav__item:active {
    background: var(--green-50);
    transform: scale(0.95);
}

.ecom-bottom-nav__item.active {
    color: var(--green-600);
}

.ecom-bottom-nav__icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.ecom-bottom-nav__icon svg {
    width: 24px;
    height: 24px;
}

.ecom-bottom-nav__label {
    font-size: 11px;
    font-weight: 500;
    white-space: nowrap;
}

/* Badge için bottom nav versiyonu */
.ecom-bottom-nav__badge {
    position: absolute;
    top: -4px;
    right: -4px;
    min-width: 18px;
    height: 18px;
    background: var(--rose-600);
    color: var(--white);
    border-radius: 9px;
    font-size: 11px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
    line-height: 1;
    box-shadow: 0 2px 4px rgba(201, 138, 143, 0.3);
}

/* Mobile body padding - bottom nav için alan aç */
@media (max-width: 991px) {
    .ecom-bottom-nav {
        display: block;
    }

    /* Ana içeriğe bottom padding ekle */
    body {
        padding-bottom: 70px;
    }
}

/* iPhone X ve üzeri için safe area */
@supports (padding: max(0px)) {
    @media (max-width: 991px) {
        .ecom-bottom-nav {
            height: calc(70px + env(safe-area-inset-bottom));
            padding-bottom: env(safe-area-inset-bottom);
        }

        body {
            padding-bottom: calc(70px + env(safe-area-inset-bottom));
        }
    }
}
</style>

<!-- Bottom Navigation HTML -->
<nav class="ecom-bottom-nav" aria-label="Ana navigasyon">
    <div class="ecom-bottom-nav__container">
        <!-- Menu -->
        <button class="ecom-bottom-nav__item" id="bottom-menu-btn" aria-label="Menü" title="Menü">
            <span class="ecom-bottom-nav__icon">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd" />
                </svg>
            </span>
            <span class="ecom-bottom-nav__label">Menü</span>
        </button>

        <!-- Wishlist -->
        <a href="<?= safe(SITE) ?>favorilerim" class="ecom-bottom-nav__item" aria-label="Favorilerim"
            title="Favorilerim">
            <span class="ecom-bottom-nav__icon">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                        clip-rule="evenodd" />
                </svg>
            </span>
            <span class="ecom-bottom-nav__label">Favoriler</span>
        </a>

        <!-- Cart -->
        <a href="<?= safe(SITE) ?>sepet" class="ecom-bottom-nav__item" aria-label="Sepet" title="Sepet">
            <span class="ecom-bottom-nav__icon">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
                <?php if ($cart_count > 0): ?>
                <span class="ecom-bottom-nav__badge"><?= $cart_count ?></span>
                <?php endif; ?>
            </span>
            <span class="ecom-bottom-nav__label">Sepet</span>
        </a>

        <!-- Account -->
        <a href="<?= safe(SITE) ?><?= $user_logged_in ? 'hesabim' : 'uyelik' ?>" class="ecom-bottom-nav__item"
            aria-label="<?= $user_logged_in ? 'Hesabım' : 'Giriş Yap' ?>"
            title="<?= $user_logged_in ? 'Hesabım' : 'Giriş Yap' ?>">
            <span class="ecom-bottom-nav__icon">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd" />
                </svg>
            </span>
            <span class="ecom-bottom-nav__label"><?= $user_logged_in ? 'Hesap' : 'Giriş' ?></span>
        </a>
    </div>
</nav>

<script>
// Bottom Navigation - Menu button functionality
document.addEventListener('DOMContentLoaded', function() {
    const bottomMenuBtn = document.getElementById('bottom-menu-btn');
    const hamburger = document.getElementById('hamburger-btn');

    if (bottomMenuBtn && hamburger) {
        bottomMenuBtn.addEventListener('click', function() {
            // Hamburger menüyü tetikle
            hamburger.click();
        });
    }

    console.log('✅ Bottom Navigation Initialized');
});
</script>