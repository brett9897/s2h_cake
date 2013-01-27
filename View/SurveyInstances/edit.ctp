<?php include("surveyInstanceDiv.ctp"); ?>

<div class="surveyInstances form">
    <h2>Edit Survey</h2>
    <?php echo $this->Form->create('Client'); ?>

    <!-- personal information from the client table -->
    <h3>Personal Information</h3>
    <?php
    echo $this->Form->input('survey_id', array(
        'label' => 'Your Active Survey',
        'options' => array(
            $activeSurvey['Survey']['id'] => $activeSurvey['Survey']['id']
        )
    ));
    echo $this->Form->input('first_name');
    echo $this->Form->input('last_name');
    echo $this->Form->input('organization_id');
    echo $this->Form->input('ssn');
    echo $this->Form->input('dob');
    ?>

    <!-- iterating through all the groupings -->
    <?php
    foreach ($groupings as $grouping):

        //printing out grouping label
        if ($grouping['label'] != 'Personal Information'):
            echo "<h3>" . $grouping['label'] . "</h3><br />";
        endif;

        foreach ($grouping['Question'] as $question):
            echo $this->Question->giveMeInputString($question);
        endforeach;
        echo "<br />";
    endforeach;
    ?>

    <?php echo $this->Form->end(__('Submit')); ?>
</div>

