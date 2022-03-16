
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
    
    /* AÑADIR PIN */
    map.on('click', function(e) {
        var node = document.querySelector('[title=create]');

        if (node != null) {
            node.remove();
        }


        var icon = L.icon({
            iconUrl: '/img/markers/pendiente.png',
            //shadowUrl: 'leaf-shadow.png',
        
            iconSize:     [30, 30], // size of the icon
            shadowSize:   [30, 30], // size of the shadow
            iconAnchor:   [22, 22], // point of the icon which will correspond to marker's location
            shadowAnchor: [4, 62],  // the same for the shadow
            popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });

        var newMarker = new L.marker(e.latlng, { icon: icon,  title: 'create' });

        newMarker.addTo(map)

        var coordinates = e.latlng.lat + ", " + e.latlng.lng;

        $('#coordinates').val(coordinates);

    });


    function addPin(coordinates){
    
        var node = document.querySelector('[title=create]');
    
            if (node != null) {
                node.remove();
            }

            coordinates = coordinates.split(',')
    
            var icon = L.icon({
                iconUrl: '/img/markers/pendiente.png',
                //shadowUrl: 'leaf-shadow.png',
            
                iconSize:     [30, 30], // size of the icon
                shadowSize:   [30, 30], // size of the shadow
                iconAnchor:   [22, 22], // point of the icon which will correspond to marker's location
                shadowAnchor: [4, 62],  // the same for the shadow
                popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
            });
    
            var newMarker = new L.marker(coordinates, { icon: icon,  title: 'create' });
    
            newMarker.addTo(map)
    
            //var coordinates = e.latlng.lat + ", " + e.latlng.lng;
    
    }





