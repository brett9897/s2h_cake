<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Groupings'), array('action' => 'index', $grouping['Grouping']['survey_id'])); ?> <br/>
	<?php echo $this->Html->link(__('Edit Grouping'), array('action' => 'edit', $grouping['Grouping']['id'])); ?><br/>
	<?php echo $this->Form->postLink(__('Delete Grouping'), array('action' => 'delete', $grouping['Grouping']['id']), null, __('Are you sure you want to delete # %s?', $grouping['Grouping']['id'])); ?> <br/>
	<?php echo $this->Html->link(__('New Grouping'), array('action' => 'add')); ?> <br/>
	<?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?> <br/>
	<?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?> <br/>
</div>
<div class="groupings view">
<h2><?php  echo __('Grouping'); ?></h2>
	<dl>
		<dt><?php echo __('Survey'); ?></dt>
		<dd>
			<?php echo $this->Html->link($grouping['Survey']['label'], array('controller' => 'surveys', 'action' => 'view', $grouping['Survey']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($grouping['Grouping']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ordering'); ?></dt>
		<dd>
			<?php echo h($grouping['Grouping']['ordering']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Used'); ?></dt>
		<dd>
			<?php echo $this->Binary->convertToTF($grouping['Grouping']['is_used']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($grouping['Grouping']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($grouping['Grouping']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>