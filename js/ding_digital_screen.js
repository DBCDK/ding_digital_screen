(function ($) {
  "use strict";

  $(document).ready(function () {
    // When the user scrolls the page, execute myFunction
    window.onscroll = function () { myFunction() };

    function myFunction() {
      var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
      var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      var scrolled = (winScroll / height) * 100;

      $('.dot').removeClass('active');
      if (scrolled < 25) {
        $('.dot--1').addClass('active');
      } else if (scrolled >= 25 && scrolled < 50) {
        $('.dot--2').addClass('active');
      } else if (scrolled >= 50 && scrolled < 75) {
        $('.dot--3').addClass('active');
      } else if (scrolled >= 75) {
        $('.dot--4').addClass('active');
      }
      console.log(scrolled);
    }

    // On change slide event.
    $('.ding-carousel').on('afterChange', function (event, slick, currentSlide) {
      console.log(currentSlide);
      var container = $(this).closest('.digital-sceen-carousel');
      container.find('.horisontal-dot').removeClass('active');
      if (currentSlide < 4) {
        container.find('.horisontal-dot--1').addClass('active');
      } else if (currentSlide >= 4 && currentSlide < 8) {
        container.find('.horisontal-dot--2').addClass('active');
      } else if (currentSlide >= 8 && currentSlide < 12) {
        container.find('.horisontal-dot--3').addClass('active');
      } else if (currentSlide >= 12) {
        container.find('.horisontal-dot--4').addClass('active');
      }
    });

  });
}(jQuery));
