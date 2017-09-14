(function( $ ) {	
	jQuery(document).ready( function() {
		'use strict'; var cs__image_frame, image_data;
		$(function() {
			if ( undefined !== cs__image_frame ) {
				cs__image_frame.open(); return;
			}			
			$(".cs__imgselect" ).click(function(event) {
				var clickimagen=event.target;
				cs__image_frame = wp.media.frames.cs__image_frame = wp.media({
					title: $(clickimagen).attr("data-title"),               
					multiple: false
				});
				cs__image_frame.on( 'select', function() {
					image_data = cs__image_frame.state().get( 'selection' ).first().toJSON();
					if(image_data['id'] && image_data['url']){
						/*document.getElementById(clickimagen+"_id").value = image_data['id'];*/
						$(clickimagen).parent('div').find('.cs__imgid').val(image_data['id']); //console.log($(clickimagen).parent('div').find('.cs__imgid').val());
						/*document.getElementById(clickimagen+"_img").innerHTML="<img src='"+image_data['url']+"' style='max-width:360px;' >";*/
						$(clickimagen).parent('div').find('.cs__imgdisplay').html("<img src='"+image_data['url']+"' style='max-width:360px;' >");
						/*$('#'+clickimagen+"_del").css('display', 'inline-block');*/
						$(clickimagen).parent('div').find('.cs__imgdel').css('display', 'inline-block');
					}
				});					
				cs__image_frame.open();
			});				
		});
	});
	jQuery(document).on('click', '.cs__imgdel', function(e) {
		$(this).parent('div').find('.cs__imgdisplay').empty();
		$(this).parent('div').find('input[type=text]').val('');
		$(this).css('display', 'none');
	});
})( jQuery );