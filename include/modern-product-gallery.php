<?php
/**
 * Modern Product Gallery Component
 * Ürün detay sayfası için modern, animasyonlu galeri bileşeni
 * Vanilla JS ile yazılmış - jQuery/Owl Carousel gerektirmez
 */

// Get all product images
$allImages = [];
$allImages[] = [
    'url' => SITE . 'images/urunler/' . $urunbilgisi[0]["resim"],
    'alt' => stripslashes($urunbilgisi[0]["baslik"])
];

$resimler = $VT->VeriGetir("resimler", "WHERE tablo=? AND KID=?", array("urunler", $urunbilgisi[0]["ID"]), "ORDER BY ID ASC");
if ($resimler !== false) {
    foreach ($resimler as $resim) {
        $allImages[] = [
            'url' => SITE . 'images/resimler/' . $resim["resim"],
            'alt' => stripslashes($urunbilgisi[0]["baslik"])
        ];
    }
}
?>

<style>
/* Modern Product Gallery Styles - fixed spacing between main image and thumbnails */
.modern-gallery {
    position: relative;
    width: 100%;
    margin: 0 !important;
    padding: 0 !important;
    line-height: 0 !important;
    font-size: 0 !important;
}

.modern-gallery__main {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 100%;
    background: linear-gradient(135deg, #f8f8f8 0%, #f0f0f0 100%);
    border-radius: 16px;
    overflow: hidden;
    margin: 0 !important;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    display: block;
    line-height: 0;
    font-size: 0;
}

.modern-gallery__image {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    visibility: hidden;
    transition: opacity 500ms cubic-bezier(0.4, 0, 0.2, 1), transform 500ms cubic-bezier(0.4, 0, 0.2, 1);
    cursor: zoom-in;
    transform: scale(1.05);
}

.modern-gallery__image.active {
    opacity: 1;
    visibility: visible;
    z-index: 1;
    transform: scale(1);
}

.modern-gallery__image:hover {
    transform: scale(1.03) !important;
    transition: transform 600ms ease-out;
}

/* Navigation Arrows */
.modern-gallery__nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(8px);
    border: none;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.modern-gallery__nav:hover {
    background: #8B9D83;
    color: white;
    box-shadow: 0 6px 20px rgba(139,157,131,0.5);
    transform: translateY(-50%) scale(1.15);
}

.modern-gallery__nav:active {
    transform: translateY(-50%) scale(0.95);
}

.modern-gallery__nav--prev {
    left: 20px;
}

.modern-gallery__nav--next {
    right: 20px;
}

.modern-gallery__nav svg {
    width: 28px;
    height: 28px;
}

/* Image Counter Badge */
.modern-gallery__counter {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,0.75);
    backdrop-filter: blur(12px);
    color: white;
    padding: 10px 20px;
    border-radius: 24px;
    font-size: 15px;
    font-weight: 600;
    z-index: 5;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

/* Thumbnails Grid - fixed spacing between main image and thumbnails */
.modern-gallery__thumbs {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
    gap: 6px;
    margin: 0 !important;
    margin-top: 0 !important;
    padding: 0 !important;
    padding-top: 0 !important;
    width: 100%;
    line-height: 0;
    font-size: 0;
}

.modern-gallery__thumb {
    aspect-ratio: 1;
    width: 100%;
    height: auto;
    min-height: unset;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    background: #f5f5f5;
    margin: 0;
    padding: 0;
}

.modern-gallery__thumb::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0);
    transition: background 300ms ease;
    border-radius: 8px;
}

.modern-gallery__thumb:hover::after {
    background: rgba(0,0,0,0.15);
}

.modern-gallery__thumb.active {
    border-color: #D4A5A5;
    box-shadow: 0 4px 16px rgba(212,165,165,0.4);
    transform: scale(1.08);
}

.modern-gallery__thumb-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 300ms ease;
    margin: 0;
    padding: 0;
    vertical-align: top;
}

.modern-gallery__thumb:hover .modern-gallery__thumb-image {
    transform: scale(1.1);
}

/* Zoom Modal */
.modern-gallery__zoom {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.95);
    backdrop-filter: blur(20px);
    z-index: 999999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    animation: fadeIn 300ms ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.modern-gallery__zoom.active {
    display: flex;
}

