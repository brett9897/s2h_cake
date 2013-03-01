<?php echo $this->Html->script('ajaxupload-min.js', FALSE); ?>
<?php echo $this->Html->css('classicTheme/style'); ?>
<?php echo $this->Html->script("SurveyInstances/bindPhoto.js", FALSE); ?>

<style type="text/css">
    table tr td {
        border-bottom: none;
        padding: 10px;
        width: 50%;
    }

    input[type=radio] {
        float: none;
        width: auto;
        margin: 6px;
        padding: 0;
        line-height: 26px;
    }

    tbody {
        width: 100%;
    }

    .checkbox input[type="checkbox"] {
        margin-bottom: 0px;
    }

    form .required label {
        color: #e32;
        content: '*';
        display:inline;
    }

</style>

<script>
    $(function() {
        $("#datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            yearRange: "-100:+0" 
        });
    });
</script>


<?php include("surveyInstanceDiv.ctp"); ?>

<div class="surveyInstances form">
    <h2>New Survey</h2>
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
                    'label' => ''
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
                    'label' => '',
                    'minYear' => date('Y') - 150,
                    'maxYear' => date('Y')
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
                    endif;
                endforeach;
            endif;
        endforeach;
        ?>
    </table>
    <br />

    <!-------------------UPLOAD PHOTO ----------------------------------->
    <h2>Upload Photo</h2>
    <div class="white-background black-text">
        <div id="image_upload" style="width:500px">
            <script type="text/javascript">
                $('#image_upload').ajaxupload({
                    url: global.base_url + '/webroot/upload.php',
                    remotePath:<?php echo $remotePath; ?>,
                    editFilename: true
                });
            </script>
        </div>
    </div>

    <?php
    //hidden field to map photo to client
    echo $this->Form->input('photoName', array(
        'type' => 'hidden',
        'id' => 'photoName',
        'value' => 'none.png'
    ));
    ?>

    <?php
    echo $this->Form->submit('Submit', array(
        'onClick' => 'bindPhoto()'
    ));
    ?>
    <?php echo $this->Form->end(); ?>

</div>

