$(document).ready(function (){
	function initialize()
	{
		var type = $('#ViCriteriumType').val();
		if( type == "question" )
		{
			$('#groupings').addClass('doNotShow');
			$('#question').removeClass('doNotShow');
			$('#values_text').addClass('doNotShow');
			$('#ViCriteriumQuestionId').parent().removeClass('doNotShow');
		}
		else if ( type == "age") 
		{
			$('#groupings').addClass('doNotShow');
			$('#question').removeClass('doNotShow');
			$('#values_text').removeClass('doNotShow');
			$('#question_id').parent().addClass('doNotShow');
		}
		else
		{
			$('#question').addClass('doNotShow');
			$('#groupings').removeClass('doNotShow');
		}

		if( $('#ViCriteriumQuestionId').val() != '')
        {
           
			//make ajax call to figure out how values should be displayed
			$.ajax({
				url: global.base_url + "/admin/vi_criteria/get_values/" + $('#ViCriteriumQuestionId').val() + '.json',
				dataType: 'json',
				type: 'GET',
				success: set_up_values
			});

		}

		function set_up_values( data, status, xhr )
		{
			if( data.response.options == 'NULL' )
			{
				$('#values_select').addClass('doNotShow');
				$('#values_text').removeClass('doNotShow');
				$('#value_options').html('');
			}
			else
			{
				$('#values_text').addClass('doNotShow');
				$('#ViCriteriumValues').attr('value', '');
				$('#values_select').removeClass('doNotShow');

				//build select
				console.log(data.response);
				var select = '<select id="value_id">';
				$.each(data.response.options, function(){
					select += '<option>' + this.Option.label + '</option>';
				});
				select +=    '</select>';
				$('#values_form > form > fieldset').append(select);
			}
		}
	}

	//onload make sure everything is rendered correctly.
	initialize();

	$('#values').on('click', function () {
		$('#values_form').dialog( 'open' );
	});

	/* Values add modal */
	$('#values_form').dialog({
		autoOpen: false,
		modal: true,
		buttons: {
			"Add value": function()
			{
				$('#value_options').append(
					'<div class="value_entry">' + 
						'<input type="hidden" name="data[ViCriterium][values_array][]" value="' + $("#value_id").val() + '" />' +
						'<p><span class="text">' + $("#value_id").val() + '</span><span class="remove_image"></span></p>' +
					'</div>'
				);
				$( this ).dialog( 'close' );
			},
			Cancel: function() {
				$( this ).dialog( 'close' );
			}
		}
	});

	/* Value remove */
	$('#value_options').on('click', '.remove_image', function() {
		$(this).parent().parent().remove();
	});

	$('#grouping_add').on('click', function () {
		$('#groupings_form').dialog( 'open' );
	});

	/* Values add modal */
	$('#groupings_form').dialog({
		autoOpen: false,
		width: 600,
		modal: true,
		buttons: {
			"Add value": function()
			{
				$('#grouping_options').append(
					'<div class="groupings_entry">' + 
						'<input type="hidden" name="data[ViCriterium][values_array][]" value="' + $("#grouping_id").val() + '::' + $("#response_value").val() + '" />' +
						'<p><span class="text">' + $("#grouping_id > option:selected").text() + ': ' + $("#response_value").val() + '</span><span class="remove_image"></span></p>' +
					'</div>'
				);
				$( this ).dialog( 'close' );
			},
			Cancel: function() {
				$( this ).dialog( 'close' );
			}
		}
	});

	/* Grouping remove */
	$('#grouping_options').on('click', '.remove_image', function() {
		$(this).parent().parent().remove();
	});
});