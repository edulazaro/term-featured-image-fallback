
// Color picker
jQuery(document).ready(function($){
    $('.cs-input-color').wpColorPicker();

});

// Messages
jQuery(document).ready( function() {
	jQuery('.cs__message').delay(3000).fadeOut('slow');
});

// Post boxes
jQuery(document).ready( function() { jQuery('.postbox h3').prepend('<a class="togbox">+</a> '); jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); }); });