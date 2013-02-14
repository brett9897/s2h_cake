<?php 
	$this->Html->script('jquery.dataTables.min.js', FALSE);
	$this->Html->script('dataTables.fnSetFilteringDelay.js', FALSE);        
    $this->Html->script('SurveyInstances/admin_index.js', FALSE); 
	$this->Html->css('dataTables/jquery.dataTables', null, array('inline' => false)); 
?>
<div class="surveyInstances index no-border">
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