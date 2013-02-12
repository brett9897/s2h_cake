$(document).ready(function (){
	$('.active').on('click', function(){
		var id = $(this).attr('id');
		$('.active').each(function(){
			$(this).removeAttr('checked').removeAttr('disabled');
		});

		$(this).prop('checked', true).attr('disabled', 'disabled');

		var postData = {
            'Survey': {
                'id': parseInt(id.substring(id.indexOf('_') + 1)),
                'isActive': true
            }
        };

        $.ajax({
        	url: global.base_url + "/admin/surveys/update_active/",
	        contentType: 'application/json',
	        dataType: 'json',
	        type: 'POST',
	        data: JSON.stringify(postData)
	    });
	})
});