$(document).ready(() => {
    const map = new L.Map('map', {
        preferCanvas: true,
        attributionControl: false
    });

    map.setView(new L.LatLng(40.416784046011976, -3.7037905800784214), 5);

    var localLang = 'es';

    const satelital = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        minZoom: 5,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    const hybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    const streets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    const terrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });


    map.addLayer(streets);

    var baseMaps = {


        "Satelite": satelital,
        "Ciudades": streets,
        "Ciudades Satelite": hybrid,
        "Terreno": terrain

    };

    var control = L.control.layers(baseMaps, null, {
        collapsed: true,
    }).addTo(map);

})