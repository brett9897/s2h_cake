<?php $this->Html->script('Surveys/admin_edit.js', false); ?>
<?php $this->Html->css('Surveys/admin_edit', null, array( 'inline' => false)); ?>
<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Surveys'), array('action' => 'index')); ?><br/>
	<?php echo $this->Html->link(__('New Survey'), array('action' => 'add')); ?><br/>
	<?php echo $this->Html->link(__('Edit Survey'), array('action' => 'edit', $this->Form->value('Survey.id')), array('class' => 'active_link')); ?><br/>
	<?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add', $this->Form->value('Survey.id'))); ?> <br/>
	<?php echo $this->Html->link(__('New VI Criterion'), array('controller' => 'vi_criteria', 'action' => 'add', $this->Form->value('Survey.id'))); ?><br/>
	<?php echo $this->Html->link(__('List VI Criteria'), array('controller' => 'vi_criteria', 'action' => 'index', $this->Form->value('Survey.id'))); ?><br/>
</div>
<div class="surveys form">
<?php echo $this->Form->create('Survey'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Survey'); ?></legend>
		<div class="single_line_form">
		<?php
			echo $this->Form->input('id');
			if( isset( $organizations ) )
			{
		?>
				<div class="input select required single_line_form_input">
					<?php echo $this->Form->input('organizations', array('div' => false)); ?>
				</div>
		<?php
			}
		?>
			<div class="input text required single_line_form_input extra_width">
				<?php echo $this->Form->input('label', array('div' => false)); ?>
			</div>
			<div class="input button single_line_form_input">
				<?php echo $this->Form->submit('Submit', array('div' => false)); ?>
			</div>
			<div class="clear"></div>
		</div>
	</fieldset>
<?php echo $this->Form->end(); ?>
	<?php if( $hasInstance ): ?>
		<button onClick="send_to_clone(<?php echo $this->Form->value('Survey.id');?>)">Clone Survey</button>
		<br/>
		<br/>
	<?php else: ?>
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
	<?php endif; ?>
</div>