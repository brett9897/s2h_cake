<?php $this->Html->script('Surveys/admin_choose.js', false); ?>
<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Surveys'), array('action' => 'index')); ?><br/>
	<?php echo $this->Html->link(__('Create New Survey'), array('action' => 'add')); ?><br/>
</div>
<div class="surveys index">
	<h2><?php echo __('Choose Survey'); ?></h2>
	<?php echo $this->Form->input('survey_id', array('label' => '', 'empty' => 'Choose survey...')); ?>
	<?php
		if( isset($label) )
		{ 
			echo $this->Form->input('label', array('type' => 'hidden', 'value' => $label));
		}
	?>
	<br/>
	<button onClick="go_to_clone()">Submit</button>
</div>