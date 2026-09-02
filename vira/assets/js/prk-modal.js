class PrkModal {
  static stackLevel = 999; // شروع از 999 برای اولین مودال

  static init() {
    // اتصال دکمه‌های بازکننده مودال
    document.querySelectorAll('[data-modal]').forEach(trigger => {
      trigger.addEventListener('click', () => {
        const modalId = trigger.getAttribute('data-modal');
        const modal = document.getElementById(modalId);
        if (modal) PrkModal.open(modal);
      });
    });

    // اتصال دکمه‌های بستن مودال
    document.querySelectorAll('[data-modal-close]').forEach(btn => {
      btn.addEventListener('click', () => {
        const overlay = btn.closest('.prk-modal-overlay');
        if (overlay) PrkModal.closeOverlay(overlay);
      });
    });

    // محاسبه و ست‌کردن vh واقعی
    PrkModal.setRealVhUnit();
    window.addEventListener('resize', PrkModal.setRealVhUnit);
    window.addEventListener('orientationchange', PrkModal.setRealVhUnit);
  }

  static setRealVhUnit() {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
  }

  static setModalOptions(id, options = {}) {
    const modal = document.getElementById(id);
    if (!modal) return;
    Object.entries(options).forEach(([key, value]) => {
      modal.dataset[key] = value;
    });
  }

  static openById(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    PrkModal.open(modal);
  }

  static closeById(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    const overlay = modal.parentElement;

    PrkModal.closeOverlay(overlay);
  }

  static open(modal, options = {}) {
    const overlay = modal.parentElement;
    overlay.style.display = '';

    const customZIndex = modal.dataset.zIndex;

    if (customZIndex) {
      overlay.style.zIndex = customZIndex;
      modal.style.zIndex = parseInt(customZIndex) + 1;
    } else {
      overlay.style.zIndex = PrkModal.stackLevel++;
      modal.style.zIndex = PrkModal.stackLevel++;
    }


    // جبران اسکرول‌بار
    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
    if (scrollbarWidth > 0) {

      const wpadminbar = document.getElementById('wp-admin-bar-wp-logo');
      const adminmenuwrap = document.getElementById('adminmenuwrap');
      const wpcontent = document.getElementById('wpcontent');
      if (wpadminbar) {
        wpadminbar.style.paddingRight = `${scrollbarWidth}px`;
      } else {
        document.body.style.paddingRight = `${scrollbarWidth}px`;
      }
      if (adminmenuwrap) {
        adminmenuwrap.style.paddingRight = `${scrollbarWidth}px`;
      }
      if (wpcontent) {
        wpcontent.style.paddingRight = `${scrollbarWidth + 20}px`;
      }
    }

    document.documentElement.classList.add('modal-is-locked');
    overlay.classList.add('visible');
    modal.classList.add('show');

    const isMobile = window.innerWidth < 1024;

    const get = (key, fallback = null) => options[key] ?? modal.dataset[key] ?? fallback;

    let animationType = get('animationType');
    const enableMobileBottomSheet = get('enableMobileBottomSheet') === 'true';
    const mobileBottomSheetHeightMode = get('mobileBottomSheetHeightMode');

    if (options && Object.keys(options).length) {
      modal.dataset.animationType = animationType;
      modal.dataset.enableMobileBottomSheet = enableMobileBottomSheet;
      modal.dataset.mobileBottomSheetHeightMode = mobileBottomSheetHeightMode;
    }

    if (!animationType) {
      animationType = 'zoom-blur';
      modal.dataset.animationType = 'zoom-blur';
    }


    if (
      (animationType && !enableMobileBottomSheet) ||
      (animationType && enableMobileBottomSheet && !isMobile)
    ) {
      overlay.classList.add('animation');
      if (animationType === 'slide-3d-in-bottom') {
        overlay.classList.add('animation-duration02');
      }
      modal.classList.add('modal-is-opening');
      overlay.classList.add('modal-is-opening');

      modal.addEventListener('animationend', function handler() {
        modal.classList.remove('modal-is-opening');
        overlay.classList.remove('modal-is-opening');
        modal.removeEventListener('animationend', handler);
      });
    }

    // موبایل: رفع مشکل نوار آدرس
    setTimeout(() => {
      if (isMobile && enableMobileBottomSheet) {
        const height = modal.offsetHeight;
        const vh = window.innerHeight;

        if (mobileBottomSheetHeightMode === 'half') {
          if (height >= vh * 0.9) {
            modal.style.setProperty('--prk-overlay-radius', '0px');
            modal.style.height = 'calc(var(--vh) * 100)';
          } else {
            modal.style.setProperty('--prk-overlay-radius', '12px');
            modal.style.removeProperty('height');
          }
        } else if (mobileBottomSheetHeightMode === 'full') {
          modal.style.setProperty('--prk-overlay-radius', '0px');
          modal.style.height = 'calc(var(--vh) * 100)';
        }
      }
    }, 10);
  }

  static closeOverlay(overlay) {
    const modal = overlay.querySelector('.prk-modal');

    const isMobile = window.innerWidth < 1024;

    const animationType = modal.dataset.animationType;
    const enableMobileBottomSheet = modal.dataset.enableMobileBottomSheet === 'true';

    if (
      (animationType && !enableMobileBottomSheet) ||
      (animationType && enableMobileBottomSheet && !isMobile)
    ) {
      modal.classList.add('modal-is-closing');
      overlay.classList.add('modal-is-closing');

      modal.addEventListener('animationend', function handler() {
        modal.classList.remove('modal-is-closing');
        overlay.classList.remove('modal-is-closing');
        modal.classList.remove('show');
        overlay.classList.remove('visible');
        modal.removeEventListener('animationend', handler);

        overlay.style.display = 'none';
        PrkModal.resetBodyLockIfNoModalsOpen();
      });
    } else {
      // بدون انیمیشن
      modal.classList.remove('show');
      overlay.classList.remove('visible');
      setTimeout(() => {
        overlay.style.display = 'none';
        PrkModal.resetBodyLockIfNoModalsOpen();
      }, 300);
    }
  }

  static resetBodyLockIfNoModalsOpen() {
    const openModals = document.querySelectorAll('.prk-modal-overlay.visible');
    if (openModals.length === 0) {
      const wpadminbar = document.getElementById('wp-admin-bar-wp-logo');
      const adminmenuwrap = document.getElementById('adminmenuwrap');
      const wpcontent = document.getElementById('wpcontent');
      if (wpcontent) {
        wpcontent.style.paddingRight = '20px';
      }
      if (adminmenuwrap) {
        adminmenuwrap.style.paddingRight = '';
      } else {
        document.body.style.paddingRight = '';
      }
      if (wpadminbar) {
        wpadminbar.style.paddingRight = '';
      }
      document.documentElement.classList.remove('modal-is-locked');
      PrkModal.stackLevel = 999; // ریست z-index
    }
  }
}

