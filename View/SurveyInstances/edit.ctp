<?php echo $this->Html->script('ajaxupload-min.js', FALSE); ?>
<?php echo $this->Html->css('classicTheme/style'); ?>
<?php echo $this->Html->script("SurveyInstances/add.js", FALSE); ?>
<?php echo $this->Html->css("SurveyInstances/addEdit"); ?>

<script>
    $(function() {
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            yearRange: "-100:+0" 
        });
    });
</script>

<script>
    $(function() {
        $('#ClientDob.datepicker').datepicker('destroy');
        $('#ClientDob.datepicker').removeClass('hasDatepicker');

        $('#ClientDob.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            yearRange: "-100:+0",
            maxDate: '+0d'
        });
    })
</script>

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
                    'disabled' => 'disabled',
                    'options' => array(
                        $activeSurvey['Survey']['label'] => $activeSurvey['Survey']['label']
                    )
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td><strong>First Name<font color="red">*</font></strong></td>
            <td>
                <?php
                echo $this->Form->input('first_name', array(
                    'label' => '',
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td>Middle Name</td>
            <td>
                <?php
                echo $this->Form->input('middle_name', array(
                    'label' => ''
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td><strong>Last Name<font color="red">*</font></strong></td>
            <td>
                <?php
                echo $this->Form->input('last_name', array(
                    'label' => '',
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td>Nickname</td>
            <td>
                <?php
                echo $this->Form->input('nickname', array(
                    'label' => ''
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td>Last 4 of SSN</td>
            <td>
                <?php
                echo $this->Form->input('ssn', array(
                    'label' => '',
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td><strong>DOB<strong><font color="red">*</font></td>
                        <td>
                            <?php
                            echo $this->Form->input('dob', array(
                                'label' => '',
                                'class' => 'datepicker',
                                'name' => 'dateDOB',
                                'onBlur' => 'checkIfClientExists()',
                                'type' => 'text'
                            ));
                            ?>
                        </td>
        </tr>
        <tr>
            <td>Phone Number</td>
            <td>
                <?php
                echo $this->Form->input('phone_number', array(
                    'label' => ''
                ));
                ?>
            </td>
        </tr>

        <!-- iterating through all the groupings -->
        <?php
        foreach ($groupings as $grouping):
            if ($grouping['is_used']):
                //printing out grouping label
                if ($grouping['label'] != 'Personal Information'):
                    echo "<tr><td><h3>" . $grouping['label'] . "</h3></td></tr>";
                endif;
                foreach ($grouping['Question'] as $question):
                    if ($question['is_used']):
                        echo "<tr>";

                        //I've broken apart the label from the question in columns to make
                        //things look nicer, which means that I can just use straight up HTML here
                        if ($question['is_required']):
                            echo '<td><strong>' . $question['label'] . "<font color='red'>*</font></strong></td>";
                        else:
                            echo "<td>" . $question['label'] . "</td>";
                        endif;
                        echo "<td>" . $this->Question->giveMeInputString($question) . "</td>";
                        echo "</tr>";
                    endif;
                endforeach;
            endif;
        endforeach;
        ?>
    </table>
    <br /><br />

    <?php
    //hidden field to map photo to client
    echo $this->Form->input('photoName', array(
        'type' => 'hidden',
        'id' => 'photoName',
        'value' => 'none.png'
    ));

    //hidden fields for creating new client or using existing one
    echo $this->Form->input('whichClient', array(
        'type' => 'hidden',
        'id' => 'whichClient',
        'value' => 'newClient'
    ));
    
     echo $this->Form->input('oldClientID', array(
        'type' => 'hidden',
        'id' => 'oldClientID',
        'value' => '0'
    ));
    ?>

    <?php
    echo $this->Form->submit('Submit', array(
        'onClick' => 'bindPhoto()'
    ));
    ?>

</div>

