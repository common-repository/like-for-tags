jQuery(document).ready(function () {
	function update_preview() {
		layout_style = jQuery('select[name="ingboo-facebook-like[layout_style]"]').val();
		show_faces = jQuery('input[name="ingboo-facebook-like[show_faces]"]:checked').val();
		width = jQuery('input[name="ingboo-facebook-like[width]"]').val();
		height = jQuery('input[name="ingboo-facebook-like[height]"]').val();
		verb = jQuery('select[name="ingboo-facebook-like[verb]"]').val();
		font = jQuery('select[name="ingboo-facebook-like[font]"]').val();
		color_scheme = jQuery('select[name="ingboo-facebook-like[color_scheme]"]').val();
 		use_iframe=jQuery('input[name="ingboo-facebook-like[useIframe]"]:checked').val();
        if (height==null || heigth=="") {
            if (layout_style=="box_count") {
                height="65";
            } else if (layout_style=="button_count") {
                height="21";
            } else if (show_faces=='yes') {
                height="80";
            } else {
                height="35";
            }
        }
		preview_html = '<h3>Preview</h3>';
		if (use_iframe=='yes') {
		    wd30=30+width;
		    preview_html +='<div style="background-color: rgb(255, 255, 255); width: '+wd30+'; border: 1px solid rgb(202, 211, 230);">';
		    preview_html +='<div style="padding: 0px 3px 2px 0px; background: url(/ad-bgd-top-03.png) no-repeat scroll right center transparent; font-family: Lucida Grande,sans-serif; font-size: 10px; color: rgb(255, 255, 255); font-weight: bold; line-height: 12px; text-align: right;">follow on facebook</div>';
		    preview_html +='<div style="width: '+width+'px; padding-top: 5px; padding-bottom: 10px; padding-left: 10px;">';
		    preview_html +='<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.ingboo.com%2Fpvm%2Fplugin&amp;layout=' + layout_style + '&amp;show_faces=' + show_faces + '&amp;width=' + width + '&amp;action=' + verb + '&amp;font=' + font + '&amp;colorscheme=' + color_scheme + '" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:' + width + 'px; height:'+height+'px"></iframe>';
		    preview_html +='</div><div style="padding-left: 4px; background: url(/ad-bgd-011.png) no-repeat scroll right center rgb(235, 237, 244); font-family: Lucida Grande,sans-serif; font-size: 12px; border-top: 1px solid rgb(202, 211, 230); line-height: 14px;">';
		    preview_html +='<a class="spLink" href="#" style="color: rgb(59, 89, 152);  font-weight: bold;text-decoration: none;" rel="nofollow" target="_blank" title="Description of Ad">Ad text goes here</a></div></div>';
		} else {
		    preview_html += '<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.ingboo.com%2Fpvm%2Fplugin&amp;layout=' + layout_style + '&amp;show_faces=' + show_faces + '&amp;width=' + width + '&amp;action=' + verb + '&amp;font=' + font + '&amp;colorscheme=' + color_scheme + '" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:' + width + 'px; height:'+height+'px"></iframe>';
		}
		jQuery('#ingboo_facebook_like_preview').html(preview_html); 
	}
	
	jQuery('.ingboo_facebook_like_settings form input, .ingboo_facebook_like_settings form select').change(function () {
		update_preview();
	});
	
	jQuery('input[name="ingboo-facebook-like[width]"]').keyup(function () {
		update_preview();												
	});
	
	update_preview();
});