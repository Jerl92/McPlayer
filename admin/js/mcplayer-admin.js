var $j = jQuery.noConflict();

jQuery(document).ready(function() {
	$j('ul li #_btn').click(function() {
		$j('.wp-editor-area').val($j('.wp-editor-area').val()+$j(this).attr('value')+', '); 
	});	
});

jQuery(document).ready(function() {
	jQuery('#artistoptions').change(function() {
		var custombrand = jQuery('#artistoptions').val();
		if ( custombrand == '0') {
			jQuery('#custommodeloptions').html('');
			jQuery('#modelcontainer').css('display', 'none');
		} else {
			jQuery('#ctd-custom-taxonomy-terms-loading').css('display', 'inline');
			jQuery('#modelcontainer').css('display', 'none');
			var data = {
				'action':'get_brand_models',
				'custombrand':custombrand,
				'dropdown-artist-nonce': jQuery('#dropdown-artist-nonce').val()
			};
			jQuery.post(ajaxurl, data, function(response){
				jQuery('#custommodeloptions').html(response);
				jQuery('#ctd-custom-taxonomy-terms-loading').css('display', 'none');
				jQuery('#modelcontainer').css('display', 'inline');
			});
		}
	});
	jQuery('#genreoptions').change(function() {
		var custombrand = jQuery('#genreoptions').val();
		if ( custombrand == '0') {
			jQuery('#custommodeloptions').html('');
			jQuery('#modelcontainer').css('display', 'none');
		} else {
			jQuery('#ctd-custom-taxonomy-terms-loading').css('display', 'inline');
			jQuery('#modelcontainer').css('display', 'none');
			var data = {
				'action':'get_brand_models',
				'custombrand':custombrand,
				'dropdown-genre-nonce': jQuery('#dropdown-genre-nonce').val()
			};
			jQuery.post(ajaxurl, data, function(response){
				jQuery('#custommodeloptions').html(response);
				jQuery('#ctd-custom-taxonomy-terms-loading').css('display', 'none');
				jQuery('#modelcontainer').css('display', 'inline');
			});
		}
	});
});