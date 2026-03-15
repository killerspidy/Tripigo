$(window).on('scroll', function () {
  var scrollValue = $(window).scrollTop();
  var header = $('.header_menu');

  // Sticky Header Class
  if (scrollValue > 50) {
    header.addClass('navbar-sticky-in');
  } else {
    header.removeClass('navbar-sticky-in');
  }
});

"use strict";

/*======== Document Ready Function =========*/
jQuery(document).ready(function () {
  // slicknav
  $('#responsive-menu').slicknav({
    duration: 500,
    easingOpen: 'easeInExpo',
    easingClose: 'easeOutExpo',
    closedSymbol: '<i class="fa fa-plus"></i>',
    openedSymbol: '<i class="fa fa-minus"></i>',
    prependTo: '#slicknav-mobile',
    allowParentLinks: true,
    label: ""
  });

  // Dropdown hover effect
  var selected = $('#navbar li');
  selected.on("mouseenter", function () {
    $(this).find('ul').first().stop(true, true).delay(350).slideDown(500, 'easeInOutQuad');
  });

  selected.on("mouseleave", function () {
    $(this).find('ul').first().stop(true, true).delay(100).slideUp(150, 'easeInOutQuad');
  });

  if ($(window).width() > 992) {
    $(".navbar-arrow ul ul > li").has("ul").children("a").append("<i class='arrow-indicator fa fa-angle-right'></i>");
  }
});
