$(document).ready(function (){
	$('#QuestionTypeId').change(function () {
		var type = $('#QuestionTypeId > option:selected').text();
		if( type == "select" || type == "radio" )
		{
			$('#QuestionTypeId').parent().after(
				'<div id="added_options" class="input text required">' +
					'<label for="options">Options</label>' +
					'<input type="text" size="40" name="data[Question][options]/>' +
					'<span class="help">Comma separate all of the options you want.</span>' +
				'</div>'
			);
		}
		else
		{
			if( $('#added_options').length > 0 )
			{
				$('#added_options').remove();
			}
		}
	});


	/* Click method for adding a validation */
	var count = 1;
	$('#validations').on('click', function (){
		if( count < 5 )
		{
			$('#validations_form').dialog( 'open' );
		}
		else
		{
			$('#dialog-error').dialog( 'open' );
		}
	});



	/* Validation add modal */
	$('#validations_form').dialog({
		autoOpen: false,
		modal: true,
		buttons: {
			"Add validation": function()
			{
				$('#validation_text').append(
					'<div class="validation_entry">' + 
						'<input type="hidden" id="validation_' + count + '" name="data[Question][validation_' + count + ']" value="' + $("#validation_id").val() + '" />' +
						'<p><span class="text">' + $("#validation_id > option:selected").text() + '</span><span class="remove_image">' + count + '</span></p>' +
					'</div>'
				);
				count++;
				$( this ).dialog( 'close' );
			},
			Cancel: function() {
				$( this ).dialog( 'close' );
			}
		}
	});

	/* Dialog error */
	$('#dialog-error').dialog({
		autoOpen: false,
		modal: true,
		buttons: {
			Ok: function()
			{
				$( this ).dialog( 'close' );
			}
		}
	});

	/* Validation remove */
	$('#validation_text').on('click', '.remove_image', function() {
		var total = $('#validation_text .remove_image').length;


		if( parseInt($(this).text()) != total )
		{
			//need to parse name attribute from remaining validations and subtract one
			var current = $(this).parent().parent().next();
			while( current.length > 0 )
			{
				alert(current.find('input[type=hidden]').attr('name'));
				current = current.next();
			}	
		}
		else
		{
			$(this).parent().parent().remove();
			count--;
		}
	});

});