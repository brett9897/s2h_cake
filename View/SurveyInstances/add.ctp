<div class="actionsNoButton">

    <?php echo $this->Html->link(__('My Surveys'), array('action' => 'index')); ?><br />

</div>

<div class="surveyInstances form">
    <h2>New Survey</h2>
    <?php echo $this->Form->create('Client'); ?>

    <!-- personal information from the client table -->
    <h3>Personal Information</h3>
    <?php
    echo $this->Form->input('first_name');
    echo $this->Form->input('last_name');
    echo $this->Form->input('ssn');
    echo $this->Form->input('dob');
    ?>

    <!-- iterating through all the groupings -->
    <?php
    foreach ($groupings as $grouping):
        
        if ($grouping['label'] != 'Personal Information'): echo "<h3>" . $grouping['label'] . "</h3><br />"; endif;
        foreach ($grouping['Question'] as $question):

            $options = array();
            
            if (!empty($question['Option'])):
                $i = 0;
                foreach ($question['Option'] as $individualOption):
                    $options[$i] = $individualOption['label'];
                    $i++;
                endforeach;
            endif;

            echo $this->Form->input($question['label'], array(
                'type' => $question['Type']['label'],
                'options' => $options
            ));
        endforeach;
        echo "<br />";
    endforeach;
    ?>

    <?php echo $this->Form->end(__('Submit')); ?>
</div>

