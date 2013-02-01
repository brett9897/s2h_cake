<div class="actionsNoButton">
        <?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> <br/>
        <?php echo $this->Html->link(__('List Organizations'), array('controller' => 'organizations', 'action' => 'index')); ?> <br/>
        <?php echo $this->Html->link(__('New Organization'), array('controller' => 'organizations', 'action' => 'add')); ?> <br/>
        <?php echo $this->Html->link(__('List Survey Instances'), array('controller' => 'survey_instances', 'action' => 'index')); ?> <br/>
        <?php echo $this->Html->link(__('New Survey Instance'), array('controller' => 'survey_instances', 'action' => 'add')); ?> <br/>
</div>

<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
                echo $this->Form->input('password_confirmation', array('type'=>'password', 'autocomplete' => 'off'));
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('organization_id', array('disabled'=>'true'));          //array('value'=> 'click me')
                //echo $this->Form->input('organization_id');          //array('value'=> 'click me')
		echo $this->Form->input('type');
		//echo $this->Form->input('isDeleted');                     //should only be in edit user...so you can 'disable' a user and re-enable them at a later time if needed
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

