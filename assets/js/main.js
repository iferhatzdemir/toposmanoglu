(function ($) {
  "use strict";

  var $introVideoModal = $('#introVideoModal');
  var $preloader = $('.preloader');
  var introVideoDisplayed = false;
  var defaultVideoSource = '';
  var currentVideoSource = '';

  function parseIntroVideoStart(value) {
    if (!value) {
      return '';
    }

    if (/^\d+$/.test(value)) {
      return value;
    }

    var totalSeconds = 0;
    var hourMatch = /([0-9]+)h/.exec(value);
    var minuteMatch = /([0-9]+)m/.exec(value);
    var secondMatch = /([0-9]+)s/.exec(value);

    if (hourMatch) {
      totalSeconds += parseInt(hourMatch[1], 10) * 3600;
    }

    if (minuteMatch) {
      totalSeconds += parseInt(minuteMatch[1], 10) * 60;
    }

    if (secondMatch) {
      totalSeconds += parseInt(secondMatch[1], 10);
    }

    if (totalSeconds > 0) {
      return String(totalSeconds);
    }

    var numeric = value.replace(/[^0-9]/g, '');
    return numeric;
  }

  function resolveIntroVideoSource(rawSource) {
    if (typeof rawSource !== 'string') {
      return '';
    }

    var trimmed = rawSource.trim();

    if (!trimmed) {
      return '';
    }

    if (typeof URL === 'function' && typeof URLSearchParams === 'function') {
      try {
        var url = new URL(trimmed, window.location.href);
        var hostname = url.hostname.replace(/^www\./, '');
        var params = new URLSearchParams(url.search);
        var startTime = '';

        if (params.has('start')) {
          startTime = params.get('start');
        } else if (params.has('t')) {
          startTime = params.get('t');
        } else if (url.hash && url.hash.indexOf('t=') > -1) {
          startTime = url.hash.split('t=')[1];
        }

        startTime = parseIntroVideoStart(startTime);

        if (hostname.indexOf('youtube.com') !== -1 || hostname.indexOf('youtu.be') !== -1 || hostname.indexOf('youtube-nocookie.com') !== -1) {
          var videoId = '';

          if (hostname.indexOf('youtu.be') !== -1) {
            videoId = url.pathname.replace('/', '');
          } else if (url.pathname.indexOf('/embed/') === 0) {
            videoId = url.pathname.split('/embed/')[1];
          } else if (params.has('v')) {
            videoId = params.get('v');
          }

          videoId = videoId ? videoId.replace(/[^a-zA-Z0-9_-]/g, '') : '';

          if (videoId) {
            var embedBase = 'https://www.youtube.com/embed/' + videoId;
            var embedParams = new URLSearchParams();
            embedParams.set('autoplay', '1');
            embedParams.set('mute', '1');
            embedParams.set('rel', '0');
            embedParams.set('showinfo', '0');

            if (startTime) {
              embedParams.set('start', startTime);
            }

            return embedBase + '?' + embedParams.toString();
          }
        }

        params.set('autoplay', '1');
        params.set('mute', '1');

        if (!params.has('rel')) {
          params.set('rel', '0');
        }

        if (!params.has('showinfo')) {
          params.set('showinfo', '0');
        }

        url.search = params.toString();
        return url.toString();
      } catch (error) {
        // fall through to manual parsing
      }
    }

    var fallbackMatch = trimmed.match(/(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:watch\?v=|embed\/))([A-Za-z0-9_-]{6,})/);

    if (fallbackMatch && fallbackMatch[1]) {
      var baseEmbed = 'https://www.youtube.com/embed/' + fallbackMatch[1];
      var startMatch = trimmed.match(/[?&](?:start|t)=([^&]+)/);
      var startValue = startMatch && startMatch[1] ? parseIntroVideoStart(startMatch[1]) : '';
      var queryParts = ['autoplay=1', 'mute=1', 'rel=0', 'showinfo=0'];

      if (startValue) {
        queryParts.push('start=' + startValue);
      }

      return baseEmbed + '?' + queryParts.join('&');
    }

    return trimmed;
  }

  function setIntroVideoSource(rawSource) {
    if (!$introVideoModal.length) {
      return '';
    }

    var resolvedSource = resolveIntroVideoSource(rawSource);

    if (!resolvedSource) {
      return '';
    }

    var $iframe = $introVideoModal.find('iframe');

    if (!$iframe.length) {
      return '';
    }

    $iframe.data('src', resolvedSource);
    $iframe.attr('data-src', resolvedSource);

    if ($introVideoModal.hasClass('is-visible')) {
      var activeSrc = $iframe.attr('src');
      if (activeSrc !== resolvedSource) {
        $iframe.attr('src', resolvedSource);
      }
    }

    currentVideoSource = resolvedSource;
    return resolvedSource;
  }

  function getIntroVideoTriggerSource($trigger) {
    if (!$trigger || !$trigger.length) {
      return '';
    }

    var source = $trigger.data('introVideoSrc');

    if (typeof source === 'undefined') {
      source = $trigger.data('videoSrc');
    }

    if (typeof source === 'undefined') {
      source = $trigger.attr('data-video-src');
    }

    if (typeof source === 'undefined') {
      source = $trigger.attr('href');
    }

    return typeof source === 'string' ? source : '';
  }

  if ($introVideoModal.length) {
    defaultVideoSource = $introVideoModal.data('defaultVideo') || '';

    if (!defaultVideoSource) {
      var $firstIntroTrigger = $('[data-intro-video-open]').first();
      if ($firstIntroTrigger.length) {
        defaultVideoSource = getIntroVideoTriggerSource($firstIntroTrigger);
      }
    }

    if (defaultVideoSource) {
      var resolvedDefaultSource = setIntroVideoSource(defaultVideoSource);
      if (resolvedDefaultSource) {
        defaultVideoSource = resolvedDefaultSource;
      }
    }
  }

  function showIntroVideoModal(forceOpen) {
    if (!$introVideoModal.length) {
      return;
    }

    if ($introVideoModal.hasClass('is-visible')) {
      return;
    }

    if (introVideoDisplayed && !forceOpen) {
      return;
    }

    introVideoDisplayed = true;

    var delay = forceOpen ? 0 : 400;

    setTimeout(function () {
      var $iframe = $introVideoModal.find('iframe');
      if (!$iframe.length) {
        return;
      }

      var targetSrc = $iframe.data('src');

      if (!targetSrc && currentVideoSource) {
        targetSrc = setIntroVideoSource(currentVideoSource);
      }

      if (!targetSrc && defaultVideoSource) {
        targetSrc = setIntroVideoSource(defaultVideoSource);
      }

      var targetSrc = $iframe.data('src');
      var currentSrc = $iframe.attr('src');

      if (targetSrc && currentSrc !== targetSrc) {
        $iframe.attr('src', targetSrc);
      }

      $('body').addClass('video-modal-open');
      $introVideoModal.attr('aria-hidden', 'false').addClass('is-visible');

      var $closeButton = $introVideoModal.find('.video-modal__close');
      if ($closeButton.length) {
        setTimeout(function () {
          $closeButton.trigger('focus');
        }, 50);
      }
    }, delay);
  }

  function hideIntroVideoModal() {
    if (!$introVideoModal.length) {
      return;
    }

    $introVideoModal.removeClass('is-visible').attr('aria-hidden', 'true');
    $('body').removeClass('video-modal-open');

    var $iframe = $introVideoModal.find('iframe');
    if ($iframe.length) {
      var activeSrc = $iframe.attr('src');
      if (activeSrc) {
        $iframe.attr('src', '');
      }
    }
  }

  if ($introVideoModal.length) {
    $introVideoModal.on('click', function (e) {
      if ($(e.target).is($introVideoModal) || $(e.target).is('.video-modal__overlay')) {
        hideIntroVideoModal();
      }
    });

    $introVideoModal.find('.video-modal__content').on('click', function (e) {
      e.stopPropagation();
    });

    $introVideoModal.find('[data-video-modal-close]').on('click', function (e) {
      e.preventDefault();
      hideIntroVideoModal();
    });

    $('[data-intro-video-open]').on('click', function (e) {
      e.preventDefault();
      e.stopImmediatePropagation();

      var requestedSource = getIntroVideoTriggerSource($(this));

      if (requestedSource) {
        var resolvedRequestedSource = setIntroVideoSource(requestedSource);
        if (resolvedRequestedSource && !defaultVideoSource) {
          defaultVideoSource = resolvedRequestedSource;
        }
      }

      showIntroVideoModal(true);
    });

    $(document).on('keydown', function (e) {
      if (e.key === 'Escape' && $introVideoModal.hasClass('is-visible')) {
        hideIntroVideoModal();
      }
    });
  }

/*===========================================
      Table of contents
  01. On Load Function
  02. Preloader
  03. Mobile Menu Active
  04. Sticky fix
  05. Scroll To Top
  06. Set Background Image
  07. Popup Sidemenu
  08. Search Box Popup
  09. Counter Up Active
  10. Hero Slider Active
  11. Select Box Active
  12. Date & Time Picker
  13. Magnific Popup
  14. Woocommerce Toggle
  15. Filter Active
  16. Range Slider
  17. Quantity Added
  18. Offer Count Down
  19. Global Toggle
  20. Box Nav Toggler
  21. WOW Js(Scroll Animation)
  22. Tooltip Active
  23. Slider Tab
  24. Shape Mockup
  25. Accordion Style
  26. Tab Slider Refresh
  00. Color Plate
  00. Right Click Disable
  00. Inspect Element Disable
=============================================*/


  /*---------- 01. On Load Function ----------*/
  $(window).on('load', function () {
    if ($preloader.length && $preloader.is(':visible')) {
      $preloader.fadeOut(500, function () {
        showIntroVideoModal();
      });
    } else {
      showIntroVideoModal();
    }
  });



  /*---------- 02. Preloader ----------*/
  if ($preloader.length > 0) {
    $('.preloaderCls').each(function () {
      $(this).on('click', function (e) {
        e.preventDefault();
        $preloader.css('display', 'none');
        showIntroVideoModal();
      })
    });
  };


  var ozgidaSliderRegistry = [];
  var ozgidaSliderRegistryBound = false;

  function initOzgidaHeroSlider() {
    var $sliders = $('[data-ozgida-slider]');

    if (!$sliders.length) {
      return;
    }

    $sliders.each(function () {
      var $slider = $(this);

      if ($slider.data('ozgidaSliderInit')) {
        return;
      }

      $slider.data('ozgidaSliderInit', true);

      var $slides = $slider.find('.ozgida-slide');
      var total = $slides.length;

      if (total <= 1) {
        $slider.removeAttr('tabindex role aria-roledescription aria-live aria-label');
        $slides.attr('aria-hidden', 'false');
        return;
      }

      var $dots = $slider.find('[data-ozgida-slider-dot]');
      var autoplayDelay = parseInt($slider.attr('data-ozgida-autoplay'), 10);

      if (isNaN(autoplayDelay) || autoplayDelay < 0) {
        autoplayDelay = 5000;
      }

      if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        autoplayDelay = 0;
      }

      var $activeSlide = $slides.filter('.active').first();
      var current = $slides.index($activeSlide);

      if (current < 0) {
        current = 0;
      }

      $slides.removeClass('active').attr('aria-hidden', 'true').eq(current).addClass('active').attr('aria-hidden', 'false');

      if ($dots.length) {
        $dots.removeClass('active').attr('aria-current', null)
          .filter('[data-ozgida-slider-dot="' + current + '"]').addClass('active').attr('aria-current', 'true');
      }

      var autoplayTimer = null;
      var touchStartX = 0;

      function stopAutoplay() {
        if (autoplayTimer) {
          clearInterval(autoplayTimer);
          autoplayTimer = null;
        }
      }

      function restartAutoplay() {
        if (autoplayDelay <= 0) {
          stopAutoplay();
          return;
        }

        stopAutoplay();
        autoplayTimer = window.setInterval(function () {
          showSlide(current + 1, true);
        }, autoplayDelay);
      }

      function showSlide(targetIndex, skipRestart) {
        if (!total) {
          return;
        }

        var normalized = ((targetIndex % total) + total) % total;

        if (normalized === current) {
          if (!skipRestart) {
            restartAutoplay();
          }
          return;
        }

        $slides.removeClass('active').attr('aria-hidden', 'true').eq(normalized).addClass('active').attr('aria-hidden', 'false');

        if ($dots.length) {
          $dots.removeClass('active').attr('aria-current', null)
            .filter('[data-ozgida-slider-dot="' + normalized + '"]').addClass('active').attr('aria-current', 'true');
        }

        var $content = $slides.eq(normalized).find('.ozgida-slide-inner');
        if ($content.length) {
          $content.css('animation', 'none');
          var raf = window.requestAnimationFrame || function (callback) {
            return window.setTimeout(callback, 16);
          };
          raf(function () {
            $content.css('animation', '');
          });
        }

        current = normalized;

        if (!skipRestart) {
          restartAutoplay();
        }
      }

      function goTo(index) {
        stopAutoplay();
        showSlide(index);
      }

      function next() {
        goTo(current + 1);
      }

      function prev() {
        goTo(current - 1);
      }

      var $prev = $slider.find('[data-ozgida-slider-prev]');
      var $next = $slider.find('[data-ozgida-slider-next]');

      if ($prev.length) {
        $prev.on('click', function (event) {
          event.preventDefault();
          prev();
        });
      }

      if ($next.length) {
        $next.on('click', function (event) {
          event.preventDefault();
          next();
        });
      }

      if ($dots.length) {
        $dots.each(function () {
          var $dot = $(this);
          var dotIndex = parseInt($dot.attr('data-ozgida-slider-dot'), 10);

          if (isNaN(dotIndex)) {
            return;
          }

          $dot.on('click', function (event) {
            event.preventDefault();
            goTo(dotIndex);
          });
        });
      }

      $slider.on('mouseenter', function () {
        stopAutoplay();
      });

      $slider.on('mouseleave', function () {
        restartAutoplay();
      });

      $slider.on('touchstart', function (event) {
        if (!event.originalEvent || !event.originalEvent.changedTouches || !event.originalEvent.changedTouches.length) {
          return;
        }

        touchStartX = event.originalEvent.changedTouches[0].screenX;
        stopAutoplay();
      });

      $slider.on('touchend', function (event) {
        if (!event.originalEvent || !event.originalEvent.changedTouches || !event.originalEvent.changedTouches.length) {
          restartAutoplay();
          return;
        }

        var touchEndX = event.originalEvent.changedTouches[0].screenX;
        var diff = touchStartX - touchEndX;

        if (Math.abs(diff) > 40) {
          if (diff > 0) {
            next();
          } else {
            prev();
          }
        } else {
          restartAutoplay();
        }
      });

      $slider.on('keydown', function (event) {
        if (event.key === 'ArrowLeft') {
          event.preventDefault();
          prev();
        } else if (event.key === 'ArrowRight') {
          event.preventDefault();
          next();
        } else if (event.key === 'Escape') {
          stopAutoplay();
        }
      });

      restartAutoplay();

      var controls = {
        next: function () {
          next();
        },
        prev: function () {
          prev();
        },
        goTo: function (index) {
          if (typeof index === 'number') {
            goTo(index);
          }
        },
        stopAutoplay: stopAutoplay,
        startAutoplay: restartAutoplay
      };

      $slider.data('ozgidaSliderControl', controls);

      ozgidaSliderRegistry.push(controls);

      if (typeof window !== 'undefined') {
        window.ozgidaSliders = window.ozgidaSliders || [];
        window.ozgidaSliders.push(controls);
        window.ozgidaSlider = controls;
      }

      if (!ozgidaSliderRegistryBound) {
        $(window).on('beforeunload.ozgidaSlider', function () {
          ozgidaSliderRegistry.forEach(function (sliderControl) {
            if (sliderControl && typeof sliderControl.stopAutoplay === 'function') {
              sliderControl.stopAutoplay();
            }
          });
        });
        ozgidaSliderRegistryBound = true;
      }
    });
  }

  $(function () {
    initOzgidaHeroSlider();
  });



  /*---------- 03. Mobile Menu Active ----------*/



  /*---------- 03. Mobile Menu Active ----------*/
  // Eski jQuery mobil menü devre dışı - Yeni vanilla JS hamburger menü kullanılıyor
  // $('.mobile-menu-active').vsmobilemenu({
  //   menuContainer: '.vs-mobile-menu',
  //   expandScreenWidth: 992,
  //   menuToggleBtn: '.vs-menu-toggle',
  // });



  /*---------- 04. Sticky fix ----------*/
  var lastScrollTop = '';
  var scrollToTopBtn = '.scrollToTop'

  function stickyMenu($targetMenu, $toggleClass) {
    var st = $(window).scrollTop();
    if ($(window).scrollTop() > 600) {
      if (st > lastScrollTop) {
        $targetMenu.removeClass($toggleClass);

      } else {
        $targetMenu.addClass($toggleClass);
      };
    } else {
      $targetMenu.removeClass($toggleClass);
    };
    lastScrollTop = st;
  };
  $(window).on("scroll", function () {
    stickyMenu($('.sticky-header'), "active");
    if ($(this).scrollTop() > 400) {
      $(scrollToTopBtn).addClass('show');
    } else {
      $(scrollToTopBtn).removeClass('show');
    }
  });



  /*---------- 05. Scroll To Top ----------*/
  $(scrollToTopBtn).on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, 3000);

    return false;
  });




  /*---------- 06.Set Background Image ----------*/
  if ($('[data-bg-src]').length > 0) {
    $('[data-bg-src]').each(function () {
      var src = $(this).attr('data-bg-src');
      $(this).css({
        'background-image': 'url(' + src + ')'
      });
    });
  };





  /*---------- 07. Popup Sidemenu ----------*/
  function popupSideMenu($sideMenu, $sideMunuOpen, $sideMenuCls, $toggleCls) {
    // Sidebar Popup
    $($sideMunuOpen).on('click', function (e) {
      e.preventDefault();
      $($sideMenu).addClass($toggleCls);
    });
    $($sideMenu).on('click', function (e) {
      e.stopPropagation();
      $($sideMenu).removeClass($toggleCls)
    });
    var sideMenuChild = $sideMenu + ' > div';
    $(sideMenuChild).on('click', function (e) {
      e.stopPropagation();
      $($sideMenu).addClass($toggleCls)
    });
    $($sideMenuCls).on('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      $($sideMenu).removeClass($toggleCls);
    });
  };
  popupSideMenu('.sidemenu-wrapper', '.sideMenuToggler', '.sideMenuCls', 'show');





  /*---------- 08. Search Box Popup ----------*/
  function popupSarchBox($searchBox, $searchOpen, $searchCls, $toggleCls) {
    $($searchOpen).on('click', function (e) {
      e.preventDefault();
      $($searchBox).addClass($toggleCls);
    });
    $($searchBox).on('click', function (e) {
      e.stopPropagation();
      $($searchBox).removeClass($toggleCls);
    });
    $($searchBox).find('form').on('click', function (e) {
      e.stopPropagation();
      $($searchBox).addClass($toggleCls);
    });
    $($searchCls).on('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      $($searchBox).removeClass($toggleCls);
    });
  };
  popupSarchBox('.popup-search-box', '.searchBoxTggler', '.searchClose', 'show');





  /*----------- 10. Hero Slider Active ----------*/
  $('.vs-hero-carousel').each(function () {
    var vsHslide = $(this);

    // return function for dom data
    function d(data) {
      return vsHslide.data(data)
    }
    
    /* Custom Thumb Navigation */
    var customNav = '.thumb';
    var navDom = 'data-slide-go';

    vsHslide.on('sliderDidLoad', function (event, slider) { // On Slide Init
      var currentSlide = slider.slides.current.index; // current Slide index 
      var i = 1;
      // Set Attribute 
      vsHslide.find(customNav).each(function(){
        $(this).attr(navDom, i)
        i++
        // On Click Thumb, Change slide
        $(this).on('click', function(e){
          e.preventDefault();
          var target = $(this).attr(navDom);
          vsHslide.layerSlider(parseInt(target));
        })
      });
      // Add class To current Thumb
      var currentNav = customNav + '[' + navDom + '="' + currentSlide + '"';
      $(currentNav).addClass('active');
    }).on('slideChangeDidComplete', function (event, slider) { // On slide Change Start
      var currentActive = slider.slides.current.index; // After change Current Index
      var currentNav = customNav + '[' + navDom + '="' + currentActive + '"';
      $(currentNav).addClass('active') // Add Class on current Nav
      $(currentNav).siblings().removeClass('active');
    });





    /* Custom Responsive Option */
    vsHslide.on('sliderWillLoad', function (event, slider) {
      // Define Variable
      var respLayer = jQuery(this).find('.ls-responsive'),
        lsDesktop = 'ls-desktop',
        lsLaptop = 'ls-laptop',
        lsTablet = 'ls-tablet',
        lsMobile = 'ls-mobile',
        windowWid = jQuery(window).width(),
        lgDevice = 1025,
        mdDevice = 993,
        smDevice = 768;

      // Set Style on each Layer
      respLayer.each(function () {
        var layer = jQuery(this);

        function lsd(data) {
          return (layer.data(data) === '') ? layer.data(null) : layer.data(data);
        }
        // var respStyle = (windowWid < smDevice) ? ((lsd(lsMobile)) ? lsd(lsMobile) : lsd(lsTablet)) : ((windowWid < mdDevice) ? ((lsd(lsTablet)) ? lsd(lsTablet) : lsd(lsDesktop)) : lsd(lsDesktop)),
        var respStyle = (windowWid < smDevice) ? lsd(lsMobile) : ((windowWid < mdDevice ? lsd(lsTablet) : ((windowWid < lgDevice) ? lsd(lsLaptop) : lsd(lsDesktop)))),
          mainStyle = (layer.attr('style') !== undefined) ? layer.attr('style') : ' ';
        layer.attr('style', mainStyle + respStyle);
      });

    });





    /* Custom Arrow Navigation */
    vsHslide.find('[data-ls-go]').each(function () {
      $(this).on('click', function (e) {
        e.preventDefault();
        var target = $(this).data('ls-go');
        vsHslide.layerSlider(target)
      });
    });

    vsHslide.layerSlider({
      allowRestartOnResize: true,
      globalBGImage: (d('globalbgimage') ? d('globalbgimage') : false),
      maxRatio: (d('maxratio') ? d('maxratio') : 1),
      type: (d('slidertype') ? d('slidertype') : 'responsive'),
      pauseOnHover: (d('pauseonhover') ? true : false),
      navPrevNext: (d('navprevnext') ? true : false),
      hoverPrevNext: (d('hoverprevnext') ? true : false),
      hoverBottomNav: (d('hoverbottomnav') ? true : false),
      navStartStop: (d('navstartstop') ? true : false),
      navButtons: (d('navbuttons') ? true : false),
      loop: ((d('loop') == false) ? false : true),
      autostart: (d('autostart') ? true : false),
      height: (($(window).width() < 767) ? (d('sm-height') ? d('sm-height') : d('height')) : (d('height') ? d('height') : 1080)),
      responsiveUnder: (d('responsiveunder') ? d('responsiveunder') : 1220),
      layersContainer: (d('container') ? d('container') : 1220),
      showCircleTimer: (d('showcircletimer') ? true : false),
      skinsPath: 'layerslider/skins/',
      thumbnailNavigation: ((d('thumbnailnavigation') == false) ? false : true)
    });
  });




  /*---------- 12. Date & Time Picker ----------*/
  // Time And Date Picker
  $('.dateTime-pick').datetimepicker({
    timepicker: true,
    datepicker: true,
    format: 'y-m-d H:i',
    hours12: false,
    step: 30
  });

  // Only Date Picker
  $('.date-pick').datetimepicker({
    timepicker: false,
    datepicker: true,
    format: 'm-d-y',
    step: 10
  });

  // Only Time Picker
  $('.time-pick').datetimepicker({
    datepicker: false,
    timepicker: true,
    format: 'H:i',
    hours12: false,
    step: 10
  });



  /*----------- 13. Magnific Popup ----------*/
  /* magnificPopup img view */
  $('.popup-image').magnificPopup({
    type: 'image',
    gallery: {
      enabled: true
    }
  });

  /* magnificPopup video view */
  $('.popup-video').magnificPopup({
    type: 'iframe'
  });

  
  
  /*----------- 14. Woocommerce Toggle ----------*/
  // Ship To Different Address
  $('#ship-to-different-address-checkbox').on('change', function () {
    if ($(this).is(':checked')) {
      $('#ship-to-different-address').next('.shipping_address').slideDown();
    } else {
      $('#ship-to-different-address').next('.shipping_address').slideUp();
    }
  });

  // Login Toggle
  $('.woocommerce-form-login-toggle a').on('click', function(e){
    e.preventDefault();
    $('.woocommerce-form-login').slideToggle();
  })
  
  // Coupon Toggle
  $('.woocommerce-form-coupon-toggle a').on('click', function (e) {
    e.preventDefault();
    $('.woocommerce-form-coupon').slideToggle();
  })
  
  // Woocommerce Shipping Method
  $('.shipping-calculator-button').on('click', function(e){
    e.preventDefault();
    $(this).next('.shipping-calculator-form').slideToggle();
  })
  
  // Woocommerce Payment Toggle
  $('.wc_payment_methods input[type="radio"]:checked').siblings('.payment_box').show();  
  $('.wc_payment_methods input[type="radio"]').each(function(){
    $(this).on('change', function () {
      $('.payment_box').slideUp();
      $(this).siblings('.payment_box').slideDown();
    })
  })
  
  // Woocommerce Rating Toggle
  $('.rating-select .stars a').each(function(){
    $(this).on('click', function(e){
      e.preventDefault();
      $(this).siblings().removeClass('active');
      $(this).parent().parent().addClass('selected');
      $(this).addClass('active');
    });
  })


  
  
  /*----------- 15. Filter Active ----------*/
  $('.filter-active').imagesLoaded(function () {
    var $filter = '.filter-active',
      $filterItem = '.grid-item',
      $filterMenu = '.filter-menu-active';  

    if ($($filter).length > 0) {
      var $grid = $($filter).isotope({
        itemSelector: $filterItem,
        filter: '*',
        masonry: {
          // use outer width of grid-sizer for columnWidth
          columnWidth: $filterItem
        }
      });
    }

    if ($($filterMenu).length > 0) {
      // filter items on button click
      $($filterMenu).on('click', 'button', function () {
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({
          filter: filterValue
        });
      });

      // Menu Active Class 
      $($filterMenu).on('click', 'button', function (event) {
        event.preventDefault();
        $(this).addClass('active');
        $(this).siblings('.active').removeClass('active');
      });
    };
  });

  $('.filter-active2').imagesLoaded(function () {
    var $filter = '.filter-active2',
      $filterItem = '.grid-item';  
    if ($($filter).length > 0) {
      $($filter).isotope({
        itemSelector: $filterItem,
        filter: '*',
        masonry: {
          // use outer width of grid-sizer for columnWidth
          columnWidth: 1
        }
      });
    }
  });



  /*----------- 16. Range Slider ----------*/
  $("#slider-range").slider({
    range: true,
    min: 40,
    max: 300,
    values: [60, 570],
    slide: function (event, ui) {
      $("#minAmount").text("$" + ui.values[0]);
      $("#maxAmount").text("$" + ui.values[1]);
    }
  });
  $("#minAmount").text("$" + $("#slider-range").slider("values", 0));
  $("#maxAmount").text("$" + $("#slider-range").slider("values", 1));



  /*---------- 17. Quantity Added ----------*/
  $('.quantity-plus').each(function () {
    $(this).on('click', function (e) {
      e.preventDefault();
      var $qty = $(this).siblings(".qty-input");
      var currentVal = parseInt($qty.val());
      if (!isNaN(currentVal)) {
        $qty.val(currentVal + 1);
      }
    })
  });
  
  $('.quantity-minus').each(function () {
    $(this).on('click', function (e) {
      e.preventDefault();
      var $qty = $(this).siblings(".qty-input");
      var currentVal = parseInt($qty.val());
      if (!isNaN(currentVal) && currentVal > 1) {
        $qty.val(currentVal - 1);
      }
    });
  })
  
  
  
  
  /*---------- 18. Offer Count Down ----------*/
  $.fn.countdown = function (){
    $(this).each(function(){
      var $counter = $(this),
      countDownDate = new Date($counter.data('offer-date')).getTime(), // Set the date we're counting down to
      dateWrapper = '<span class="number"></span>', // Wrapper Where Date Will Be Print
      exprireCls = 'expired';

      // Finding Function
      function s$(element) {
        return $counter.find(element);  
      }      

      // Prepend The Wrapper 
      s$('.day').prepend(dateWrapper);
      s$('.hour').prepend(dateWrapper);
      s$('.minute').prepend(dateWrapper);
      s$('.second').prepend(dateWrapper);
    
      // Update the count down every 1 second
      var counter = setInterval(function () {    
        // Get today's date and time
        var now = new Date().getTime();
    
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
    
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Check If value is lower than ten, so add zero before number
        days < 10 ? days = '0' + days : null;
        hours < 10 ? hours = '0' + hours : null;
        minutes < 10 ? minutes = '0' + minutes : null;
        seconds < 10 ? seconds = '0' + seconds : null;
    
        // If the count down is over, write some text 
        if (distance < 0) {
          clearInterval(counter);
          $counter.addClass(exprireCls);
          $counter.find('.message').css('display', 'block');
        } else {
          // Output the result in elements
          s$('.day .number').html(days + ' ')
          s$('.hour .number').html(hours + ' ')
          s$('.minute .number').html(minutes + ' ')
          s$('.second .number').html(seconds + ' ')
        }
      }, 1000);
    })
  }

  if ($('.flash-counter').length) {
    $('.flash-counter').countdown()
  }

  if ($('.deal-counter').length) {
    $('.deal-counter').countdown()
  }

  if ($('.offer-counter').length) {
    $('.offer-counter').countdown()
  }


  /*----------- 19. Global Toggle ----------*/
  function toggleGlobal(sBtn, sMenu) {
    sBtn.each(function () {
      $(this).on('click', function (e) {
        e.preventDefault();
        var cBtn = $(this);
        if (cBtn.hasClass('active')) {
          cBtn.removeClass('active').next(sMenu).removeClass('show').slideUp();
        } else {
          cBtn.addClass('active').next(sMenu).addClass('show').slideDown();
        }
      })
    })
  };


  /*----------- 20. Box Nav Toggler ----------*/
  $.fn.boxNav = function (btn, subParent, subMenu){
    var $nav = $(this),
    $btn = $(btn),
    $childBtn = $nav.find(subParent);
    // Window Size Check
    if ($(window).width() < 1199.99) { 
      toggleGlobal($btn, $nav);
      toggleGlobal($childBtn, subMenu);
    }
  };

  if ($('.vs-box-nav').length > 0) {
    $('.vs-box-nav').boxNav('.box-nav-btn', '.menu-item-has-children > a', 'ul');
  }


  /*----------- 21. WOW Js (Scroll Animation) ----------*/
  new WOW().init();
  

  /*----------- 22. Tooltip Active ----------*/
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })



  /*----------- 23. Slider Tab ----------*/
  $.fn.vsTab = function (options) {
    var opt = $.extend({
      sliderTab: false,
      tabButton: 'button'
    }, options);

    $(this).each(function () {
      var $menu = $(this);
      var $button = $menu.find(opt.tabButton);

      // Append indicator
      $menu.append('<span class="indicator"></span>');
      var $line = $menu.find('.indicator');

      // On Click Button Class Remove and indecator postion set
      $button.on('click', function (e) {
        e.preventDefault();
        var cBtn = $(this);
        cBtn.addClass('active').siblings().removeClass('active');
        if (opt.sliderTab) {
          $(slider).slick('slickGoTo', cBtn.data('slide-go-to'));
        } else {
          linePos();
        }
      })

      // Work With slider
      if (opt.sliderTab) {
        var slider = $menu.data('asnavfor'); // select slider

        // Select All button and set attribute
        var i = 0;
        $button.each(function () {
          var slideBtn = $(this);
          slideBtn.attr('data-slide-go-to', i)
          i++

          // Active Slide On load > Actived Button
          if (slideBtn.hasClass('active')) {
            $(slider).slick('slickGoTo', slideBtn.data('slide-go-to'));
          }

          // Change Indicator On slide Change
          $(slider).on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            $menu.find(opt.tabButton + '[data-slide-go-to="' + nextSlide + '"]').addClass('active').siblings().removeClass('active');
            linePos();
          });
        })

      };

      // Indicator Position
      function linePos() {
        var $btnActive = $menu.find(opt.tabButton + '.active'),
          $height = $btnActive.css('height'),
          $width = $btnActive.css('width'),
          $top = $btnActive.position().top + 'px',
          $left = $btnActive.position().left + 'px';

        $line.get(0).style.setProperty('--height-set', $height);
        $line.get(0).style.setProperty('--width-set', $width);
        $line.get(0).style.setProperty('--pos-y', $top);
        $line.get(0).style.setProperty('--pos-x', $left);

        if ($($button).first().position().left == $btnActive.position().left) {
          $line.addClass('start').removeClass('center').removeClass('end');
        } else if ($($button).last().position().left == $btnActive.position().left) {
          $line.addClass('end').removeClass('center').removeClass('start');
        } else {
          $line.addClass('center').removeClass('start').removeClass('end');
        }
      }
      linePos();
    })
  }

  // Call On Load
  if ($('.testi-slideTab').length) {
    $('.testi-slideTab').vsTab({
      sliderTab: true,
      tabButton: '.tab-btn'
    });
  }

  // Call On Load
  if ($('.vs-slideTab').length) {
    $('.vs-slideTab').vsTab({
      sliderTab: true,
      tabButton: '.tab-btn'
    });
  }

  /*----------- 24. Shape Mockup ----------*/
  $.fn.shapeMockup = function () {
    var $shape = $(this);
    $shape.each(function () {
      var $currentShape = $(this),
        shapeTop = $currentShape.data('top'),
        shapeRight = $currentShape.data('right'),
        shapeBottom = $currentShape.data('bottom'),
        shapeLeft = $currentShape.data('left');
      $currentShape.css({
          top: shapeTop,
          right: shapeRight,
          bottom: shapeBottom,
          left: shapeLeft,
        }).removeAttr('data-top')
        .removeAttr('data-right')
        .removeAttr('data-bottom')
        .removeAttr('data-left')
        .parent().addClass('shape-mockup-wrap');
    });
  };

  if ($('.shape-mockup')) {
    $('.shape-mockup').shapeMockup();
  }



  /*----------- 25. Accordion Style ----------*/
  $('.accordion-button').each(function () {
    $(this).on('click', function () {
      var accordionWrapper = $(this).closest('.accordion-item');
      accordionWrapper.toggleClass('active')
        .siblings().removeClass('active');
    });
  });


  /*----------- 26. Tab Slider Refresh ----------*/
  var tabEl = $('[data-bs-toggle="tab"], [data-bs-toggle="pill"]');
  tabEl.on('shown.bs.tab', function (event) {
    var tabTarget = $(event.target).attr('data-bs-target');
    var slide = $(tabTarget).find('.vs-carousel');
    slide ? slide.slick('refresh') : null;
  })
  

  /*----------- 00. Color Plate ----------*/
  // if ($('.vs-setting-plate').length) {
  //   var colorurl, bgcolor;
  //   $('.vs-setting-plate .color-btn').each(function () {
  //     bgcolor = $(this).attr('data-color');
  //     $(this).css({
  //       'background-color': bgcolor
  //     });
  //     $(this).on('click', function () {
  //       colorurl = $(this).data('url');
  //       $('#themeColor').attr('href', colorurl);
  //       $('body').addClass('plate-color')
  //     })
  //   });

  //   $('.vs-setting-plate .default-color-btn').on('click', function(){
  //     $('#themeColor').attr('href', '#');
  //     $('body').removeClass('plate-color')
  //   })

  //   $('.plateToggle').on("click", function (e) {
  //     e.preventDefault()
  //     $('.vs-setting-plate').toggleClass('open');
  //     return false;
  //   });

  //   var dirHost = $(location).attr('href');
  //   var titleSplit = $('title').html().split('-');
  //   $(window).on('load', function () {
  //     var fileName = dirHost.split("/").pop();
  //     var projectName = $.trim(titleSplit[0].toLowerCase());
  //     $('.direction-btn.ltr').each(function () {
  //       $(this).attr('href', 'https://vecurosoft.com/products/html/' + projectName + '/ltr/' + fileName)
  //     });
  //     $('.direction-btn.rtl').each(function () {
  //       $(this).attr('href', 'https://vecurosoft.com/products/html/' + projectName + '/rtl/' + fileName)
  //     });
  //   });
  // }


  /*----------- 00. Right Click Disable ----------*/
  // window.addEventListener('contextmenu', function (e) {
  //   // do something here... 
  //   e.preventDefault();
  // }, false);


  /*----------- 00. Inspect Element Disable ----------*/
  // document.onkeydown = function (e) {
  //   if (event.keyCode == 123) {
  //     return false;
  //   }
  //   if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
  //     return false;
  //   }
  //   if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
  //     return false;
  //   }
  //   if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
  //     return false;
  //   }
  //   if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
  //     return false;
  //   }
  // }



})(jQuery);