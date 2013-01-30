$(document).ready(function (){
	$('#QuestionTypeId').change(function () {
		performChange();	
	});

	function performChange()
	{
		var type = $('#QuestionTypeId > option:selected').text();
		if( type == "select" || type == "radio" || type == "checkbox" || type == "selectWithOther")
		{
			$('#added_options').removeClass('do_not_show');
		}
		else
		{
			$('#added_options').addClass('do_not_show');
			$('#added_options > input').val('');
		}
	}

	//onload make sure everything is good.
	performChange();

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
				var input = current.find('input[type=hidden]');
				var remove_image = input.next().find('.remove_image');
				var num = parseInt(remove_image.text()) - 1;

				remove_image.text(num);
				input.attr('name', 'data[Question][validation_' + num + ']');

				current = current.next();
			}

			$(this).parent().parent().remove();
			count--;	
		}
		else
		{
			$(this).parent().parent().remove();
			count--;
		}
	});

});