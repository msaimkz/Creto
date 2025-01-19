let mainImage = document.querySelector('.Image')
let subImage = document.querySelectorAll('.sub-image')


subImage.forEach(function(img){
    img.addEventListener('click',function(event){
       let lastAcive = document.querySelector('.sub-image.active')
       let newActive =  event.target
       lastAcive.classList.remove('active')
       newActive.classList.add('active')
       mainImage.src = img.src
    })
})