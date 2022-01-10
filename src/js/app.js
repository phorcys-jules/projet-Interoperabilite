mapboxgl.accessToken = 'pk.eyJ1IjoicGhvcmN5cy1qdWxlcyIsImEiOiJja3k4bnhsN2wxZmtqMnZveWRoMTNieWFnIn0.NJPsNkYoDfVjAh11iCqEUQ';
let map = new mapboxgl.Map({
container: 'map', // container ID
style: 'mapbox://styles/mapbox/streets-v11', // style URL
center: [-74.5, 40], // starting position [lng, lat]
zoom: 9 // starting zoom
});

map.transform.center.lat = 0;
map.transform.center.lng = 0;


console.log(map.transform.center);
/*
var map = L.map('map').setView([51.505, -0.09], 13);

//TODO En récupérant par API, en JSON, les coordonnées de la mairie de Notre Dame des Landes
L.tileLayer('https://api.mapbox.com/styles/v1/phorcys-jules/cky8nz6fv738s15nuwlk0h79n.html?title=view&access_token=pk.eyJ1IjoicGhvcmN5cy1qdWxlcyIsImEiOiJja3k4bnU5cjUwMWk5MnZsYmp1am5pem04In0.LTlGjtYT-0MdURTgGk9fDA&zoomwheel=true&fresh=true#12/48.8665/2.3176', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoicGhvcmN5cy1qdWxlcyIsImEiOiJja3k4bnhsN2wxZmtqMnZveWRoMTNieWFnIn0.NJPsNkYoDfVjAh11iCqEUQ'
}).addTo(map);

*/