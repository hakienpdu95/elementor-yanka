/*global jQuery */
(function ($, window, undefined) {
  'use strict';

  $.fn.sameHeight = function (options) {
    var settings = $.extend(
        {
          timer:        undefined,
          delay:        10,
          initialDelay: 10,
          breakpoint:   500,
          minHeight:    0
        }, options),
      $win = $(window),
      $this = $(this);


    function setListener () {
      $win.on('resize.sameheight', function () {
        setHeight();
      });
    }


    function heightReset () {
      $this.css('min-height', '0');
    }


    function _setHeight () {
      var max = settings.minHeight;
      heightReset();

      $.each($this, function () {
        var height = $(this).outerHeight();
        if (height > max) {
          max = height;
        }
      });

      $this.css('min-height', max);
    }


    function setHeight () {
      clearTimeout(settings.timer);

      if ($win.width() >= settings.breakpoint) {
        setTimeout(_setHeight, settings.delay);
      }
      else {
        heightReset();
      }
    }


    // init
    setListener();
    setTimeout(setHeight, settings.initialDelay);

    return this;
  };
})(jQuery, window);
