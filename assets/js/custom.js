(function ($) {
  'use strict';

  /* =========================
   * Urbantaxi Loader
   * ========================= */

  let urbantaxi_interval = null;

  function urbantaxi_show_loading_box() {
    $('.loader').css('display', 'none');
    clearInterval(urbantaxi_interval);
  }

  $(document).ready(function () {

    const $urbantaxi_toggle = $('#urbantaxi-hamburger-menu');
    const $urbantaxi_canvas = $('.urbantaxi-canvas-menu-content');
    const $urbantaxi_close  = $('#urbantaxi-close-icon');

    /* =========================
     * Accessibility – Initial State
     * ========================= */

    $urbantaxi_toggle.attr({
      'aria-expanded': 'false',
      'aria-controls': 'urbantaxi-canvas-menu'
    });

    $urbantaxi_canvas.attr({
      'aria-hidden': 'true'
    });

    // Set tabindex to -1 for all focusable elements initially
    $urbantaxi_canvas.find('a, input, button, [tabindex]').attr('tabindex', '-1');

    /* =========================
     * Open Canvas Menu
     * ========================= */

    $urbantaxi_toggle.on('click', function () {
      $urbantaxi_canvas.addClass('hamburger-active');
      $urbantaxi_toggle.addClass('hamburger-active-content');

      $urbantaxi_toggle.attr('aria-expanded', 'true');
      $urbantaxi_canvas.attr('aria-hidden', 'false');

      // Set tabindex to 0 to make elements focusable
      $urbantaxi_canvas.find('a, input, button, [tabindex="-1"]').attr('tabindex', '0');

      // Focus first focusable element
      const $focusable = $urbantaxi_canvas.find('a, button, input, [tabindex]:not([tabindex="-1"])');
      $focusable.first().focus();

      // Trap focus inside canvas
      $urbantaxi_canvas.on('keydown.trapFocus', function (e) {
        if (e.key !== 'Tab') return;

        const focusableElements = $urbantaxi_canvas.find('a, button, input, [tabindex]:not([tabindex="-1"])').toArray();
        const firstEl = focusableElements[0];
        const lastEl = focusableElements[focusableElements.length - 1];

        if (e.shiftKey) { // Shift + Tab
          if (document.activeElement === firstEl) {
            e.preventDefault();
            lastEl.focus();
          }
        } else { // Tab
          if (document.activeElement === lastEl) {
            e.preventDefault();
            firstEl.focus();
          }
        }
      });
    });

    /* =========================
     * Close Canvas Menu
     * ========================= */

    function urbantaxi_close_canvas() {
      $urbantaxi_canvas.removeClass('hamburger-active');
      $urbantaxi_toggle.removeClass('hamburger-active-content');

      $urbantaxi_toggle.attr('aria-expanded', 'false');
      $urbantaxi_canvas.attr('aria-hidden', 'true');

      // Set tabindex to -1 to make elements unfocusable
      $urbantaxi_canvas.find('a, input, button, [tabindex]').attr('tabindex', '-1');

      // Remove focus trap
      $urbantaxi_canvas.off('keydown.trapFocus');

      // Return focus
      $urbantaxi_toggle.focus();
    }

    $urbantaxi_close.on('click', urbantaxi_close_canvas);

    $(document).on('keydown', function (e) {
      if (e.key === 'Escape' && $urbantaxi_canvas.hasClass('hamburger-active')) {
        urbantaxi_close_canvas();
      }
    });

    /* =========================
     * Loader Timeout
     * ========================= */

    urbantaxi_interval = setInterval(urbantaxi_show_loading_box, 3000);

    /* =========================
     * Scroll Events
     * ========================= */

    $(window).on('scroll', function () {
      const scrollTop = $(this).scrollTop();

      $('#urbantaxi-header-section-box')
        .toggleClass('urbantaxi-stickynavbar', scrollTop > 1);

      $('#urbantaxi-return-to-top')
        .toggle(scrollTop >= 150);
    });

    $('#urbantaxi-return-to-top').on('click', function () {
      $('body, html').animate({ scrollTop: 0 }, 100);
    });

    /* =========================
     * Fallback When WOW.js Is Missing
     * ========================= */

    if (typeof window.WOW === 'undefined') {
      document
        .querySelectorAll('[data-animation]:not([data-animation="none"])')
        .forEach(function (el) {
          el.style.opacity = '1';
          el.style.visibility = 'visible';
        });
    }

    if (typeof window.AOS !== 'undefined' && typeof window.AOS.init === 'function') {
      window.AOS.init();
    }

    /* =========================
     * Submenu Keyboard Accessibility (Tab/Shift+Tab)
     * ========================= */

    const ueMenuRootSelector = '.ue-nav-menu.ue-left-close';
    const ueMenuFocusableSelector = '.ue-menu a, .ue-menu button, .ue-menu input, .ue-menu select, .ue-menu textarea, .ue-menu [tabindex]';

    function getUeMenuBreakpoint($menuRoot) {
      const raw = parseInt($menuRoot.attr('data-breakpoint'), 10);
      return Number.isNaN(raw) ? 991 : raw;
    }

    function isUeMenuMobile($menuRoot) {
      return window.matchMedia('(max-width: ' + getUeMenuBreakpoint($menuRoot) + 'px)').matches;
    }

    function isUeMenuActive($menuRoot) {
      return $menuRoot.hasClass('uc-active') || $menuRoot.find('> .ue-nav-menu-checkbox').is(':checked');
    }

    function setFocusableState($elements, enabled) {
      $elements.each(function () {
        const $el = $(this);

        if (enabled) {
          if ($el.attr('data-urbantaxi-tabindex') !== undefined) {
            const original = $el.attr('data-urbantaxi-tabindex');
            if (original === 'null') {
              $el.removeAttr('tabindex');
            } else {
              $el.attr('tabindex', original);
            }
            $el.removeAttr('data-urbantaxi-tabindex');
          }
          return;
        }

        if ($el.attr('data-urbantaxi-tabindex') === undefined) {
          const current = $el.attr('tabindex');
          $el.attr('data-urbantaxi-tabindex', current !== undefined ? current : 'null');
        }

        $el.attr('tabindex', '-1');
      });
    }

    function syncUeMenuTriggerAccessibility($menuRoot) {
      const $toggle = $menuRoot.find('> .ue-nav-menu-mobile-wrapper .ue-nav-menu-mobile').first();
      const $checkbox = $menuRoot.find('> .ue-nav-menu-checkbox').first();
      const $menu = $menuRoot.find('> .ue-menu').first();

      if (!$toggle.length || !$checkbox.length || !$menu.length) {
        return;
      }

      if (!$menu.attr('id')) {
        const rootId = $menuRoot.attr('id') || 'ue-nav-menu';
        $menu.attr('id', rootId + '-list');
      }

      $toggle.attr({
        'tabindex': '0',
        'role': 'button',
        'aria-controls': $menu.attr('id'),
        'aria-expanded': isUeMenuActive($menuRoot) ? 'true' : 'false'
      });

      // Keep hidden checkbox out of tab order; label handles keyboard interaction.
      $checkbox.attr('tabindex', '-1');
    }

    function syncUeMenuAccessibility($menuRoot) {
      if (!$menuRoot || !$menuRoot.length) {
        return;
      }

      const $menu = $menuRoot.find('> .ue-menu');
      const $focusables = $menuRoot.find(ueMenuFocusableSelector);
      const shouldLock = isUeMenuMobile($menuRoot) && !isUeMenuActive($menuRoot);

      syncUeMenuTriggerAccessibility($menuRoot);
      $menu.attr('aria-hidden', shouldLock ? 'true' : 'false');
      setFocusableState($focusables, !shouldLock);
    }

    function syncAllUeMenusAccessibility() {
      $(ueMenuRootSelector).each(function () {
        syncUeMenuAccessibility($(this));
      });
    }

    function getUeMenuTrapElements($menuRoot) {
      const $toggle = $menuRoot.find('> .ue-nav-menu-mobile-wrapper .ue-nav-menu-mobile').first();
      const $menuItems = $menuRoot
        .find(ueMenuFocusableSelector)
        .filter(':visible')
        .filter(function () {
          return $(this).attr('tabindex') !== '-1';
        });

      return $toggle.add($menuItems);
    }

    function setUeMenuOpenState($menuRoot, isOpen) {
      const $toggle = $menuRoot.find('> .ue-nav-menu-mobile-wrapper .ue-nav-menu-mobile').first();
      const $checkbox = $menuRoot.find('> .ue-nav-menu-checkbox').first();

      if (!$toggle.length || !$checkbox.length) {
        return;
      }

      $checkbox.prop('checked', isOpen);
      $menuRoot.toggleClass('uc-active', isOpen);
      $toggle.toggleClass('uc-active', isOpen);
      $toggle.find('.ue-nav-menu-mobile-icon-open').toggleClass('uc-active', !isOpen);
      $toggle.find('.ue-nav-menu-mobile-icon-close').toggleClass('uc-active', isOpen);

      syncUeMenuAccessibility($menuRoot);
    }

    syncAllUeMenusAccessibility();

    $(document).on('change', ueMenuRootSelector + ' > .ue-nav-menu-checkbox', function () {
      syncUeMenuAccessibility($(this).closest(ueMenuRootSelector));
    });

    $(document).on('click', ueMenuRootSelector + ' .ue-nav-menu-mobile', function () {
      const $menuRoot = $(this).closest(ueMenuRootSelector);
      setTimeout(function () {
        syncUeMenuAccessibility($menuRoot);
      }, 40);
    });

    $(document).on('keydown', ueMenuRootSelector + ' .ue-nav-menu-mobile', function (e) {
      if (e.key !== 'Enter' && e.key !== ' ' && e.key !== 'Spacebar') {
        return;
      }

      e.preventDefault();

      const $menuRoot = $(this).closest(ueMenuRootSelector);
      const shouldOpen = !isUeMenuActive($menuRoot);

      // Toggle only the currently focused menu instance.
      setUeMenuOpenState($menuRoot, shouldOpen);

      if (shouldOpen) {
        const $firstLink = $menuRoot.find('> .ue-menu a:visible').first();
        if ($firstLink.length) {
          $firstLink.focus();
        }
      }
    });

    // Trap keyboard focus within active mobile hamburger menu.
    $(document).on('keydown', ueMenuRootSelector, function (e) {
      if (e.key !== 'Tab') {
        return;
      }

      const $menuRoot = $(this);

      if (!isUeMenuMobile($menuRoot) || !isUeMenuActive($menuRoot) || !$menuRoot.hasClass('uc-active')) {
        return;
      }

      const $trapElements = getUeMenuTrapElements($menuRoot);
      if (!$trapElements.length) {
        return;
      }

      const firstEl = $trapElements.get(0);
      const lastEl = $trapElements.get($trapElements.length - 1);
      const activeEl = document.activeElement;

      if (e.shiftKey) {
        if (activeEl === firstEl) {
          e.preventDefault();
          lastEl.focus();
        }
        return;
      }

      if (activeEl === lastEl) {
        e.preventDefault();
        firstEl.focus();
      }
    });

    $(window).on('resize', syncAllUeMenusAccessibility);

    // Remove active state when tabbing out of submenu
    $(document).on('keydown', ueMenuRootSelector + ' .sub-menu > li:last-child > a', function(e) {
      const $menuRoot = $(this).closest(ueMenuRootSelector);

      if (isUeMenuMobile($menuRoot) && !isUeMenuActive($menuRoot)) {
        return;
      }

      // When active mobile menu is open, focus is trapped in this menu,
      // so we should not collapse submenu on forward tab.
      if (isUeMenuMobile($menuRoot) && isUeMenuActive($menuRoot) && $menuRoot.hasClass('uc-active')) {
        return;
      }

      if (e.key === 'Tab' && !e.shiftKey) {
        // Forward tab from last submenu item - close submenu
        setTimeout(() => {
          const $parentLi = $(this).closest('.menu-item-has-children');
          $parentLi.removeClass('uc-active');
          $parentLi.find('> a').removeClass('uc-active');
        }, 50);
      }
    });

    // Remove active state when focus leaves menu entirely
    $(document).on('focusout', ueMenuRootSelector + ' .ue-menu a', function() {
      const $menuRoot = $(this).closest(ueMenuRootSelector);

      if (isUeMenuMobile($menuRoot) && !isUeMenuActive($menuRoot)) {
        return;
      }

      setTimeout(() => {
        // Check if focus moved outside the menu
        const $focused = $(document.activeElement);
        if (!$focused.closest(ueMenuRootSelector).is($menuRoot)) {
          $menuRoot.find('.menu-item.uc-active').removeClass('uc-active');
          $menuRoot.find('.ue-menu a.uc-active').removeClass('uc-active');
        }
      }, 50);
    });

    /* =========================
     * Swiper Breakpoints Update Function
     * ========================= */

    function updateSwiperBreakpoints(swiper, $carousel) {
      // PowerPack/Elementor settings can exist as parsed data or raw JSON attribute.
      let s = $carousel.data('sliderSettings');
      if (!s) {
        const rawSettings = $carousel.attr('data-slider-settings');
        if (rawSettings) {
          try {
            s = JSON.parse(rawSettings);
          } catch (e) {
            s = {};
          }
        }
      }
      if (!s || typeof s !== 'object') {
        s = {};
      }

      const existing = Object.assign({}, swiper.params.breakpoints || {});

      const mobileSlides = parseInt(s.slides_per_view_mobile ?? 1, 10); // dynamic (320-575)
      const tabletSlides = parseInt(
        s.slides_per_view_tablet ?? existing[768]?.slidesPerView ?? swiper.params.slidesPerView ?? 3,
        10
      ); // dynamic (768+)
      const desktopSlides = parseInt(
        s.slides_per_view ?? existing[1200]?.slidesPerView ?? existing[1024]?.slidesPerView ?? 4,
        10
      ); // dynamic (1200+ optional)

      const mobileSpace  = parseInt(s.space_between_mobile ?? s.space_between ?? 10, 10);
      const tabletSpace  = parseInt(s.space_between_tablet ?? s.space_between ?? 10, 10);
      const desktopSpace = parseInt(s.space_between ?? 20, 10);

      // Remove any leftover breakpoints that fall inside the 576-767 range
      // (for example many page builders emit a 767 breakpoint). If left
      // intact a 767 breakpoint will override the 576 breakpoint at width
      // 767. We only keep our intended 576 breakpoint for that range.
      Object.keys(existing).forEach(function (k) {
        const n = parseInt(k, 10);
        if (!Number.isNaN(n) && n >= 576 && n < 768 && n !== 576) {
          delete existing[k];
        }
      });

      // Ensure breakpoints are evaluated by viewport width.
      // Some builders use container-based breakpoints, which can keep
      // 576+ viewports stuck on 1 slide if container width is smaller.
      swiper.params.breakpointsBase = 'window';
      if (swiper.originalParams) {
        swiper.originalParams.breakpointsBase = 'window';
      }

      swiper.params.breakpoints = {
        ...existing,

        320: { ...(existing[320] || {}), slidesPerView: mobileSlides, spaceBetween: mobileSpace },
        576: { ...(existing[576] || {}), slidesPerView: 2, spaceBetween: mobileSpace },
        767: { ...(existing[767] || {}), slidesPerView: 2, spaceBetween: mobileSpace },
        768: { ...(existing[768] || {}), slidesPerView: tabletSlides, spaceBetween: tabletSpace },

        // optional extra control for large screens (remove if you don’t want)
        1200: { ...(existing[1200] || {}), slidesPerView: desktopSlides, spaceBetween: desktopSpace }
      };

      swiper.update();
      swiper.updateSize();
      swiper.updateSlides();
    }

    function applyBreakpointsToLiveSwipers() {
      let updated = 0;

      $('.swiper, .swiper-container').each(function () {
        const instance = this.swiper;
        if (!instance || !instance.params) return;

        const $el = $(this);
        const $settingsHost = $el.is('[data-slider-settings]')
          ? $el
          : $el.closest('[data-slider-settings]');
        const isTeamCarousel =
          $el.closest('#taxi-our-team-main-section, .taxi-team-carousel-box').length > 0;
        const hasBreakpoints =
          instance.params.breakpoints && Object.keys(instance.params.breakpoints).length > 0;

        const hasSettings =
          typeof $el.data('sliderSettings') !== 'undefined' ||
          typeof $el.attr('data-slider-settings') !== 'undefined' ||
          $settingsHost.length > 0;

        if (!hasSettings && !isTeamCarousel && !hasBreakpoints) return;

        updateSwiperBreakpoints(instance, $settingsHost.length ? $settingsHost : $el);
        updated += 1;
      });

      return updated;
    }

    // Some builders initialize Swiper after document.ready.
    // Retry briefly so breakpoints are applied once instances exist.
    let swiperRetryCount = 0;
    const swiperRetryTimer = setInterval(function () {
      applyBreakpointsToLiveSwipers();
      swiperRetryCount += 1;

      if (swiperRetryCount >= 25) {
        clearInterval(swiperRetryTimer);
      }
    }, 250);

    let swiperResizeTimer = null;
    $(window).on('resize', function () {
      clearTimeout(swiperResizeTimer);
      swiperResizeTimer = setTimeout(function () {
        applyBreakpointsToLiveSwipers();
      }, 150);
    });

    // Make the function globally accessible
    window.updateSwiperBreakpoints = updateSwiperBreakpoints;
    window.applyBreakpointsToLiveSwipers = applyBreakpointsToLiveSwipers;

  });

})(jQuery);

