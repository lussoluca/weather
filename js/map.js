(function ($) {
  Drupal.behaviors.weather = {
    attach: function (context, settings) {
      const map_div = document.querySelector("#map");
      const lat = map_div.dataset.lat;
      const lng = map_div.dataset.lng;

      let map = L.map('map').setView([lat, lng], 12);
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
      }).addTo(map);
    }
  };
}(jQuery));
