$ ->
	$(document).ready ->
		count = $('.validation_entry').length + 1
		$('#QuestionTypeId').change ->
			performChange()

		performChange = ->
			type = $('#QuestionTypeId > option:selected').text()
			switch type
				when "select", "radio", "checkbox", "selectWithOther", "checkboxWithOther"
					$('#added_options').removeClass 'do_not_show'
				else
					$('#added_options').addClass 'do_not_show'
					$('#added_options').val ''
			return

		$('#validations').on 'click', ->
			if count < 5
				$('#validations_form').dialog 'open'
			else
				$('dialog-error').dialog 'open'
			return

		$('#validations_form').dialog
			autoOpen: false
			modal: true
			buttons:
				"Add validation": ->
					val = $('#validation_id').val()
					text = $('#validation_id > option:selected').text()
					$('#validation_text').append(
						"
							<div class='validation_entry'>
								<input type='hidden' id='validation_#{count}' name='data[Question][validation_#{count}]' value='#{val}' />
								<p><span class='text'>#{text}</span><span class='remove_image'>#{count}</span></p>
							</div>
						"
					)
					count++
					$(@).dialog 'close'

		$('#dialog-error').dialog
			autoOpen: false
			modal: true
			buttons:
				Ok: ->
					$(@).dialog 'close'

		$('#validation_text').on 'click', '.remove_image', ->
			total = $('#validation_text .remove_image').length

			if parseInt($(@).text()) isnt total
				while current.length > 0
					input = current.find 'input[type=hidden]'
					remove_image = input.next().find '.remove_image'
					num = parseInt(remove_image.text()) - 1

					remove_image.text num
					input.attr 'name', "data[Question][validation_#{num}]"
					current = current.next()
				
				$(@).parent().parent().remove()
				count--
			else
				$(@).parent().parent().remove()
				count--