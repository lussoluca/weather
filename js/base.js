(function ($) {
  Drupal.behaviors.weather = {
    attach: function (context, settings) {
      $(once('forecast-element', '.forecast-element__date', context)).on(
        'click',
        () => {
          alert(settings.weather.message);
        }
      );
    }
  };
}(jQuery));