// for about animation 
document.addEventListener("DOMContentLoaded", () => {

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("active");
      }
    });
  }, { threshold: 0.3 });

  /* Add all target classes here */
  document
    .querySelectorAll(
      ".taxi-about-image-after-box, .service-image-after-box"
    )
    .forEach(el => observer.observe(el));

});

// for speed taxi
window.addEventListener("load", function(){

function breakFirstWord(){

    let w = window.innerWidth;

    document.querySelectorAll(
        '.taxi-speed-content-box .elementor-counter-title, .taxi-counter-four-text'
    ).forEach(function(el){

        if(!el.dataset.original){
            el.dataset.original = el.innerHTML;
        }

        let originalHTML = el.dataset.original;
        let text = el.textContent.trim();

        if(w >= 768 && w <= 1024){

            let words = text.split(" ");

            if(words.length > 1){

                // keep span / style / typography
                el.innerHTML =
                    originalHTML.replace(
                        text,
                        words[0] + "<br>" + words.slice(1).join(" ")
                    );

            }

        }else{

            el.innerHTML = originalHTML;

        }

    });

}

setTimeout(breakFirstWord,300);

let resizeTimer;

window.addEventListener("resize", function(){

    clearTimeout(resizeTimer);

    resizeTimer = setTimeout(function(){
        breakFirstWord();
    },200);

});

});

