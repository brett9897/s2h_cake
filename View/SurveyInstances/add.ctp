<div class="actionsNoButton">

    <?php echo $this->Html->link(__('List Survey Instances'), array('action' => 'index')); ?><br />
    <?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?><br />
    <?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?><br />
    <?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?><br />
    <?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?><br />
    <?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?><br />
    <?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?>

</div>

<div class="surveyInstances form">
    <h2>New Survey</h2>
    <?php echo $this->Form->create('Client'); ?>
    <fieldset>

        <!-- personal information from the client table -->
        <legend>Personal Information</legend>
        <?php
        echo $this->Form->input('first_name');
        echo $this->Form->input('last_name');
        echo $this->Form->input('ssn');
        echo $this->Form->input('dob');
        ?>

        <!-- iterating through all the groupings -->
        <?php foreach ($groupings as $grouping): ?>
            <?php foreach ($grouping['Question'] as $question): ?>
                <?php echo $this->Question->giveMeInputtag($question); ?>
                <br />
            <?php endforeach; ?>
        <?php endforeach; ?>
        

    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>

