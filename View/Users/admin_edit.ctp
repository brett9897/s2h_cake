<div class="actionsNoButton">
        <?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> <br/>
        <?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $this->Form->value('User.id')), array('class' => 'active_link')); ?> <br/>
</div>

<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('password', array('type' => 'hidden'));
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('organization_id', array('type' => 'hidden'));
		echo $this->Form->input('type');
		//echo $this->Form->input('isDeleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>