// wave issues
document.addEventListener("DOMContentLoaded", function(){

document.querySelectorAll("a").forEach(function(el){

    // check if link has svg but no text
    if(
        el.querySelector("svg") &&
        el.textContent.trim() === ""
    ){

        if(!el.getAttribute("aria-label")){

            let html = el.innerHTML.toLowerCase();

            let label = "link";

            if(html.includes("twitter")) label = "Twitter";
            else if(html.includes("facebook")) label = "Facebook";
            else if(html.includes("youtube")) label = "YouTube";
            else if(html.includes("instagram")) label = "Instagram";
            else if(html.includes("linkedin")) label = "LinkedIn";
            else if(html.includes("user")) label = "Account";
            else if(html.includes("cart")) label = "Cart";

            el.setAttribute("aria-label", label);
            el.setAttribute("title", label);

        }

    }

});

});

document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".taxi-team-carousel-box .pp-tm-image img").forEach(function (img, index) {

        if (!img.alt || img.alt === "" || img.alt.includes("team-img")) {
            img.alt = "Team member " + (index + 1);
        }
    });
});





// pagination 
function updatePagination() {
    let currentPage = parseInt(jQuery('.page-number.active').data('page'));
    let totalPages = jQuery('.page-number').length;

    // Disable Previous
    if (currentPage === 1) {
        jQuery('.prev-arrow').addClass('disabled');
    } else {
        jQuery('.prev-arrow').removeClass('disabled');
    }

    // Disable Next
    if (currentPage === totalPages) {
        jQuery('.next-arrow').addClass('disabled');
    } else {
        jQuery('.next-arrow').removeClass('disabled');
    }
}

