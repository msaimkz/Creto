let valueDisplays = document.querySelectorAll(".num");
let interval = 3000;

valueDisplays.forEach((valueDisplay) => {
    let startValue = 0;
    let endValue = parseInt(valueDisplay.getAttribute("data-val"));
    let duration = Math.floor(interval / endValue);
    let counter = setInterval(function () {
        if (endValue > 0) {
            startValue += 1;
            valueDisplay.textContent = startValue;
        }

        if (startValue == endValue || endValue == 0) {
            clearInterval(counter);
        }
    }, duration);
});

var swiper = new Swiper(".mySwier", {
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    slidesPerView: 3,
    spaceBetween: 30,
    pagination: {
        el: "#Blog-pag",
        clickable: true,
    },
    breakpoints: {
        1200: {  // For screens up to 1020px wide
            slidesPerView: 3,
            spaceBetween: 30,
        },
        1020: {  // For screens up to 1020px wide
            slidesPerView: 2,
            spaceBetween: 40,
        },
        990: {  // For screens up to 768px wide
            slidesPerView: 2,
            spaceBetween: 30,
        },
        768: {  // For screens up to 768px wide
            slidesPerView: 2,
            spaceBetween: 20,
        },
        250: {  // For screens up to 768px wide
            slidesPerView: 1,
            spaceBetween: 20,
        }
    }
});;