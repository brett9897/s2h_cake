<?php $this->Html->css('dataTables/jquery.dataTables', null, array('inline' => false)); ?>

<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Survey Instances'), array('controller' => 'survey_instances', 'action' => 'index', 'admin' => false)); ?> <br/>
</div>

<?php
    //load in all javascript/jquery files that would go in the <head>...</head> of the html.
    //the .js file must be in the /app/webroot/ directory
    //echo $this->Html->script('jquery-1.9.0.min');
    //echo $this->Html->script('clients_index');          
    //$this->Html->script('jquery-1.9.0.min', FALSE);         //<---this is 'magically' included by some script brett wavied his fingers at...
    
    //$this->Html->script('jquery-1.8.3.min', FALSE);                
    //$this->Html->script('jquery-ui-1.9.2.custom.min', FALSE);                
    
    $this->Html->script('jquery.dataTables.min.js', FALSE);     //putting false param tells cakephp to put this in the header of the html
    //$this->Html->script('shCore.js', FALSE);                
    $this->Html->script('clients_index.js', FALSE);            
    
?>



<div class="clients index">

                
                <div id="dt_example">
			<div id="container">
				
				<div id="dynamic">
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="clientsResults">
                                            <thead>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>DOB</th>
                                                <th>SSN</th>
                                                <th>VI Score</th>
                                            </thead>
                                        </table>
                                </div>
                        </div>
                </div>
</div>
