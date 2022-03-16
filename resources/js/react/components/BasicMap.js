import React from "react";
import ReactDOM from "react-dom";
import Map from "@arcgis/core/Map";
import MapView from "@arcgis/core/views/MapView";
import esriConfig from "@arcgis/core/config";

class BasicMap extends React.Component{

    constructor(props)
    {
        super(props)
        this.location = this.props.location
    }

    render()
    {
        return(
            <div id="map" style={{height: '100%', width: '100%'}}></div>
        );

    }

    componentDidMount(){

        esriConfig.apiKey= "AAPK48014d78322c4ee69894306fc11e6c252ILOGfzaSvcEaKZhzjiu2XEmC68VhFu3nOXJ1g76A6N9VkmEqe92k4es-sBosLbz"

        const map = new Map(
            {
                basemap: "satellite" // Basemap layer service
            }
        );

        

        let location  = this.location.split(',')

        const view = new MapView({
            map: map,
            center: [location[1], location[0]  ], // Longitude, latitude
            zoom: 16,
            container: "map", // Div element
        });
    }

}

export default BasicMap;

if (document.getElementsByTagName('basic-map').length >=1) {
    
    let component = document.getElementsByTagName('basic-map')[0];
    let location = JSON.parse(component.getAttribute('location'));
    

    ReactDOM.render(<BasicMap location={location} />, component);
}