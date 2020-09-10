/**
* This file contains the jquery for the actual menu
*/
jQuery(function($) {

    "use strict";

     	var $win = $(window);
	    var $doc = $(document);
	    
    
    // -----------------search box-----------------
    var $search_box = $('.search-box');
    var $search_input = $('.search-input');
    if ($search_box.length) {
        $search_box.on('click', function() {
            $search_input.toggleClass('search-block')
        });
    }

    // -----------------hamburger-----------------
    var $menu_box = $('.menu-box');
    var $nav = $('nav');
    $menu_box.on('click', function() {
        $(this).toggleClass('clicked')
        $nav.toggleClass('nav_on')
    });
    $(".btnc").on("click", function () {
        $(".main-navigation").removeClass("nav_on");
        $(".menu-box").removeClass("clicked");
    });

    $('.menu-item-has-children .sub-menu').before('<span class="dropdown-toggle"><strong class="dropdown-icon"></strong>');
    $('.dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass('toggle-on');
        $(this).next('.sub-menu').slideToggle();
    });
   
    // -----------------fixed-----------------
    $doc.scroll(function() {
        var $fixed_nav = $(".fixed-nav");
        var st = $(this).scrollTop();
        if (st > 0) {
            // alert("");
            $fixed_nav.addClass('scroll-background');
        } else {
            $fixed_nav.removeClass('scroll-background');
        }
    });



});