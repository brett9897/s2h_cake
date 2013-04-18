(function() {
  $(function() {
    return $(document).ready(function() {
      var count, performChange;

      count = $('.validation_entry').length + 1;
      $('#QuestionTypeId').change(function() {
        return performChange();
      });
      performChange = function() {
        var type;

        type = $('#QuestionTypeId > option:selected').text();
        switch (type) {
          case "select":
          case "radio":
          case "checkbox":
          case "selectWithOther":
          case "checkboxWithOther":
            $('#added_options').removeClass('do_not_show');
            break;
          default:
            $('#added_options').addClass('do_not_show');
            $('#added_options').val('');
        }
      };
      $('#validations').on('click', function() {
        if (count < 5) {
          $('#validations_form').dialog('open');
        } else {
          $('dialog-error').dialog('open');
        }
      });
      $('#validations_form').dialog({
        autoOpen: false,
        modal: true,
        buttons: {
          "Add validation": function() {
            var text, val;

            val = $('#validation_id').val();
            text = $('#validation_id > option:selected').text();
            $('#validation_text').append("							<div class='validation_entry'>								<input type='hidden' id='validation_" + count + "' name='data[Question][validation_" + count + "]' value='" + val + "' />								<p><span class='text'>" + text + "</span><span class='remove_image'>" + count + "</span></p>							</div>						");
            count++;
            return $(this).dialog('close');
          }
        }
      });
      $('#dialog-error').dialog({
        autoOpen: false,
        modal: true,
        buttons: {
          Ok: function() {
            return $(this).dialog('close');
          }
        }
      });
      return $('#validation_text').on('click', '.remove_image', function() {
        var current, input, num, remove_image, total;

        total = $('#validation_text .remove_image').length;
        if (parseInt($(this).text()) !== total) {
          while (current.length > 0) {
            input = current.find('input[type=hidden]');
            remove_image = input.next().find('.remove_image');
            num = parseInt(remove_image.text()) - 1;
            remove_image.text(num);
            input.attr('name', "data[Question][validation_" + num + "]");
            current = current.next();
          }
          $(this).parent().parent().remove();
          return count--;
        } else {
          $(this).parent().parent().remove();
          return count--;
        }
      });
    });
  });

}).call(this);
