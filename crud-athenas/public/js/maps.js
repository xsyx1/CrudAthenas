// Traduz as informações
L.drawLocal.draw.toolbar.undo.text = "Deletar último ponto";
L.drawLocal.draw.toolbar.actions.text = "Cancelar";
L.drawLocal.draw.handlers.polygon.tooltip.start =
    "Clique para começar a desenhar a área.";
L.drawLocal.draw.handlers.polygon.tooltip.cont =
    "Clique para continuar a desenhar a área.";
L.drawLocal.draw.handlers.polygon.tooltip.end =
    "Clique no primeiro ponto para fechar esta área.";
L.drawLocal.edit.toolbar.actions.cancel.text = "Cancelar";
L.drawLocal.edit.toolbar.actions.save.text = "Salvar";
L.drawLocal.edit.handlers.remove.tooltip.text = "Clique na área para remover";

var input_coordinates = document.getElementById("coordinates");

var latitude = -10.1835604;
var longitude = -48.3337793;

// center of the map
var center = [latitude, longitude];

// Create the map
var map = L.map("map").setView(center, 13);

// Set up the OSM layer
L.tileLayer("http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}", {
    attribution:
        '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 18,
    subdomains: ["mt0", "mt1", "mt2", "mt3"],
}).addTo(map);

// FeatureGroup is to store editable layers
var drawnItems = new L.FeatureGroup();

map.addLayer(drawnItems);

var drawControl = new L.Control.Draw({
    position: "topright",
    draw: {
        marker: false,
        circle: false,
        polyline: false,
        rectangle: false,
        polygon: {
            allowIntersection: false,
            shapeOptions: {
                color: "#bada55",
            },
        },
    },
    edit: {
        featureGroup: drawnItems,
        edit: false,
    },
});

map.addControl(drawControl);

if (input_coordinates.value) {
    var parsedJson = JSON.parse(input_coordinates.value);

    var geoJSON = L.geoJson(parsedJson, {
        onEachFeature: onEachFeature,
    });

    map.fitBounds(geoJSON.getBounds());
}

map.on("draw:created", function (e) {
    var type = e.layerType,
        layer = e.layer;

    var shape = layer.toGeoJSON();
    var shape_for_db = JSON.stringify(shape);

    input_coordinates.value = shape_for_db;

    drawnItems.addLayer(layer);
    // Do whatever else you need to. (save to db; add to map etc)
    map.addLayer(layer);

    var button_draw = document.querySelector(".leaflet-draw-draw-polygon");

    button_draw.style.display = "none";
});

map.on("draw:deleted", function (e) {
    var button_draw = document.querySelector(".leaflet-draw-draw-polygon");

    button_draw.style.display = "block";

    input_coordinates.value = "";
});

// window.map = map;
// window.drawnItems = drawnItems;

function onEachFeature(feature, layer) {
    drawnItems.addLayer(layer);
}
