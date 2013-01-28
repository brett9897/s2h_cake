<div class="actionsNoButton">
	<?php echo $this->Html->link(__('New Question'), array('action' => 'add')); ?> <br/>
	<?php echo $this->Html->link(__('List Groupings'), array('controller' => 'groupings', 'action' => 'index')); ?> <br/>
	<?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add')); ?> <br/>
</div>
<div class="questions index">
	<h2><?php echo __('Questions'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('survey_id'); ?></th>
			<th><?php echo $this->Paginator->sort('grouping_id'); ?></th>
			<th><?php echo $this->Paginator->sort('internal_name'); ?></th>
			<th><?php echo $this->Paginator->sort('label'); ?></th>
			<th><?php echo $this->Paginator->sort('type_id'); ?></th>
			<th><?php echo $this->Paginator->sort('ordering'); ?></th>
			<th><?php echo $this->Paginator->sort('is_used'); ?></th>
			<th><?php echo $this->Paginator->sort('is_required'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($questions as $question): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($question['Survey']['label'], array('controller' => 'surveys', 'action' => 'view', $question['Survey']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($question['Grouping']['label'], array('controller' => 'groupings', 'action' => 'view', $question['Grouping']['id'])); ?>
		</td>
		<td><?php echo h($question['Question']['internal_name']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['label']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($question['Type']['label'], array('controller' => 'types', 'action' => 'view', $question['Type']['id'])); ?>
		</td>
		<td><?php echo h($question['Question']['ordering']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['is_used']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['is_required']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $question['Question']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $question['Question']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $question['Question']['id']), null, __('Are you sure you want to delete # %s?', $question['Question']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>