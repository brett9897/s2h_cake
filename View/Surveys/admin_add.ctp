<?php $this->Html->script('Surveys/admin_add.js', false); ?>
<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Surveys'), array('action' => 'index')); ?><br/>
	<?php echo $this->Html->link(__('Create New Survey'), array('action' => 'add'), array('class' => 'active_link')); ?><br/>
</div>
<div class="surveys form">
<?php echo $this->Form->create('Survey'); ?>
	<fieldset>
		<legend><?php echo __('Add Survey'); ?></legend>
	<?php
		if( isset( $organizations ) )
		{
			echo $this->Form->input('organization_id');
		}
		echo $this->Form->input('label');
		echo $this->Form->input('use_existing', array('label' => 'I would you like to start from an existing survey', 'type' => 'checkbox'));
	?>
		<div id="dialog-confirm" title="Are you sure?">
			<p>
				<span class="ui-icon ui-icon-alert" style="float:left; margin: 0 7px 20px 0;"></span>
				Are you sure you want to start your new survey with the questions from another survey?
			</p>
		</div>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>