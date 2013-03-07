$(document).ready( function(){
	$('#dialog-confirm').dialog(
	{
		autoOpen: false,
		show: {
			effect: "blind",
			duration: 500
		},
		hide: {
			effect: "explode",
			duration: 1000
		},
		resizable: false,
		height: 200,
		modal: true,
		buttons: 
		{
			Yes: function(){
				var label = $('#SurveyLabel').val().trim();
				location.href = global.base_url + '/admin/surveys/choose' + ((label != null && label != '') ? '?label=' + label : '');
			},
			No: function(){
				$(this).dialog('close');
			}
		}
	});

	$('#dialog-confirm').on('dialogclose', function(){
		$('#SurveyUseExisting').prop('checked', false);
	});

	$('#SurveyUseExisting').on('click', function(){
		if( $(this).prop('checked') == true )
		{
			$('#dialog-confirm').dialog('open');
		}
	});
});