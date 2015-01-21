jQuery(document).ready(function() {
	try {

		if (! jQuery('#wpcf7-campaignmonitor-cf-active').is(':checked'))
			jQuery('.campaignmonitor-custom-fields').hide();

		jQuery('#wpcf7-campaignmonitor-cf-active').click(function() {
			if (jQuery('.campaignmonitor-custom-fields').is(':hidden')
			&& jQuery('#wpcf7-campaignmonitor-cf-active').is(':checked')) {
				jQuery('.campaignmonitor-custom-fields').slideDown('fast');
			} else if (jQuery('.campaignmonitor-custom-fields').is(':visible')
			&& jQuery('#wpcf7-campaignmonitor-cf-active').not(':checked')) {
				jQuery('.campaignmonitor-custom-fields').slideUp('fast');
			}
		});

	} catch (e) {
	}
});