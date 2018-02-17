// Used for the Farbtastic color picker used on chat settings panels.
(function ($) {
	jQuery(document).ready(function () {
		
		jQuery('input.pickcolor_input').each(function() {
			/* Older Farbtastic color picker */
			var color_val 		= jQuery(this).val();
			if (color_val == '') color_val = "#FFFFFF";
			jQuery(this).css('background-color', color_val);
			
			var input_id		= jQuery(this).attr('id');
			var input_picker	= input_id + '-colorpicker';
			jQuery(this).after('<div id="'+input_picker+'" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>');
			jQuery('#'+input_picker).farbtastic('#'+input_id).hide();
			
			jQuery('#'+input_id).focus(function() {
				jQuery('#'+input_picker).slideDown();
			});

			jQuery('#'+input_id).blur(function() {				
				//console.log('this [%o]', this);
				// Bug in Farbtastic. It will not work on an empty input field. So we have to do this ourselves. 
				if (jQuery(this).val() == '') {
					var background_color = jQuery(this).css('background-color');
					if (background_color != '') {
						var hex_color = rgb2hex(background_color);
						if (hex_color != '') {
							jQuery(this).val(hex_color);
						}
					}
				}
				jQuery('#'+input_picker).slideUp();
			});			
		});
		
		function rgb2hex(rgb) {
			rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
			return "#"+("0" + parseInt(rgb[1],10).toString(16)).slice(-2)+("0" + parseInt(rgb[2],10).toString(16)).slice(-2)+("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
		}
	});
})(jQuery);
