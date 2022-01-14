let map;
//Affiche la carte centré sur la position en paramètre
function afficherMap(lat, long) {
  console.log("display the map...");

  mapboxgl.accessToken = 'pk.eyJ1IjoicGhvcmN5cy1qdWxlcyIsImEiOiJja3k4bnhsN2wxZmtqMnZveWRoMTNieWFnIn0.NJPsNkYoDfVjAh11iCqEUQ';
  map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/mapbox/streets-v11', // style URL
    center: [long, lat], // starting position [lng, lat]
    zoom: 8 // starting zoom
  });
}

function createPoint(lat, long, p_titre, p_descritpion) {
  //console.log("place point...", lat, long, p_titre, p_descritpion);

  const geojson = {
    type: 'FeatureCollection',
    features: [{
      type: 'Feature',
      geometry: {
        type: 'Point',
        coordinates: [long, lat]
      },
      properties: {
        title: p_titre,
        description: p_descritpion
      }
    }]
  };

  // add markers to map
  for (const feature of geojson.features) {
    // create a HTML element for each feature
    const el = document.createElement('div');
    el.className = 'marker';

    // make a marker for each feature and add to the map
    new mapboxgl.Marker(el).setLngLat(feature.geometry.coordinates).addTo(map);
  }
}


let labels = [];
let datas = [];
let datas2 = [];

function configChart(param) {
  param.forEach(function(item){
    //date
    labels.push(item[0]);
    //taux inci
    datas.push(item[1]);
    //nb cas >0
    datas2.push(item[2]);

  });
}

