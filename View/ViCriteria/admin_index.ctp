<div class="actionsNoButton">
		<?php echo $this->Html->link(__('New Vi Criterium'), array('action' => 'add')); ?><br/>
		<?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> <br/>
</div>
<div class="viCriteria index">
	<h2><?php echo __('Vi Criteria'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('question_id'); ?></th>
			<th><?php echo $this->Paginator->sort('survey_id'); ?></th>
			<th><?php echo $this->Paginator->sort('option_id'); ?></th>
			<th><?php echo $this->Paginator->sort('vi_grouping_id'); ?></th>
			<th><?php echo $this->Paginator->sort('threshold'); ?></th>
			<th><?php echo $this->Paginator->sort('weight'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($viCriteria as $viCriterium): ?>
	<tr>
		<td><?php echo h($viCriterium['ViCriterium']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($viCriterium['Question']['label'], array('controller' => 'questions', 'action' => 'view', $viCriterium['Question']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($viCriterium['Survey']['label'], array('controller' => 'surveys', 'action' => 'view', $viCriterium['Survey']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($viCriterium['Option']['label'], array('controller' => 'options', 'action' => 'view', $viCriterium['Option']['id'])); ?>
		</td>
		<td><?php echo h($viCriterium['ViCriterium']['vi_grouping_id']); ?>&nbsp;</td>
		<td><?php echo h($viCriterium['ViCriterium']['threshold']); ?>&nbsp;</td>
		<td><?php echo h($viCriterium['ViCriterium']['weight']); ?>&nbsp;</td>
		<td><?php echo h($viCriterium['ViCriterium']['created']); ?>&nbsp;</td>
		<td><?php echo h($viCriterium['ViCriterium']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $viCriterium['ViCriterium']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $viCriterium['ViCriterium']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $viCriterium['ViCriterium']['id']), null, __('Are you sure you want to delete # %s?', $viCriterium['ViCriterium']['id'])); ?>
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
