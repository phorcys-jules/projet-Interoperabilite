function afficherMap(lat, long) {
    console.log("display the map...")
    
    mapboxgl.accessToken = 'pk.eyJ1IjoicGhvcmN5cy1qdWxlcyIsImEiOiJja3k4bnhsN2wxZmtqMnZveWRoMTNieWFnIn0.NJPsNkYoDfVjAh11iCqEUQ';
    let map = new mapboxgl.Map({
        container: 'map', // container ID
        style: 'mapbox://styles/mapbox/streets-v11', // style URL
        center: [lat, long], // starting position [lng, lat]
        zoom: 9 // starting zoom
    });

    map.transform.center.lat = 0;
    map.transform.center.lng = 0;


    console.log(map.transform.center);
}

console.log("app.js");
