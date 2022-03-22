jQuery('ul.nav > li').hover(function() {
    jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
}, function() {
    jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
})