// document.addEventListener("DOMContentLoaded", function () {
//   const button = document.querySelector(".ai-button");
//   const wrapper = document.querySelector(".ai-wrapper");

//   button.addEventListener("click", function (e) {
//     e.stopPropagation();
//     e.preventDefault();

//     // حذف shine-animation از همه دکمه‌ها
//     const allButtons = document.querySelectorAll(".ai-button");
//     allButtons.forEach(btn => btn.classList.remove("shine-animation"));

//     // افزودن کلاس open
//     wrapper.classList.add("open");

//     // حذف overlay قبلی
//     const existingOverlay = document.querySelector(".ai-overlay");
//     if (existingOverlay) existingOverlay.remove();

//     // ساخت overlay
//     const overlay = document.createElement("div");
//     overlay.classList.add("ai-overlay");
//     document.body.appendChild(overlay);

//     // بستن با کلیک روی overlay
//     overlay.addEventListener("click", function () {
//       wrapper.classList.remove("open");
//       overlay.remove();

//       // بازگرداندن shine-animation به دکمه‌ها
//       allButtons.forEach(btn => btn.classList.add("shine-animation"));
//     });

//     // فوکوس روی input داخل #titlewrap
//     const titleInput = document.querySelector("#titlewrap input[type='text']");
//     if (titleInput) {
//       titleInput.focus();
//     }
//   });
// });


document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".ai-button");

  buttons.forEach((button, index) => {
    const wrapper = button.closest(".ai-wrapper");

    button.addEventListener("click", function (e) {
      const titlewrap = document.getElementById("titlewrap");
      e.preventDefault();
      e.stopPropagation();

      // حذف shine-animation از همه دکمه‌ها
      document.querySelectorAll(".ai-button").forEach(btn => {
        btn.classList.remove("shine-animation");
      });

      // افزودن کلاس open به wrapper مربوطه
      wrapper.classList.add("open");

      // حذف overlay قبلی
      document.querySelectorAll(".ai-overlay").forEach(el => el.remove());

      // ساخت overlay
      const overlay = document.createElement("div");
      overlay.classList.add("ai-overlay");
      document.body.appendChild(overlay);

      // بستن با کلیک روی overlay
      overlay.addEventListener("click", function () {
        const isLoading = wrapper.querySelector(".ai-btn.loading");
        if (isLoading) return;


        wrapper.classList.remove("open");
        overlay.remove();

        if (index === 0) {
          titlewrap.style.zIndex = "";
        }

        // بازگرداندن shine-animation به همه دکمه‌ها
        document.querySelectorAll(".ai-button").forEach(btn => {
          btn.classList.add("shine-animation");
        });
      });

      // فوکوس روی input داخل titlewrap (فقط برای بخش عنوان)
      const titleInput = document.querySelector("#titlewrap input[type='text']");
      if (titleInput && index === 0) {
        titlewrap.style.zIndex = "9999";
        titleInput.focus();
      }
    });
  });

  // هندل کلیک روی دکمه‌های هوش مصنوعی داخل ai-box
  const actionButtons = document.querySelectorAll(".ai-btn");
  actionButtons.forEach(btn => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const adminbar = document.querySelector('#wpadminbar');

      adminbar.classList.add('ai-loading');

      // غیرفعال کردن همه دکمه‌ها
      actionButtons.forEach(b => {
        b.classList.add("disabled");
      });

      // اضافه کردن کلاس loading به دکمه کلیک شده
      this.classList.add("loading");

      // اضافه کردن loading-dots اگر وجود نداشت
      if (!this.querySelector(".loading-dots")) {
        const dots = document.createElement("div");
        dots.className = "loading-dots";
        dots.innerHTML = "<span></span><span></span><span></span>";
        this.appendChild(dots);
      }

      // تست بازگشت به حالت عادی بعد از 5 ثانیه (شبیه‌سازی درخواست)
      setTimeout(() => {
        actionButtons.forEach(b => {
          b.classList.remove("disabled");
          b.classList.remove("loading");
          const ld = b.querySelector(".loading-dots");
          if (ld) ld.remove();
          adminbar.classList.remove('ai-loading');
        });
      }, 5000);
    });
  });

  if (!document.querySelector('#aiLoadingBar')) {
    const loadingBar = document.createElement('div');
    loadingBar.className = 'ai-loading-bar';
    loadingBar.id = 'aiLoadingBar';
    document.body.appendChild(loadingBar);
  }

});



