<?php $this->Html->script('Surveys/admin_edit.js', false); ?>
<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Surveys'), array('action' => 'index')); ?><br/>
	<!--<?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Survey.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Survey.id'))); ?><br/>-->
	<?php echo $this->Html->link(__('List Groupings'), array('controller' => 'groupings', 'action' => 'index', $this->Form->value('Survey.id'))); ?><br/>
	<?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add')); ?> <br/>
	<?php echo $this->Html->link(__('Add VI Criterion'), array('controller' => 'vi_criteria', 'action' => 'add', $this->Form->value('Survey.id'))); ?><br/>
</div>
<div class="surveys form">
<?php echo $this->Form->create('Survey'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Survey'); ?></legend>
	<?php
		echo $this->Form->input('id');
		if( isset( $organizations ) )
		{
			echo $this->Form->input('organization_id');
		}
		echo $this->Form->input('label');
		echo $this->Form->input('isActive');
		echo $this->Form->input('isDeleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Update')); ?>
<div id="accordion">
	<div id="personal_info" class="group">
		<h3 class="fixed"><?php echo $groupings[0]['Grouping']['label']; ?></h3>
		<div>
			<?php echo $this->element('survey_edit_form', array('grouping' => $groupings[0])); ?>
		</div>
	</div>
<?php unset($groupings[0]); ?>
<?php foreach( $groupings as $grouping): ?>
	<div class="group">
		<h3 class="movable"><?php echo $grouping['Grouping']['label']; ?></h3>
		<div>
			<?php echo $this->element('survey_edit_form', array('grouping' => $grouping)); ?>
		</div>
	</div>
<?php endforeach; ?>
</div>
</div>