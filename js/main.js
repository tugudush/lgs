$(document).ready(function() {
    $.fn.viewport_info();
    console.log('viewport size: '+$viewport_size);
    console.log('screen_height: '+$screen_height);
    console.log('avail_height: '+$avail_height);
    console.log('orientation: '+$orientation);
    console.log('device: '+$device);
    
    $.fn.resize_body_size();
    $.fn.vcenter();
    $.fn.dialog_overlay_size();
}); // end of $(document).ready(function()

$(window).resize(function() {    
    $.fn.viewport_info();
    console.log('viewport size changed!');
    console.log('viewport size: '+$viewport_size);
    console.log('orientation: '+$orientation);
    console.log('device: '+$device);
    
    $.fn.resize_body_size();
    $.fn.dialog_overlay_size();
}); // end of $(window).resize(function()

$(window).on('beforeunload', function() {
    //$(window).scrollTop(0);
}); // end of $(window).on('beforeunload', function()

$.fn.viewport_info = function() {    
    var viewport_width, viewport_height, viewport_size, device, orientation;
    
    viewport_width = $(window).width();
    viewport_height = $(window).height();
    viewport_size = viewport_width+' x '+viewport_height;

    $viewport_width = viewport_width;
    $viewport_height = viewport_height;
    $viewport_size = viewport_size;
    
    $screen_height = window.screen.height;
    $avail_height = window.screen.availHeight;

    if (viewport_width < 768) {
        $('body').addClass('mobile');
        device = 'mobile';
    } // end of if (viewport_width < 768)
    else if (viewport_width >= 768 && viewport_width <= 1024) {
        $('body').removeClass('mobile');
        device = 'tablet';
    }
    else {
        device = 'desktop';
    }
    
    $device = device;
    
    if (viewport_width >= viewport_height) {
        orientation = 'landscape';
    }
    else {
        orientation = 'portrait';
    }
    
    $orientation = orientation;    
    
} // end of $.fn.viewport_size = function()

$.fn.resize_body_size = function() {
    $('body').css('min-height', $viewport_height);
} // end of $.fn.resize_body_height = function()

$.fn.vcenter = function() {
    $('.vcenter').parent().css({
        'display': 'table',
        'width': '100%'
    });    
} // end of $.fn.vcenter = function()

$.fn.dialog_overlay_size = function() {
    var header_height = $('#header').css('height');
    header_height = parseFloat(header_height);
    $('.dialog').css('height', $viewport_height - header_height);
}