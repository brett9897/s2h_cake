<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Surveys'), array('action' => 'index')); ?><br/>
	<?php echo $this->Html->link(__('New Survey'), array('action' => 'add')); ?><br/>
</div>
<div class="surveys form">
<?php echo $this->Form->create('Survey'); ?>
	<fieldset>
		<legend><?php echo __('Clone: ' . $survey_name); ?></legend>
	<?php
		if( isset( $organizations ) )
		{
			echo $this->Form->input('organization_id');
		}
		echo $this->Form->input('label', array( 'label' => 'New Survey Name:'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>