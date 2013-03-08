<div class="actionsNoButton">
        <?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> <br/>
</div>

<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password', array('autocomplete' => 'off'));
        echo $this->Form->input('password_confirmation', array('type'=>'password', 'autocomplete' => 'off'));
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('organization_id', array('disabled'=>'true', 'selected' => $selected_id));
		echo $this->Form->input('type', array('type' => 'select', 'options' => array_combine($type_options, $type_options)));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

