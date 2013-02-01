
<style type="text/css">
    table tr td {
        border-bottom: none;
        padding: 10px;
    }
    input[type=radio] {
        float: none;
        width: auto;
        margin: 6px;
        padding: 0;
        line-height: 26px;
    }
</style>

<?php include("surveyInstanceDiv.ctp"); ?>

<div class="surveyInstances form">
    <h2>Edit Survey</h2>
    <table>
        <tr>
            <?php echo $this->Form->create('Client'); ?>

            <!-- personal information from the client table -->
            <td><h3>Personal Information</h3></td>
        </tr>
        <tr>
            <td> Your active Survey </td>
            <td>
                <?php
                echo $this->Form->input('survey_id', array(
                    'label' => '',
                    'options' => array(
                        $activeSurvey['Survey']['id'] => $activeSurvey['Survey']['id']
                    )
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td>First Name</td>
            <td>
                <?php
                echo $this->Form->input('first_name', array(
                    'label' => ''
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td>
                <?php
                echo $this->Form->input('last_name', array(
                    'label' => ''
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td>Organization ID</td>
            <td>
                <?php
                echo $this->Form->input('organization_id', array(
                    'label' => ''
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td>SSN</td>
            <td>
                <?php
                echo $this->Form->input('ssn', array(
                    'label' => ''
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td>DOB</td>
            <td>
                <?php
                echo $this->Form->input('dob', array(
                    'label' => ''
                ));
                ?>
            </td>
        </tr>

        <!-- iterating through all the groupings -->
        <?php
        foreach ($groupings as $grouping):
            //printing out grouping label
            if ($grouping['label'] != 'Personal Information'):
                echo "<tr><td><h3>" . $grouping['label'] . "</h3></td></tr>";
            endif;
            foreach ($grouping['Question'] as $question):
                echo "<tr>";
                echo "<td>" . $question['label'] . "</td>";
                echo "<td>" . $this->Question->giveMeInputString($question) . "</td>";
                echo "</tr>";
            endforeach;

        endforeach;
        ?>
    </table>
    <br />
    
    <?php echo $this->Form->end(__('Submit')); ?>

</div>

