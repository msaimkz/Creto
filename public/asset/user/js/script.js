

var swiper = new Swiper(".mySwiper", {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        renderBullet: function(index, className) {
            return '<span class="' + className + '">' + (index + 1) + "</span>";
        },
    },
});

//blog slider


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
});


//countdown timer

var countDownDate = new Date(couponCode).getTime();
var x = setInterval(function() {
    var now = new Date().getTime();
    var distance = countDownDate - now;
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("days").innerHTML = days;
    document.getElementById("hours").innerHTML = hours;
    document.getElementById("minutes").innerHTML = minutes;
    document.getElementById("seconds").innerHTML = seconds;

    if (distance < 0) {
        clearInterval(x);
        document.getElementById("days").innerHTML = "00";
        document.getElementById("hours").innerHTML = "00";
        document.getElementById("minutes").innerHTML = "00";
        document.getElementById("seconds").innerHTML = "00";

    }
}, 1000);
//Top Cards
// shopping cart 




