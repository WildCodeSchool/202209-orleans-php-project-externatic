import L from "leaflet"

const latitude = document.getElementById('map').dataset.latitude
const longitude = document.getElementById('map').dataset.longitude

const map = L.map('map').setView([latitude, longitude], 13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map)

const marker = L.marker([latitude, longitude]).addTo(map);