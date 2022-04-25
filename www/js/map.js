//Display map with api leaflet

let map = L.map("map").setView([48.72964, 1.37987], 9);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);

L.marker([48.72964, 1.37987]).addTo(map).bindPopup("La P'tite boutique informatique.").openPopup();

let circle = L.circle([48.72964, 1.37987], {
  color: "blue",
  fillOpacity: 0.2,
  radius: 20000,
}).addTo(map);
