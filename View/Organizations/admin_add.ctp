<div class="actionsNoButton">
       <?php echo $this->Html->link(__('List Organizations'), array('action' => 'index')); ?> <br/>
       <?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> <br/>
       <?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> <br/>
       <?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?> <br/>
       <?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?> <br/>
       <?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> <br/>
       <?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> <br/>
</div>

<div class="organizations form">
<?php echo $this->Form->create('Organization'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Organization'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('isDeleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