// Run on load
jQuery(window).on('load', function () {
    setTimeout(updatePagination, 300);
});

// Handle clicks (important for dynamic update)
jQuery(document).on('click', '.page-number, .prev-arrow, .next-arrow', function () {
    setTimeout(updatePagination, 150);
});

// pagination end


setTimeout(() => {
  document.querySelectorAll("label.fdColumn").forEach(label => {
    const select = label.querySelector("select");
    if (select) {
      label.setAttribute("for", select.id);
    }
  });
}, 2000);

// for accessebility
document.addEventListener('DOMContentLoaded', function () {

  function updateSwiperAccessibility() {
    document.querySelectorAll('.swiper-slide').forEach(function (slide) {

      const elements = slide.querySelectorAll(
        'a, button, input, textarea, select, iframe, [tabindex]:not([tabindex="-1"])'
      );

      const isHidden = slide.hasAttribute('aria-hidden') &&
        slide.getAttribute('aria-hidden') === 'true';

      if (!isHidden && slide.style.display !== 'none') {
        elements.forEach(function (el) {
          if (el.hasAttribute('data-original-tabindex')) {
            const originalTabindex = el.getAttribute('data-original-tabindex');
            if (originalTabindex === 'null') {
              el.removeAttribute('tabindex');
            } else {
              el.setAttribute('tabindex', originalTabindex);
            }
            el.removeAttribute('data-original-tabindex');
          } else {
            el.removeAttribute('tabindex');
          }
          el.removeAttribute('aria-hidden');
        });
      } else {
        elements.forEach(function (el) {
          if (!el.hasAttribute('data-original-tabindex')) {
            const originalTabindex = el.getAttribute('tabindex');
            el.setAttribute('data-original-tabindex', originalTabindex || 'null');
          }
          el.setAttribute('tabindex', '-1');
          el.setAttribute('aria-hidden', 'true');
        });
      }
    });
  }

  function initSwiperAccessibility() {
    document.querySelectorAll('.swiper').forEach(function (swiperContainer) {
      const swiperInstance = swiperContainer.swiper;

      if (swiperInstance) {
        swiperInstance.on('slideChange', function () {
          setTimeout(updateSwiperAccessibility, 50);
        });
      }
    });
  }

  setTimeout(function () {
    updateSwiperAccessibility();
    initSwiperAccessibility();
  }, 100);

  window.addEventListener('load', function () {
    setTimeout(updateSwiperAccessibility, 200);
  });
});

// accessibility end


// form dropdown accessibility start 
document.addEventListener('DOMContentLoaded', function () {

    function makeDropdownItemsAccessible() {

        document.querySelectorAll('.mp_input_select_list li').forEach(function (item) {

            item.setAttribute('tabindex', '0');
            item.setAttribute('role', 'option');

            if (!item.hasAttribute('data-keyboard-bound')) {

                item.setAttribute('data-keyboard-bound', 'true');

                item.addEventListener('keydown', function (e) {

                    if (e.key === 'Enter' || e.key === ' ') {

                        e.preventDefault();

                        item.click();

                    }

                });

            }

        });

    }

    makeDropdownItemsAccessible();

    document.addEventListener('click', function () {
        setTimeout(makeDropdownItemsAccessible, 100);
    });

});

// form dropdown accessibility end