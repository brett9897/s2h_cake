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

        location.href = global.base_url + "/survey_instances/index";

    });
    
    jQuery("#radioSurveyAdmin").click(function () {

        location.href = global.base_url + "/admin/surveys";

    });
    
    
    jQuery("#radioReports").click(function () {
        
        location.href = global.base_url + "/clients/index";
        
    });
    
    jQuery("#radioReportsAdmin").click(function () {
        
        location.href = global.base_url + "/admin/clients/index";
        
    });
    	    
});