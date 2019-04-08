// Cookies
function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else var expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}
function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}
function deleteCookie(name) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

// defer images
function init() {
var imgDefer = document.getElementsByTagName('img');
for (var i=0; i<imgDefer.length; i++) {
if(imgDefer[i].getAttribute('data-src')) {
imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
} } }
window.onload = init;


$(document).ready(function() {

  var body = $('body'), html = $('html');

  // all variables involving width
  var boxPaddingSize;
  if (window.innerWidth > 767) {
    boxPaddingSize = 80;
  } else {
    boxPaddingSize = 30;
  }


  // unfortunate bug fix for Safari mobile, but can be applied everywhere as it doesn't hurt
  var windowW = window.innerWidth;
  $('.header').css('width', windowW);
  $(window).resize(function() {
    windowW = window.innerWidth;
    $('.header').css('width', windowW);
  });

  // image placement
  $('.placement').isotope({
    itemSelector: '.placement__item',
    percentPosition: true,
    layoutMode: 'packery',
    packery: {
      columnWidth: 1
    }
  });

  if ($('.current-menu-item').length) {
    $('.current-menu-item').parents('.sub-menu')
      .css('display', 'block')
      .css('height', 'auto');
  }

  // PCP grid style
  if ($('.products').length) {
    $('.pcp-grid').addClass('active');
  }
  var gridPreference = readCookie('gridPreference') || false;
  function clearGrid() {
    $('.products span').removeClass('active');
    $('.products')
      .removeClass('products--md')
      .removeClass('products--lg');
  }
  function removeGridPreference() {
    if (gridPreference) {
      deleteCookie('gridPreference');
    }
  }
  $('.pcp-grid__normal').click(function(){
    clearGrid();
    $(this).addClass('active');
    removeGridPreference();
    createCookie('gridPreference', 'products--nm', 30);
  });
  $('.pcp-grid__md').click(function(){
    clearGrid();
    $(this).addClass('active');
    $('.products').addClass('products--md');
    removeGridPreference();
    createCookie('gridPreference', 'products--md', 30);
  });

  // mobile navigation
  $('.menu-btn').click(function() {
    if ($('nav.nav').hasClass('active')) {
      $('nav.nav').removeClass('active');
      html.removeClass('no-scroll');
    } else {
      $('nav.nav').addClass('active');
      html.addClass('no-scroll');
    }
  });

  // cart
  $('.cart-icon').click(function(){
    $('.modal').removeClass('active');
    var cartH = $('.dynamic-cart').height();
    $('.dynamic-cart').css('height', cartH);
    $('.dynamic-cart').draggable();
    if ($('.dynamic-cart').hasClass('active')) {
      $('.dynamic-cart').removeClass('active');
    } else {
      $('.dynamic-cart').addClass('active');
    }
  });

  $('.dynamic-cart__close').click(function(){
    $('.dynamic-cart').removeClass('active');
  });

  // PDP tabs
  $('.product-tabs__headings div').click(function(){
    $('.product-tabs__headings div').removeClass('active');
    $('.product-tabs__tabs div').removeClass('active');
    var tabHeading = $(this).data('tab-heading');
    $(this).addClass('active');
    $('.product-tabs__tabs div[data-tab="'+tabHeading+'"]').addClass('active');
  });

  // swiper
  if ($('.swiper-container').length) {
    var mySwiper = new Swiper('.swiper-container', {
      // loop: true,
      // slidesPerView: 1,
      // loopedSlides: 0
    });

    // PDP pages
    $(document).keydown(function(e){
      if (e.keyCode == 37) {
        mySwiper.slidePrev();
        return false;
      }
      if (e.keyCode == 39) {
        mySwiper.slideNext();
        return false;
      }
    });

    $('.thumbnails img').click(function(){
      var index = $('.thumbnails img').index($(this));
      mySwiper.slideTo(index, 0);
    });

    function closeImageZoom() {
      $('.image-zoom__close').click(function(){
        $('.image-zoom').remove();
        html.removeClass('no-scroll');
        $('.thumbnails').removeClass('zoom');
        $('.images img').removeClass('zoom');
        $('.logo').removeClass('zoom');
      });
    }

    function changeImageZoom() {
      $('.thumbnails.zoom img').click(function(){
        var index = $('.thumbnails img').index($(this));
        mySwiper.slideTo(index, 0);
        var imgSrc = $('.swiper-slide-active img').attr('src');
        $('.image-zoom__wrapper img').attr('src', imgSrc);
        $('.image-zoom__wrapper').animate({ scrollTop: 0 }, 0);
      });
    }

    $('.images img').click(function(){
      var w = $(this).width(),
          h = $(this).height(),
          screenW = window.innerWidth,
          bigSize = (screenW / w) * h;
      if (!$(this).hasClass('zoom') && screenW > 1023) {
        html.addClass('no-scroll');
        var imgSrc = $(this).attr('src');
        $(this).addClass('zoom');
        $('.logo').addClass('zoom');
        $('.thumbnails').addClass('zoom')
        $('body').append('<div class="image-zoom"><div class="image-zoom__close">×</div><div class="image-zoom__wrapper"><img style="height:'+bigSize+'px;" src="'+imgSrc+'"></div></div>');
        closeImageZoom();
        changeImageZoom();
      }
    });

    $(document).keyup(function(e) {
      if (e.keyCode === 27 && $('.thumbnails').hasClass('zoom')) {
        $('.image-zoom').remove();
        html.removeClass('no-scroll');
        $('.thumbnails').removeClass('zoom');
        $('.images img').removeClass('zoom');
        $('.logo').removeClass('zoom');
      }
    });

  }

  // PDP info tabs
  $('.product-info__header div').click(function(){
    var index = $('.product-info__header div').index($(this));
    $('.product-info__header div').removeClass('active');
    $('.product-info__content div').removeClass('active');
    $(this).addClass('active');
    $('.product-info__content div').eq(index).addClass('active');
  });


  // forms
  var customInputs = $('.custom-input--text input, .custom-input--text textarea');
  customInputs.each(function(){
    if ($(this).val()) {
      $(this).addClass('used');
    } else {
      $(this).removeClass('used');
    }
  });
  function fancyFormsInit() {
    customInputs.blur(function() {
      customInputs.each(function(){
        if ($(this).val()) {
          $(this).addClass('used');
        } else {
          $(this).removeClass('used');
        }
      });
    });
  }
  fancyFormsInit();

  // project page
  if ($('.project-banner').length) {
    var img,
        image = $('.project-banner img');
    if (window.innerWidth > 640) {
      img = image.data('desktop');
    } else {
      img = image.data('mobile');
    }
    image.attr('src', img);
  }

  // Modals
  var follow = $('.modal.flw'),
      newsletter = $('.modal.newsletter');
  $('.flw-btn a').click(function(e) {
    e.preventDefault();
    $('.modal, .dynamic-cart').removeClass('active');
    follow.addClass('active');
    var followHeight = follow.height() + boxPaddingSize;
    follow.css('height', followHeight);
    follow.draggable();
  });
  $('.newsletter-btn a').click(function(e) {
    e.preventDefault();
    $('.modal, .dynamic-cart').removeClass('active');
    newsletter.addClass('active');
    var newsletterHeight = newsletter.height() + boxPaddingSize;
    newsletter.css('height', newsletterHeight);
    newsletter.draggable();
  });
  $('.modal__close').click(function(){
    $('.modal').removeClass('active');
  });

});
