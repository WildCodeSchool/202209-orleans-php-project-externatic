const rangeInput = document.getElementById("search_offer_range")
const rangeDisplay = document.getElementById("range-display")

rangeDisplay.innerText = rangeInput.value
rangeInput.addEventListener('change', e => rangeDisplay.innerText = e.target.value)