const endDate = document.getElementById('experience_endDate')
const currentPosition = document.getElementById('experience_isCurrentPosition')
currentPosition.addEventListener('change', (e) => {
    if (currentPosition.checked) {
        endDate.classList.add('d-none')
    } else {
        endDate.classList.remove('d-none')
    }
})