//TODO Fix to use new global.base_url variable

jQuery(document).ready(function(){  
    jQuery(function() {
        jQuery( "#top_links" ).buttonset();
    });

    //clicking radio buttons functionality
    jQuery("#radio1").click(function () {
        window.location.href = global.base_url + "/users/";
    });
    
    jQuery("#radioSurvey").click(function () {

        location.href = global.base_url + "/survey_instances/add";

    });
    
    jQuery("#radioSurveyAdmin").click(function () {

        location.href = global.base_url + "/admin/surveys";

    });
    
    
    jQuery("#radio3").click(function () {
        
        location.href = global.base_url + "/organizations";
        
    });
    	    
});