.modern-gallery__zoom-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    animation: zoomIn 400ms cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes zoomIn {
    from {
        transform: scale(0.8);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.modern-gallery__zoom-close {
    position: absolute;
    top: 30px;
    right: 30px;
    background: white;
    border: none;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 300ms ease;
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

.modern-gallery__zoom-close:hover {
    transform: scale(1.1) rotate(90deg);
    background: #D4A5A5;
    color: white;
}

/* Mobile Responsive - fixed spacing between main image and thumbnails */
@media (max-width: 768px) {
    .modern-gallery__main {
        border-radius: 12px;
        margin: 0 !important;
        padding-bottom: 100%;
    }

    .modern-gallery__thumbs {
        grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
        gap: 5px;
        margin: 0 !important;
        margin-top: 0 !important;
        padding: 0 !important;
        padding-top: 0 !important;
    }

    .modern-gallery__thumb {
        margin: 0 !important;
        padding: 0 !important;
    }
}

    .modern-gallery__nav {
        width: 44px;
        height: 44px;
    }

    .modern-gallery__nav svg {
        width: 22px;
        height: 22px;
    }

    .modern-gallery__nav--prev {
        left: 12px;
    }

    .modern-gallery__nav--next {
        right: 12px;
    }

    .modern-gallery__counter {
        padding: 8px 16px;
        font-size: 13px;
        bottom: 16px;
    }

    .modern-gallery__zoom-close {
        top: 20px;
        right: 20px;
        width: 48px;
        height: 48px;
    }
}
</style>

<div class="modern-gallery" id="modernGallery">
    <!-- Main Image Display -->
    <div class="modern-gallery__main">
        <?php foreach ($allImages as $index => $image): ?>
            <img
                src="<?= $image['url'] ?>"
                alt="<?= $image['alt'] ?>"
                class="modern-gallery__image <?= $index === 0 ? 'active' : '' ?>"
                loading="<?= $index === 0 ? 'eager' : 'lazy' ?>"
                data-index="<?= $index ?>">
        <?php endforeach; ?>

        <!-- Navigation Arrows -->
        <?php if (count($allImages) > 1): ?>
            <button class="modern-gallery__nav modern-gallery__nav--prev" aria-label="Önceki resim" title="Önceki resim">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </button>
            <button class="modern-gallery__nav modern-gallery__nav--next" aria-label="Sonraki resim" title="Sonraki resim">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
            </button>

            <!-- Counter Badge -->
            <div class="modern-gallery__counter">
                <span class="modern-gallery__current">1</span> / <?= count($allImages) ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Thumbnails Grid -->
    <?php if (count($allImages) > 1): ?>
        <div class="modern-gallery__thumbs">
            <?php foreach ($allImages as $index => $image): ?>
                <div class="modern-gallery__thumb <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>" title="Resim <?= $index + 1 ?>">
                    <img
                        src="<?= $image['url'] ?>"
                        alt="<?= $image['alt'] ?>"
                        class="modern-gallery__thumb-image"
                        loading="lazy">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Zoom Modal -->
<div class="modern-gallery__zoom" id="galleryZoom">
    <button class="modern-gallery__zoom-close" aria-label="Kapat" title="Kapat (ESC)">
        <svg fill="currentColor" viewBox="0 0 20 20" width="26" height="26">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
    </button>
    <img src="" alt="" class="modern-gallery__zoom-image" id="zoomImage">
</div>

<script>
(function() {
    'use strict';

    const gallery = document.getElementById('modernGallery');
    if (!gallery) return;

    const images = gallery.querySelectorAll('.modern-gallery__image');
    const thumbs = gallery.querySelectorAll('.modern-gallery__thumb');
    const prevBtn = gallery.querySelector('.modern-gallery__nav--prev');
    const nextBtn = gallery.querySelector('.modern-gallery__nav--next');
    const counter = gallery.querySelector('.modern-gallery__current');
    const zoom = document.getElementById('galleryZoom');
    const zoomImage = document.getElementById('zoomImage');
    const zoomClose = zoom?.querySelector('.modern-gallery__zoom-close');

    let currentIndex = 0;

    function showImage(index) {
        // Loop around
        if (index < 0) index = images.length - 1;
        if (index >= images.length) index = 0;

        // Update images
        images.forEach((img, i) => {
            img.classList.toggle('active', i === index);
        });

        // Update thumbnails
        thumbs.forEach((thumb, i) => {
            thumb.classList.toggle('active', i === index);
        });

        // Update counter
        if (counter) counter.textContent = index + 1;

        currentIndex = index;
    }

    // Thumbnail clicks
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', () => {
            const index = parseInt(thumb.dataset.index);
            showImage(index);
        });
    });

    // Arrow navigation
    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            showImage(currentIndex - 1);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            showImage(currentIndex + 1);
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') showImage(currentIndex - 1);
        if (e.key === 'ArrowRight') showImage(currentIndex + 1);
        if (e.key === 'Escape' && zoom) {
            zoom.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Zoom functionality
    images.forEach(img => {
        img.addEventListener('click', () => {
            if (zoom && zoomImage) {
                zoomImage.src = img.src;
                zoomImage.alt = img.alt;
                zoom.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Close zoom
    if (zoomClose) {
        zoomClose.addEventListener('click', () => {
            zoom.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Click outside to close zoom
    if (zoom) {
        zoom.addEventListener('click', (e) => {
            if (e.target === zoom) {
                zoom.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    // Touch swipe support
    let touchStartX = 0;
    let touchEndX = 0;

    const mainContainer = gallery.querySelector('.modern-gallery__main');

    mainContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    mainContainer.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        const diff = touchStartX - touchEndX;

        // Minimum swipe distance: 50px
        if (Math.abs(diff) > 50) {
            if (diff > 0) {
                showImage(currentIndex + 1); // Swipe left - next
            } else {
                showImage(currentIndex - 1); // Swipe right - prev
            }
        }
    }, { passive: true });

    // Preload images for smooth transitions
    images.forEach(img => {
        const preloadImg = new Image();
        preloadImg.src = img.src;
    });

    console.log('✅ Modern Product Gallery Initialized - ' + images.length + ' images');
})();
</script>
