//TODO Fix to use new global.base_url variable

jQuery(document).ready(function(){  
    jQuery(function() {
        jQuery( "#top_links" ).buttonset();
    });

    //clicking radio buttons functionality
    jQuery("#radio1").click(function () {
        window.location.href = global.base_url + "/users/";
    });
    
    jQuery("#radio2").click(function () {

        location.href = global.base_url + "/surveys";

    });
    
    
    jQuery("#radio3").click(function () {
        
        location.href = global.base_url + "/organizations";
        
    });
    	    
});