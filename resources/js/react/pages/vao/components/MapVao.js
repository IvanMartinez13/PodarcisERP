import React from "react";

import axios from "axios";

class MapVao extends React.Component{

    constructor(props)
    {
        super(props)
        this.location = this.props.location;
        this.vao_token = this.props.vao_token;
        this.layers = [];
        this.state = {loading: true}
    }


    render(){
        if (this.state.loading) {
            return(
                <div className="text-center">
                    <div className="spiner-example">
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>

                    Cargando...
                </div>
            ) 
        }
        return(
            <div id="map" style={{height: '97%', width: '100%', minHeight: '500px'}}></div>
        )
    }

    componentDidMount(){

        //GET LAYERS

        axios.post('/vao/get_layers', {token: this.vao_token}).then( (response) => {

            this.layers = response.data.layers;

            this.setState( { loading: false } )

            
        } ).then( () => {

            var map = L.map('map', {
                preferCanvas: true // recommended when loading large layers.
            });

            let location  = this.location.split(',')
            map.setView(new L.LatLng(location[0], location[1]), 16);

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
        
        
        
            map.addLayer(satelital);

            var baseMaps = {

                "Satelite": satelital,
                "Ciudades": streets,
                "Ciudades Satelite": hybrid,
                "Terreno": terrain
        
            };
        
            var control = L.control.groupedLayers(baseMaps, null, {
                collapsed: true,
            }).addTo(map);

            map.addControl(new L.Control.Fullscreen());


            const handleAddKmz = (name, group , path, map, control) => { this.addKmz(name, group , path, map, control); }

            // Add remote KMZ files as layers (NB if they are 3rd-party servers, they MUST have CORS enabled)
            this.layers.map( (layer) => {

                if (layer.type == 'kml') {

                    handleAddKmz(layer.name, layer.group.name, '/storage'+layer.path, map, control);
                }

                if (layer.type == 'shape') {

                    var shpfile = new L.Shapefile('http://programa_objetivos.test/storage'+layer.path, {
                        onEachFeature: function(feature, layer) {
                            if (feature.properties) {
                                layer.bindPopup(Object.keys(feature.properties).map(function(k) {
                                    if(k === '__color__'){
                                        return;
                                    }
                                    return k + ": " + feature.properties[k];
                                }).join("<br />"), {
                                    maxHeight: 200
                                });
                            }
                        },
                        style: function(feature) {
                            if (feature.properties.__color__) {
                                return {
                                    opacity: 1,
                                    fillOpacity: 0.7,
                                    radius: 6,
                                    color: feature.properties.__color__
                                }
                            }else{

                                const randomColor = Math.floor(Math.random()*16777215).toString(16);

                                return {
                                    opacity: 1,
                                    fillOpacity: 0.7,
                                    radius: 6,
                                    color: '#'+randomColor
                                }
                            }
                            
                        },
                        pointToLayer: function(feature, latlng) {

                            if (feature.properties.__color__) {


                                return L.circleMarker(latlng, {
                                    opacity: 1,
                                    fillOpacity: 0.7,
                                    color: feature.properties.__color__
                                });
                            }else{

                                const randomColor = Math.floor(Math.random()*16777215).toString(16);
                                
                                return L.circleMarker(latlng, {
                                    opacity: 1,
                                    fillOpacity: 0.7,
                                    color: '#'+randomColor
                                });
                            }

                           

                        }
                    });

                    shpfile.addTo(map);

                    shpfile.once("data:loaded", function() {
                        
                        map.fitBounds(shpfile.getBounds());
                        
                    });

                    

                    control.addOverlay(shpfile, layer.name, layer.group.name)
                }
                
            } )
            




        } );


    }


    addKmz(name, group , path, map, control)
    {
        // Instantiate KMZ layer (async)
        var kmz = L.kmzLayer().addTo(map);

        kmz.on('load', function(e) {
            control.addOverlay(e.layer, name, group);
            map.fitBounds(kmz.getBounds()); //ZOOM TO LAYER
            // e.layer.addTo(map);
        });

        kmz.load(path);
    }



 
        
    
}

export default MapVao;