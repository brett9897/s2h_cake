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
        <?php foreach ($groupings as $grouping): ?>
            <?php if ($grouping['Grouping']['label'] != 'Personal Information'): ?>
                <h2><?php echo $grouping['Grouping']['label']; ?></h2>
            <?php endif; ?>
            <?php foreach ($grouping['Question'] as $question): ?>
                <dt><?php echo __($question['label']); ?></dt>

                <?php foreach ($question['Answer'] as $answer): ?>
                    <dd>
                        <?php if ($answer['survey_instance_id'] == $id): ?>
                            <?php echo h($answer['value']); ?>
                            <br /><br />
                        <?php endif; ?>
                    </dd>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <br />
        <?php endforeach; ?>
    </dl>
</div>

