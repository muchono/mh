// Global vars
var $window = $(window);
var $document = $(document);
var $html = $('html');
var $body = $('body');

// Side menu
(function(){
  var sdMenu = $('.js-side-menu');
  var sdMenuBtn = $('.js-side-menu-btn');
  var sdMenuClose = sdMenu.find('.sm-btn');

  sdMenuBtn.on('click', function(e) {
    e.preventDefault();

    sdMenu.toggleClass('side-menu--open');
  });

  sdMenuClose.on('click', function(e) {
    e.preventDefault();

    sdMenu.removeClass('side-menu--open');
  });
})();

// Toggle
(function() {
    $(document).ready(function() {
        var $btn = $('.js-toggle');

        $btn.each(function(index, el) {
          var $this = $(this);
          var toggleClass = $this.data('toggle');

          $this.on('click', function(event) {
            // event.preventDefault();
            $this.toggleClass(toggleClass);
          });
        });
    });
    
    $('#head_offer_close').click(function(e){
        e.preventDefault();
        $.post(WEB_PATH+"site/hide-offer", function( data ) {
            $('.discount-line--add').removeClass('discount-line--add');
            $('.discount-line').hide(200);
        });
    });

    $('.add2cart').click(function(e){
        e.preventDefault();
        addToCart($(this).attr('for'), 1, $(this));
    });
	
    $('.buy-full-btn').click(function(e){
        e.preventDefault();
        addToCart($(this).attr('for'), 1, $(this), function () {
			location.replace(WEB_PATH+"cart/index");
		});
    });
})();



// Carousel
(function() {
  $(document).ready(function() {
    var carousel = $('.js-carousel');

    carousel.each(function() {
      var $this = $(this);

      $this.slick({
        arrows:         $this.data('arrows') ? $this.data('arrows') : false,
        dots:           $this.data('dots') ? $this.data('dots') : false,
        slidesToShow:   $this.data('slides') ? $this.data('slides') : 1,
        adaptiveHeight: $this.data('adaptiveheight') ? $this.data('adaptiveheight') : false,
        infinite:       $this.data('infinite') ? $this.data('infinite') : false,
        fade:           $this.data('fade') ? $this.data('fade') : false,
        speed:          $this.data('speed') ? $this.data('speed') : 800,
        centerMode:     $this.data('centermode') ? $this.data('centermode') : false,
        centerPadding:  $this.data('centerpadding') ? $this.data('centerpadding') : "10%",
        dotsClass:      $this.data('dotsclass') ? $this.data('dotsclass') : 'default-dots',
        focusOnSelect:  $this.data('focusonselect') ? $this.data('focusonselect') : false,
        responsive: [{
          breakpoint: 1200,
          settings: {
            slidesToShow: $this.data('slides') < 2 ? $this.data('slides') : 2
          }
        }, {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            centerPadding: 0
          }
        }],
        customPaging: function(slider, i) {
          return '<span></span>';
        }
      });
    });

    
  });
})();

// Popups
(function(){
    
    $('.aut-popup').on('click', 'a.js-popups', function(){
        initPopUp($(this));
     });
    
    var popupsBtn = $('.js-popups');

    popupsBtn.each(function() {
        initPopUp($(this));
    });
})();

function initPopUp(forit){
    var $this = forit;
    var mainMode = $this.data('popup-mode') ? $this.data('popup-mode') : 'inline';
    var mainClass = $this.data('popup-type') ? $this.data('popup-type') : 'mfp-default';
    var prependTo = $this.data('prependto') ? $this.data('prependto') : 'body';
    var closebtn = $this.data('closebtn') ? $this.data('closebtn') : '<span class="mfp-close"></span>';
    var alignTop = $this.data('aligntop') ? $this.data('aligntop') : false;

    $this.magnificPopup({
        alignTop: alignTop,
        type: mainMode,
        midClick: true,
        overflowY: 'scroll',
        fixedBgPos: false,
        prependTo: $(prependTo),
        closeMarkup: closebtn,
        removalDelay: 500,
        mainClass: mainClass,
        callbacks: {
            open: function() {
                var stickyTopBar = $('.top-bar');
                var scrollBarWidth = window.innerWidth - $body.width();

                $html.addClass('open-mfp');
                // initMap('update');

                if(scrollBarWidth !== 0) {
                    stickyTopBar.css('right', scrollBarWidth);
                }
            },
            close: function() {
                var stickyTopBar = $('.top-bar');

                stickyTopBar.css('right', '');
                $html.removeClass('open-mfp');
                // $this.removeClass('-open');
            }
        }
    });    
};
function addToCart(product_id, months, obj, callback) {
    var data = {'product_id': product_id, 'months': months, 'add_to_cart': 1};
    $.post(WEB_PATH+"cart/add", data, function( res ) {
        if (res.show_signup){
            $('#signup-popup-link').click();
        } else if(res.result){
            updateCount();
            if (typeof callback !== 'undefined') {
                callback();
            } else {
                obj.hide(200);
            }
            
        }
    });
}

function updateCount(){
    $.post(WEB_PATH+"cart/get-count", function( res ) {
        if (res) {
            $('#cart_items').html(res.cart_items_count);
        }
    });   
}