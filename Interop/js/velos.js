function showMap(data) {
    document.getElementById("ville").innerHTML = data.city;
    const map = L.map('map').setView([data.latitude, data.longitude], 13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiYmxvdDMydSIsImEiOiJja3k4cnVrcjkxaWltMnZvbmd1bXVub3RsIn0.XMezA_gzX2aviabwVXzyvQ'
    }).addTo(map);

    let greenIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
    });

    let marker = L.marker([data.latitude, data.longitude],  {icon: greenIcon}).addTo(map);
    marker.bindPopup("Votre position").openPopup();

    let dispo = JSON.parse(document.getElementById("dispodata").innerHTML);
    let stations = JSON.parse(document.getElementById("stations").innerHTML);

    for (let i = 0; i < stations.marker.length; i++) {
        let lat = stations.marker[i]["@attributes"].lat;
        let long = stations.marker[i]["@attributes"].lng;
        let name = stations.marker[i]["@attributes"].name;
        let markervelo = L.marker([lat, long]).addTo(map);
        markervelo.bindPopup(name + " <br>Nombre de place libre : " + dispo[i].free + " <br> Nombre de vélos dispo : " + dispo[i].available );
    }

}

function sendXhrPromise(UrlSend) {
    return new Promise(function(resolve, reject) {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', UrlSend);
        xhr.responseType = 'json';
        xhr.send();
        xhr.addEventListener('load', function(reponse) {
                                    resolve(reponse.target.response);
                                }
        );
        xhr.addEventListener('error', function(reponse) {
                                    reject('data transfert error :' + reponse);
                                }
        );
    });
}


document.addEventListener('DOMContentLoaded', function() {
    let loc = document.getElementById('loc');
    let urlW = 'https://ipapi.co/' + loc.innerHTML + '/json';
    
    sendXhrPromise(urlW).then(function(data) {
            showMap(data);
        }).catch(function(error){
            console.log(error);
        });
});