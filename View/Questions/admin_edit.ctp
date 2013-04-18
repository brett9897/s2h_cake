<?php $this->Html->script('Questions/admin_add.js', false);?>
<?php $this->Html->css('Questions/admin_add', null, array('inline' => false)); ?>
<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?><br/>
	<?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?><br/>
	<?php echo $this->Html->link(__('Edit Survey'), array('controller' => 'surveys', 'action' => 'edit', $survey_id)); ?><br/>
	<?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add', $survey_id)); ?> <br/>
	<?php echo $this->Html->link(__('New VI Criterion'), array('controller' => 'vi_criteria', 'action' => 'add', $survey_id)); ?><br/>
	<?php echo $this->Html->link(__('List VI Criterion'), array('controller' => 'vi_criteria', 'action' => 'index', $survey_id)); ?><br/>
</div>
<div class="questions form">
<?php echo $this->Form->create('Question'); ?>
	<fieldset>
		<legend><?php echo __('Edit Question'); ?></legend>
	<?php
		echo $this->Form->input('grouping_id', array('selected' => $selected_grouping_id));
		echo $this->Form->input('internal_name', array('disabled' => $hasInstance));
		echo $this->Form->input('label', array('label' => 'Question', 'disabled' => $hasInstance));
		echo $this->Form->input('type_id', array('disabled' => $hasInstance));
	?>
		<?php if( isset( $this->data['Option']['options'] ) && $this->data['Option']['options'] != '' ): ?>
			<div id="added_options" class="input text required">
				<label for="options">Options</label>
				<input type="text" size="40" name="data[Option][options]" 
					value="<?php echo $this->data['Option']['options']; ?>"/>
				<span class="help">Comma separate all of the options you want.</span>
			</div>	
		<?php else: ?>
			<div id="added_options" class="input text required do_not_show">
				<label for="options">Options</label>
				<input type="text" size="40" name="data[Option][options]"/>
				<span class="help">Comma separate all of the options you want.</span>
			</div>
		<?php endif; ?>
	<?php
		echo $this->Form->input('ordering');
		echo $this->Form->input('is_used');
		echo $this->Form->input('is_required');
	?>
		<div id="validations">
			<span id="plus_image">plus sign</span><span id="words">Click to add validations</span>
		</div>
		<div id="validation_text">
		<?php $count = 1; ?>
		<?php if( isset($currentValidations) ): ?>
			<?php foreach( $currentValidations as $validation ): ?>
				<div class="validation_entry"> 
					<input type="hidden" id="validation_<?php echo $count;?>" 
						name="data[Question][validation_<?php echo $count;?>]" 
						value="<?php echo $validation['regex'];?>" />
					<p><span class="text"><?php echo $validation['label'];?></span><span class="remove_image"><?php echo $count;?></span></p>
				</div>
				<?php $count++; ?>
			<?php endforeach; ?>
		<?php endif;?>
		</div>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div id="validations_form" title="Select a validation to add.">
	<form>
		<fieldset>
			<?php echo $this->Form->input('validation_id', array('type' => 'select', 'options' => $validation_options));?>
			<?php echo $this->Form->input('validation_message', array('type' => 'text', 'required' => true));?>
		</fieldset>
	</form>
</div>
<div id="dialog-error" title="Error: Maximum Reached!">
	<p>
		<span class="ui-icon ui-icon-alert" style="float: left; margin: 15px 7px 20px 0;"></span>
		The maximum number of validations allowed per question is 4 at this time!  You must remove one to add another.
	</p>	
</div>