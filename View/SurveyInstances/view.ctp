<style>
    dd {
        padding-left: 300px;
    }
    dt {
        width: 300px;
    }

</style>

<?php include("surveyInstanceDiv.ctp"); ?>

<div class="surveyInstances view">
    <h2><?php echo __('Survey for Client ' . $surveyInstance['Client']['first_name']); ?></h2>
    <dl>
        <dt><?php echo __('Vi Score'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['SurveyInstance']['vi_score']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Client First Name'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['Client']['first_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Client Middle Name'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['Client']['middle_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Client Last Name'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['Client']['last_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Client SSN'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['Client']['ssn']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Client DOB'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['Client']['dob']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Client Nickname'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['Client']['nickname']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Client Phone Number'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['Client']['phone_number']); ?>
            &nbsp;
        </dd>

        <?php foreach ($groupings as $grouping): ?>
            <?php if ($grouping['Grouping']['label'] != 'Personal Information'): ?>
                <h3><?php echo $grouping['Grouping']['label']; ?></h3> 
                <br />
            <?php endif; ?>

            <?php foreach ($grouping['Question'] as $question): ?>
                <dt><?php echo __($question['label']); ?></dt>

                <?php foreach ($question['Answer'] as $answer): ?>
                    <dd>
                        <?php if ($answer['SurveyInstance']['id'] == $id): ?>
                            <?php echo h($answer['value']); ?>
                            <br />
                        <?php endif; ?>
                    </dd>
                <?php endforeach; ?>

            <?php endforeach; ?>
            <br />
        <?php endforeach; ?>
    </dl>


</div>

