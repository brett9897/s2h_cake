function go_to_clone()
{
	$(document).ready(function(){
		if($('#survey_id').val() != null)
		{
			var label = null;
			if( $('input[type=hidden]#label').length > 0 )
			{
				label = $('input[type=hidden]#label').val();
			}

			var id = $('#survey_id').val();

			location.href = global.base_url + '/admin/surveys/clone/' + id + ((label != null) ? '?label=' + label : '');
		}
	});
}