(function( $ ) {
	"use strict";

	function initStickyAddToCart(){
      var b = jQuery('.single_add_to_cart_button').first(),
          p = jQuery('.pt-fixed-product-wrapper');

      jQuery(window).scroll(isatcScrollHandler);
      isatcScrollHandler();

      function isatcScrollHandler(){
        
      	if (jQuery( window ).width() > 300 ) {
          if(b.length >= 1) {
           if(jQuery(window).scrollTop() > b.offset().top){          
                p.addClass('atdshowed');
                if(jQuery('#footer-wrapper').hasClass('hide-atdshowedfooter') == false) {
                  jQuery('#footer-wrapper').addClass('atdshowedfooter');  
                }
                
                p.fadeIn(200);
            } else{
              if(jQuery('#footer-wrapper').hasClass('hide-atdshowedfooter') == false) {
                jQuery('#footer-wrapper').removeClass('atdshowedfooter');
              }
              
                p.removeClass('atdshowed').fadeOut(200);
            }            
          }
      	}
      }
    }

    $( document ).ready( function() {
    	initStickyAddToCart();
    });	
    
})(jQuery);