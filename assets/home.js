const slideLeft = document.getElementById('slide-left')
const slideRight = document.getElementById('slide-right')
const slider = document.getElementById('sponsors-wrapper')

slideRight.addEventListener('click', e => {
    slider.scrollLeft += 200;
})
slideLeft.addEventListener('click', e => {
    slider.scrollLeft -= 200;
})