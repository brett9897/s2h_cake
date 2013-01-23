<?php $this->Html->script('Questions/admin_add.js', false);?>
<?php $this->Html->css('Questions/admin_add', null, array('inline' => false)); ?>
<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Questions'), array('action' => 'index')); ?><br/>
	<?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add')); ?><br/>
</div>
<div class="questions form">
<?php echo $this->Form->create('Question'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Question'); ?></legend>
	<?php
		echo $this->Form->input('grouping_id', array('selected' => $selected_grouping_id));
		echo $this->Form->input('internal_name');
		echo $this->Form->input('label', array('label' => 'Question'));
		echo $this->Form->input('type_id');
		echo $this->Form->input('ordering');
		echo $this->Form->input('is_used');
		echo $this->Form->input('is_required');
	?>
		<div id="validations">
			<span id="plus_image">plus sign</span><span id="words">Click to add validations</span>
		</div>
		<div id="validation_text"></div>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div id="validations_form" title="Select a validation to add.">
	<form>
		<fieldset>
			<?php echo $this->Form->input('validation_id', array('type' => 'select', 'options' => $validation_options));?>
		</fieldset>
	</form>
</div>
<div id="dialog-error" title="Error: Maximum Reached!">
	<p>
		<span class="ui-icon ui-icon-alert" style="float: left; margin: 15px 7px 20px 0;"></span>
		The maximum number of validations allowed per question is 4 at this time!  You must remove one to add another.
	</p>	
</div>