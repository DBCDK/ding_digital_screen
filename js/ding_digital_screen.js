(function ($) {
  "use strict";

  $(document).ready(function () {
   
    $('.digital-screen-popup').toggle(false);
    $('.digital-screen-popup-close').toggle(false);

    $('.digital-screen-object-help img').click(function () {
      $('.digital-screen-object-help img').toggle(false);
      $('.digital-screen-popup').toggle(true);
      $('.digital-screen-popup-close').toggle(true);
    });

    $('.digital-screen-popup-close').click(function () {
      $('.digital-screen-object-help img').toggle(true);
      $('.digital-screen-popup').toggle(false);
      $('.digital-screen-popup-close').toggle(false);
    });

  });
}(jQuery));
