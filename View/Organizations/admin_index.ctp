<div class="actionsNoButton">
        <?php echo $this->Html->link(__('New Organization'), array('action' => 'add')); ?> <br/>
        <?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> <br/>
        <?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> <br/>
        <?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?> <br/>
        <?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?> <br/>
        <?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> <br/>
	<?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> <br/>
</div>

<div class="organizations index">
	<h2><?php echo __('Organizations'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('isDeleted'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($organizations as $organization): ?>
	<tr>
		<td><?php echo h($organization['Organization']['id']); ?>&nbsp;</td>
		<td><?php echo h($organization['Organization']['name']); ?>&nbsp;</td>
		<td><?php echo h($organization['Organization']['isDeleted']); ?>&nbsp;</td>
		<td><?php echo h($organization['Organization']['created']); ?>&nbsp;</td>
		<td><?php echo h($organization['Organization']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $organization['Organization']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $organization['Organization']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $organization['Organization']['id']), null, __('Are you sure you want to delete # %s?', $organization['Organization']['id'])); ?>
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

