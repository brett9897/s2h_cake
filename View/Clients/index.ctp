<?php
    //load in all javascript/jquery files that would go in the <head>...</head> of the html.
    //the .js file must be in the /app/webroot/ directory
    //echo $this->Html->script('jquery-1.9.0.min');
    //echo $this->Html->script('clients_index');          
    //$this->Html->script('jquery-1.9.0.min', FALSE);         //<---this is 'magically' included by some script brett wavied his fingers at...
    
    //$this->Html->script('jquery-1.8.3.min', FALSE);                
    //$this->Html->script('jquery-ui-1.9.2.custom.min', FALSE);                
    
    $this->Html->script('jquery.dataTables', FALSE);     //putting false param tells cakephp to put this in the header of the html
    //$this->Html->script('shCore.js', FALSE);                
    $this->Html->script('clients_index', FALSE);            
    
?>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Client'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Organizations'), array('controller' => 'organizations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Organization'), array('controller' => 'organizations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Survey Instances'), array('controller' => 'survey_instances', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Survey Instance'), array('controller' => 'survey_instances', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="clients index">

                
                <div id="dt_example">
			<div id="container">
				
				<div id="dynamic">
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="clientsResults">
                                            <thead>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>DOB</th>
                                            </thead>
                                        </table>
                                </div>
                        </div>
                </div>
    
    
    

