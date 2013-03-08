<div class="users form no-border">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('password', array('type'=>'hidden'));
        echo $this->Html->link(__('Change Password'), array('action' => 'change_password'));
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('organization_id', array('disabled'=>'true'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>