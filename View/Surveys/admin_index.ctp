<?php $this->Html->script('Surveys/admin_index.js', false); ?>
<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Surveys'), array('action' => 'index'), array('class' => 'active_link')); ?><br/>
	<?php echo $this->Html->link(__('Create New Survey'), array('action' => 'add')); ?><br/>
</div>
<div class="surveys index">
	<div id="save_message"></div>
	<h2><?php echo __('Surveys'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('organization_id'); ?></th>
			<th><?php echo $this->Paginator->sort('label'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th>Active</th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($surveys as $survey): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($survey['Organization']['name'], array('controller' => 'organizations', 'action' => 'view', $survey['Organization']['id'])); ?>
		</td>
		<td><?php echo h($survey['Survey']['label']); ?>&nbsp;</td>
		<td><?php echo h($survey['Survey']['created']); ?>&nbsp;</td>
		<td><?php echo h($survey['Survey']['modified']); ?>&nbsp;</td>
		<?php if( $survey['Survey']['isActive'] == true ): ?>
			<td>
				<?php 
					echo $this->Form->input('', 
						array('type' => 'checkbox', 'checked' => 'true', 'disabled' => 'true', 'id' => 'active_' . $survey['Survey']['id'], 'class' => 'active')); 
				?>&nbsp;
			</td>
		<?php else: ?>
			<td><?php echo $this->Form->input('', array('type' => 'checkbox', 'id' => 'active_' . $survey['Survey']['id'], 'class' => 'active')); ?>&nbsp;</td>
		<?php endif; ?>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $survey['Survey']['id'])); ?>
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