$(document).ready(function (){
	$('#QuestionTypeId').change(function () {
		var type = $('#QuestionTypeId > option:selected').text();
		if( type == "select" )
		{
			$('#QuestionTypeId').parent().after(
				'<div id="added_options" class="input text required">' +
					'<label for="options">Options</label>' +
					'<input type="text" size="40" name="data[Question][options]/>' +
					'<span class="help">Comma separate all of the options you want.</span>' +
				'</div>'
			);
		}
	});
});