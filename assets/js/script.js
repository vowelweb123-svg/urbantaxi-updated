( function( $ ) {
	'use strict';
  /* ===============================================
    OPEN CLOSE Menu
  ============================================= */

  function urbantaxi_open_menu() {
    jQuery('button.menu-toggle').addClass('close-panal');
    setTimeout(function(){
      jQuery('nav#main-menu').show();
    }, 100);

    return false;
  }
  jQuery( "button.menu-toggle").on("click", urbantaxi_open_menu);

  function urbantaxi_close_menu() {
    jQuery('.close-menu').removeClass('close-panal');
    jQuery('nav#main-menu').hide();
  }

  jQuery( ".close-menu").on("click", urbantaxi_close_menu);


  /* ===============================================
    TRAP TAB FOCUS ON MODAL MENU
  ============================================= */

  jQuery('#main-menu').on('keydown', function (e) {
    var isTab = e.key === 'Tab' || e.keyCode === 9;
    if (!isTab) return;
    var $menu = jQuery(this);
    var $focusable = $menu.find('a[href], button:not(.menu-toggle), input, select, textarea, [tabindex]:not([tabindex="-1"])').filter(':visible');
    if (!$focusable.length) return;
    var first = $focusable.first()[0];
    var last = $focusable.last()[0];
    // Shift+Tab from first moves to last
    if (e.shiftKey && document.activeElement === first) {
      e.preventDefault();
      last.focus();
      return;
    }
    // Tab from last moves to first
    if (!e.shiftKey && document.activeElement === last) {
      e.preventDefault();
      first.focus();
      return;
    }
  });


  jQuery(document).ready(function() {
    window.addEventListener('load', (event) => {
        jQuery(".loader").delay(2000).fadeOut("slow");
    });

    jQuery(window).scroll(function(){
      var sticky = jQuery('.sticky-header'),
      scroll = jQuery(window).scrollTop();
      if (scroll >= 100) sticky.addClass('fixed-header');
      else sticky.removeClass('fixed-header');
    });
  })
    
  /* ===============================================
    Scroll Top //
  ============================================= */

  jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 100) {
        jQuery('.scroll-up').fadeIn();
    } else {
        jQuery('.scroll-up').fadeOut();
    }
  });

  jQuery('body').on('click', 'a[href="#tobottom"]', function () {
    jQuery('html, body').animate({scrollTop: 0}, 'slow');
    return false;
  });

  /* ===============================================
    Custom Cursor
  ============================================= */

  const urbantaxi_customCursor = {
    init: function () {
      this.urbantaxi_customCursor();
    },
    isVariableDefined: function (el) {
      return typeof el !== "undefined" && el !== null;
    },
    select: function (selectors) {
      return document.querySelector(selectors);
    },
    selectAll: function (selectors) {
      return document.querySelectorAll(selectors);
    },
    urbantaxi_customCursor: function () {
      const urbantaxi_cursorDot = this.select(".cursor-point");
      const urbantaxi_cursorOutline = this.select(".cursor-point-outline");
      if (this.isVariableDefined(urbantaxi_cursorDot) && this.isVariableDefined(urbantaxi_cursorOutline)) {
        const cursor = {
          delay: 8,
          _x: 0,
          _y: 0,
          endX: window.innerWidth / 2,
          endY: window.innerHeight / 2,
          cursorVisible: true,
          cursorEnlarged: false,
          $dot: urbantaxi_cursorDot,
          $outline: urbantaxi_cursorOutline,

          init: function () {
            this.dotSize = this.$dot.offsetWidth;
            this.outlineSize = this.$outline.offsetWidth;
            this.setupEventListeners();
            this.animateDotOutline();
          },

          updateCursor: function (e) {
            this.cursorVisible = true;
            this.toggleCursorVisibility();
            this.endX = e.clientX;
            this.endY = e.clientY;
            this.$dot.style.top = `${this.endY}px`;
            this.$dot.style.left = `${this.endX}px`;
          },

          setupEventListeners: function () {
            window.addEventListener("load", () => {
              this.cursorEnlarged = false;
              this.toggleCursorSize();
            });

            urbantaxi_customCursor.selectAll("a, button").forEach((el) => {
              el.addEventListener("mouseover", () => {
                this.cursorEnlarged = true;
                this.toggleCursorSize();
              });
              el.addEventListener("mouseout", () => {
                this.cursorEnlarged = false;
                this.toggleCursorSize();
              });
            });

            document.addEventListener("mousedown", () => {
              this.cursorEnlarged = true;
              this.toggleCursorSize();
            });
            document.addEventListener("mouseup", () => {
              this.cursorEnlarged = false;
              this.toggleCursorSize();
            });

            document.addEventListener("mousemove", (e) => {
              this.updateCursor(e);
            });

            document.addEventListener("mouseenter", () => {
              this.cursorVisible = true;
              this.toggleCursorVisibility();
              this.$dot.style.opacity = 1;
              this.$outline.style.opacity = 1;
            });

            document.addEventListener("mouseleave", () => {
              this.cursorVisible = false;
              this.toggleCursorVisibility();
              this.$dot.style.opacity = 0;
              this.$outline.style.opacity = 0;
            });
          },

          animateDotOutline: function () {
            this._x += (this.endX - this._x) / this.delay;
            this._y += (this.endY - this._y) / this.delay;
            this.$outline.style.top = `${this._y}px`;
            this.$outline.style.left = `${this._x}px`;

            requestAnimationFrame(this.animateDotOutline.bind(this));
          },

          toggleCursorSize: function () {
            if (this.cursorEnlarged) {
              this.$dot.style.transform = "translate(-50%, -50%) scale(0.75)";
              this.$outline.style.transform = "translate(-50%, -50%) scale(1.6)";
            } else {
              this.$dot.style.transform = "translate(-50%, -50%) scale(1)";
              this.$outline.style.transform = "translate(-50%, -50%) scale(1)";
            }
          },

          toggleCursorVisibility: function () {
            if (this.cursorVisible) {
              this.$dot.style.opacity = 1;
              this.$outline.style.opacity = 1;
            } else {
              this.$dot.style.opacity = 0;
              this.$outline.style.opacity = 0;
            }
          },
        };
        cursor.init();
      }
    },
  };
  urbantaxi_customCursor.init();

  /* ===============================================
    Progress Bar
  ============================================= */
  const urbantaxi_progressBar = {
    init: function () {
        let urbantaxi_progressBarDiv = document.getElementById("elemento-progress-bar");

        if (urbantaxi_progressBarDiv) {
            let urbantaxi_body = document.body;
            let urbantaxi_rootElement = document.documentElement;

            window.addEventListener("scroll", function (event) {
                let urbantaxi_winScroll = urbantaxi_body.scrollTop || urbantaxi_rootElement.scrollTop;
                let urbantaxi_height =
                urbantaxi_rootElement.scrollHeight - urbantaxi_rootElement.clientHeight;
                let urbantaxi_scrolled = (urbantaxi_winScroll / urbantaxi_height) * 100;
                urbantaxi_progressBarDiv.style.width = urbantaxi_scrolled + "%";
            });
        }
    },
  };
  urbantaxi_progressBar.init();

})(jQuery);