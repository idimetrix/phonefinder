import ol from 'openlayers'
import 'cookieconsent'

let osmSource = new ol.source.OSM();
let lon = parseFloat($('.lon').text());
let lat = parseFloat($('.lat').text());
let city = $('.city-exist').text();
let zoom = city == ' - ' ? 5 : (city == '1' ? 5 : 12)


let map = $('#map')
let height = map.parent().css('height')
if (height) {
  map.css("height", Math.round((height).substr(0, height.length - 2) * 0.88) + 'px');
}

$(document).ready(function () {
  let map = new ol.Map({
    layers: [
      new ol.layer.Tile({
        source: osmSource
      })
    ],
    target: 'map',
    controls: ol.control.defaults({
      attributionOptions: ({
        collapsible: false
      })
    }),
    view: new ol.View({
      center: ol.proj.transform(
        [lon, lat], 'EPSG:4326', 'EPSG:3857'),
      zoom: zoom
    })
  })
})
$(document).ready(function () {
    $('.btn-comments').click(function(){
      let commentsOffset = $('#form').offset()
        console.log(commentsOffset.top)
      $('html,body').animate({ scrollTop: commentsOffset.top - 100 }, 400);
    })
})
