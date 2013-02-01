$(document).ready( function() {
	$('#accordion').accordion({
		header: "> div > h3",
		heightStyle: "content"
	})
	.sortable({
        axis: "y",
        handle: "h3",
        cancel: "h3.fixed",
        stop: function( event, ui ) {
          // IE doesn't register the blur when sorting
          // so trigger focusout handlers to remove .ui-state-focus
          ui.item.children( "h3" ).triggerHandler( "focusout" );

          //call ajax function to store updated order in the database
        	var groupings = $('div.group').map(function( index ){
        		return {
        			'Grouping': {
	        			'ordering': index+1,
	        			'id': parseInt($(this).find('> div > input#id').val())
	        		}
        		}; 
			}).get();

			console.log( JSON.stringify({'groupings': groupings}) );

			$.ajax({
				url: global.base_url + "/admin/groupings/update.json",
				contentType: 'application/json',
				dataType: 'json',
				type: 'POST',
				data: JSON.stringify({'groupings': groupings}),
				success: groupings_posted
			});

        },
        change: function(event, ui ) {

        	// keeps personal information from moving.
        	var fixed = $("#personal_info");
        	var index = $("#accordion > div").index(fixed);

        	if( index !== 0 )
        	{
        		if( index > 0 )
        		{
        			fixed.prev().insertAfter(fixed);
        		}
        		else
        		{
        			fixed.next().insertBefore(fixed);
        		}
        	}
        } 
      });
	
	function groupings_posted( data, status, xhr )
	{
		console.log( status );
	}
});

function update_order(element)
{
	var questions = $(element).parent().find('tr.question').map(function(index){
        var id = $(this).attr('id');
		return {
            'Question': {
                'id': parseInt(id.substring(id.indexOf('_') + 1)),
                'ordering': parseInt($(this).find('input.ordering').val())
            }
        };
	}).get();

    var grouping_id = $(element).parent().find('input#id').val();
    $.ajax({
        url: global.base_url + "/admin/questions/update_ordering/" + grouping_id,
        contentType: 'application/json',
        dataType: 'html',
        type: 'POST',
        data: JSON.stringify({'questions': questions}),
        success: function(data, status, xhr)
        {
            $(element).parent().find('table').remove();
            $(element).parent().prepend(data);
        }
    }); 
}