
	$('.iframe-btn').fancybox({
	 'width'     : 900,
	 'height'    : 600,
	 'type'      : 'iframe',
	 'autoScale' : false
 	});


	function responsive_filemanager_callback(field_id){
		console.log(field_id);
		var image = $('#' + field_id).val();
		$('#'+"prev"+field_id).attr('src', image);
		$('#fancybox-wrap').hide(750);
		$('#fancybox-overlay').hide(750);
	};
