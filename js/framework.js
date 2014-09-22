jQuery(function($) {
    $window = $(window);
    $header = $("#header");
    $footer = $("#footer");
    $back_to_top = $('#back-to-top');
    $page_content_top = $('#page-content-top');
    $dashboard_menu_toggle_button = $("#dashboard-menu-toggle-button");
    $container_sidebar = $(".pop-menu");
    $container_content = $(".pop-content");
    $pop_wrap = $(".pop-wrap");

    $dashboard_menu_toggle_button.bind( "click", function(e) {
        e.preventDefault();

        if ($container_sidebar.length === 0) {
            var $nav = $(".nav-horizontal");

            if ($nav.css("height") === "0px" || !$nav.is(":visible")) {
                $nav.css("height", "auto");
                $nav.fadeIn();
            } else {
                $nav.fadeOut();
            }
        } else {
            $container_sidebar.toggleClass("open");
            $container_content.toggleClass("sidebar-open");
            $footer.toggle();

            if ($container_sidebar.hasClass("open")) {
                // Set the wrapper height to the smaller of window or page height.
                var height_page = $window.height();
                var height_new = (height_page > $container_sidebar.height()) ? height_page : $container_sidebar.height();

                $pop_wrap.css({
                    "height": height_new
                  , "overflow": "hidden"
                }); // wrapper.css
            } else {
                $pop_wrap.css({
                    "height": "auto"
                  , "overflow": "visible"
                }); // wrapper.css
            } // If the sidebar is open
        } // if container_sidebar exists
    }); // dashboard_menu_toggle_button.bind click

    $(document).on("click", "[data-toggle=open]", function(e) {
        e.preventDefault();

        var $that = $(this);
        var $target = $($that.data("target"));

        $target.toggleClass("open");
    }); // data-toggle.click

    // Back-to-top
    $back_to_top.on('click', 'a', function (e) {
        e.preventDefault();
        var $that = $(this);
        var speed = $that.data('speed') || 800;

        $('body, html').animate({
            scrollTop: 0
        }, speed);
    }); // back-to-top anchor click

    $window.on('scroll', function () {
        if ($window.scrollTop() > 100) {
            $back_to_top.fadeIn();
        } else {
            $back_to_top.fadeOut();
        }

        if ($page_content_top.length) {
            if ($window.scrollTop() > $page_content_top.offset().top) {
                $('.sticky-nav').addClass('sticky-nav-on');
            } else {
                $('.sticky-nav').removeClass('sticky-nav-on');
            } // if scroll > element
        } // if page content top
    }); // window.scroll

    $back_to_top.hide();

    // Burger nav
    $(document).on('click', 'li.burger', function(e) {
        e.preventDefault();
        $(this).parent('ul').find('li.nav-hidden').toggleClass('nav-reveal');
    }); // li burger click

    // Slide-to anchors
    $(document).on('click', 'a.slide-to', function(e) {
        e.preventDefault();
        var $that = $(this);
        var speed = $that.data('speed') || 800;

        $('body, html').animate({
            scrollTop: $($that.attr('href')).offset().top
        }, speed);
    }); // click slide-to

    $( document ).on( 'click' , 'html'  , function(e){

        // Close widgets
        $(window.parent.document).find( '.control-panel-content .widget-rendered.expanded' ).removeClass( 'expanded' );

    });

    $('.list-grid').equal_row_height({
            selector: '.column',
            per_row: $(this).data('cols')
    });
}); // document.ready

(function ($) {
    $.fn.equal_row_height = function(options) {
        var settings = $.extend({
            per_row: 3
          , selector: "li"
        }, options);

        var row = [];
        var max_height = 0;

        this.find(settings.selector).each(function() {
            var $that = $(this);
            var oh = $that.outerHeight();
            max_height = (max_height < oh) ? oh : max_height;
            row.push($that);

                // Set all the elements in this row to the max_height
                $.each(row, function(i, e) {
                    e.css({
                        'height': max_height
                    });
                });

                // Reset
                row = [];
                max_height = 0;
        }); // for each item
    }; // equal_row_height
}(jQuery));

