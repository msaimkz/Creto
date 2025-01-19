


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