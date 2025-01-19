let filterButton = document.querySelector("#Toggle-Filter")
let shopLeftSide = document.querySelector(".shop-left-site")



filterButton.addEventListener('click',function(){
    shopLeftSide.classList.toggle('show')
})