// اجرای اولیه و انتقال مودال‌ها به آخر body
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.prk-modal').forEach(modal => {
    const overlay = document.createElement('div');

    const bg = modal.dataset.overlayBackground;
    if (bg) {
      overlay.style.backgroundColor = bg;
    }

    const blur = modal.dataset.overlayBlur;
    if (blur) {
      overlay.style.backdropFilter = `blur(${blur})`;
      overlay.style.webkitBackdropFilter = `blur(${blur})`; // برای سافاری
    }

    overlay.className = 'prk-modal-overlay';
    overlay.style.display = 'none';
    // overlay.appendChild(modal);
    // document.body.appendChild(overlay);

    const appendToBody = modal.dataset.appendToBody !== 'false';
    if (appendToBody) {
      overlay.appendChild(modal);
      document.body.appendChild(overlay);
    } else {
      modal.replaceWith(overlay);
      overlay.appendChild(modal);
    }

    const isRequired = modal.dataset.required === 'true';

    // کلیک روی پس‌زمینه
    overlay.addEventListener('click', e => {
      if (e.target === overlay) {
        const overlayClose = modal.dataset.overlayClose !== 'false';

        if (!overlayClose) return;

        if (isRequired) {
          modal.classList.add('required-shake');
          if (navigator.vibrate) navigator.vibrate(100);
          modal.addEventListener(
            'animationend',
            () => {
              modal.classList.remove('required-shake');
            },
            { once: true }
          );
        } else {
          PrkModal.closeOverlay(overlay);
        }
      }
    });
  });

  // بستن با ESC
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      const overlays = Array.from(document.querySelectorAll('.prk-modal-overlay.visible')).reverse();
      const lastOverlay = overlays.find(ov => ov.querySelector('.prk-modal.show'));
      if (lastOverlay) {
        const modal = lastOverlay.querySelector('.prk-modal');
        const isRequired = modal.dataset.required === 'true';
        const escClose = modal.dataset.escClose !== 'false';

        if (!escClose) return;

        if (isRequired) {
          modal.classList.add('required-shake');
          modal.addEventListener(
            'animationend',
            () => {
              modal.classList.remove('required-shake');
            },
            { once: true }
          );
        } else {
          PrkModal.closeOverlay(lastOverlay);
        }
        // بعد از بسته شدن، فوکوس رو از activeElement بگیر
        if (document.activeElement instanceof HTMLElement) {
          document.activeElement.blur();
        }
      }
    }
  });

  PrkModal.init();
});



// documentation


// document.querySelectorAll('.prk-modal').forEach(modal => {
//   PrkModal.setModalOptions(modal.id, {
//     animationType: 'zoom-blur', // 'zoom-blur', 'slide-top', 'slide-bottom', 'slide-left', 'slide-right', "zoom-in-center", "slide-3d-in-bottom"
//     enableMobileBottomSheet: 'true',
//     mobileBottomSheetHeightMode: 'half', // 'half' or 'full'
//     // required: 'true',
//     // overlayClose: 'false',
//     // escClose: 'false',
//   });
// });

// PrkModal.setModalOptions("price_report_modal", {
//   animationType: "slide-3d-in-bottom",
//   // animationType: "zoom-in-center",
//   enableMobileBottomSheet: "true",
// });

// PrkModal.setModalOptions("feedback_modal", {
//   animationType: "zoom-blur",
//   enableMobileBottomSheet: "true",
// });




// فیچره‌های مودال
// data-animation-type="zoom-blur", "slide-top", "slide-bottom", "slide-left", "slide-right", "zoom-in-center", "slide-3d-in-bottom"
// data-enable-mobile-bottom-sheet="true"
// data-mobile-bottom-sheet-height-mode="half", "full"
// data-required="true"
// data-overlay-close="false"
// data-esc-close="false"
// data-overlay-background="rgba(0,0,0,0.4)", "یا هر کد رنگی دیگر"
// data-z-index="999999"
// data-overlay-blur="5px"

// دکمه  بستن مودال
// data-modal-close

// دکمه باز کردن مودال
// data-modal="modal-id"
