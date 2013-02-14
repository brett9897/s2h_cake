<?php echo $this->Html->script('ajaxupload-min.js', FALSE); ?>
<?php echo $this->Html->css('classicTheme/style'); ?>

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
    
</style>

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
                    'label' => '',
                    'minYear' => date('Y') - 150,
                    'maxYear' => date('Y')
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
    <h2>Upload Photo</h2>
    <div class="white-background black-text">
        <div id="image_upload" style="width:500px">
            <script type="text/javascript">
                $('#image_upload').ajaxupload({
                    url: global.base_url + '/webroot/upload.php',
                    remotePath: global.base_url + '\\webroot\\uploaded_images',
                    editFilename: true
                });
            </script>
        </div>
    </div>

    <?php echo $this->Form->end(__('Submit')); ?>

</div>

