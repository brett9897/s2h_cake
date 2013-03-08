<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?><br/>
	<?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?><br/>
	<?php echo $this->Html->link(__('Edit Survey'), array('controller' => 'surveys', 'action' => 'edit', $survey_id)); ?><br/>
	<?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add', $survey_id)); ?> <br/>
	<?php echo $this->Html->link(__('New VI Criterion'), array('controller' => 'vi_criteria', 'action' => 'add', $survey_id)); ?><br/>
	<?php echo $this->Html->link(__('List VI Criteria'), array('controller' => 'vi_criteria', 'action' => 'index', $survey_id), array('class'=>'active_link')); ?><br/>
</div>
<div class="viCriteria index">
	<h2><?php echo __('Vi Criteria'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('question_id'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('relational_operator'); ?></th>
			<th><?php echo $this->Paginator->sort('values'); ?></th>
			<th><?php echo $this->Paginator->sort('weight'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($viCriteria as $viCriterium): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($viCriterium['Question']['label'], array('controller' => 'questions', 'action' => 'view', $viCriterium['Question']['id'])); ?>
		</td>
		<td><?php echo h($viCriterium['ViCriterium']['type']); ?>&nbsp;</td>
		<td><?php echo h($viCriterium['ViCriterium']['relational_operator']); ?>&nbsp;</td>
		<td><?php echo h($viCriterium['ViCriterium']['values']); ?>&nbsp;</td>
		<td><?php echo h($viCriterium['ViCriterium']['weight']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $viCriterium['ViCriterium']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $viCriterium['ViCriterium']['id']), null, __('Are you sure you want to delete VI Criterion for "%s"?', str_replace('?', '', $viCriterium['Question']['label']))); ?>
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