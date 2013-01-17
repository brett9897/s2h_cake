<div class="surveyInstances view">
<h2><?php  echo __('Survey Instance'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($surveyInstance['SurveyInstance']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Survey'); ?></dt>
		<dd>
			<?php echo $this->Html->link($surveyInstance['Survey']['label'], array('controller' => 'surveys', 'action' => 'view', $surveyInstance['Survey']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client'); ?></dt>
		<dd>
			<?php echo $this->Html->link($surveyInstance['Client']['first_name'], array('controller' => 'clients', 'action' => 'view', $surveyInstance['Client']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($surveyInstance['User']['first_name'], array('controller' => 'users', 'action' => 'view', $surveyInstance['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vi Score'); ?></dt>
		<dd>
			<?php echo h($surveyInstance['SurveyInstance']['vi_score']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($surveyInstance['SurveyInstance']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($surveyInstance['SurveyInstance']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Survey Instance'), array('action' => 'edit', $surveyInstance['SurveyInstance']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Survey Instance'), array('action' => 'delete', $surveyInstance['SurveyInstance']['id']), null, __('Are you sure you want to delete # %s?', $surveyInstance['SurveyInstance']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Survey Instances'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Survey Instance'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
