import L from "leaflet"

const offersData = document.getElementById('map').dataset.offers
const link = document.getElementById('map').dataset.link
const search = document.getElementById('map').dataset.search ?? null
const searchCoords = JSON.parse(search)

const map = L.map('map').setView([46.45, 2.4], 6);

navigator.geolocation.getCurrentPosition(pos => {
    map.setView([pos.coords.latitude, pos.coords.longitude], 9);
})

if (searchCoords["lat"] || searchCoords["lng"]) {
    map.setView([searchCoords["lat"], searchCoords["lng"]], 9);
}

const offers = JSON.parse(offersData)



L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map)

offers.forEach(offer => {
    const marker = L.marker([offer.latitude, offer.longitude]).addTo(map);
    marker.bindPopup(`<a href="${link}/${offer.id}" class="nav-link">${offer.title}</a>`).openPopup();
});