<?php
CakePlugin::load('GoogleChart');
App::uses('AppController', 'Controller');
App::uses('GoogleChart', 'GoogleChart.Lib');

/**
 * SurveyInstances Controller
 *
 * @property SurveyInstance $SurveyInstance
 */
class SurveyInstancesController extends AppController {

    public $uses = array('Grouping', 'Survey', 'SurveyInstance', 'Client', 'Question', 'Type', 'Organization', 'Answer', 'Option', 'ViCriterium');
    public $helpers = array('Question', 'Html', 'Js', 'GoogleChart.GoogleChart');
    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->validatePost = false;
    }

    public function isAuthorized($user = null) {
        //non admin pages can be accessed by anyone
        if (empty($this->request->params['admin'])) {
            return true;
        }

        //only admins can access admin actions
        if (isset($this->request->params['admin'])) {
            return (bool) ($user['type'] === 'admin' || $user['type'] === 'superAdmin');
        }

        //default deny
        return false;
    }

    /**
     * index method
     *
     * @return void
     */
    public function index($client_id = null) {
        $this->SurveyInstance->recursive = 0;
        $user = $this->Auth->user();
        $user_id = $user['id'];
        $conditions = array();

        if ($user['type'] == 'admin') {
            $activeSurvey = $this->Survey->find('first', array(
                'conditions' => array(
                    'Survey.isActive' => 1,
                    'Survey.organization_id' => $user['organization_id']
            )));

            if( $client_id === null )
            {
                $conditions = array(
                    'Survey.id' => $activeSurvey['Survey']['id']
                );
            }
            else
            {
                $conditions = array(
                    'Survey.id' => $activeSurvey['Survey']['id'],
                    'SurveyInstance.client_id' => $client_id
                );
            }

        } else if ($user['type'] == 'volunteer' || $user['type'] == 'user') {
            $activeSurvey = $this->Survey->find('first', array(
                'conditions' => array(
                    'Survey.isActive' => 1,
                    'Survey.organization_id' => $user['organization_id']
            )));

            if( $client_id === null )
            {
                $conditions = array(
                    'survey_id' => $activeSurvey['Survey']['id'],
                    'SurveyInstance.user_id' => $user_id
                );
            }
            else
            {
                $conditions = array(
                    'survey_id' => $activeSurvey['Survey']['id'],
                    'SurveyInstance.user_id' => $user_id,
                    'SurveyInstance.client_id' => $client_id
                );
            }
        }

        $this->paginate = array(
            'conditions' => $conditions
        );
        $this->set('surveyInstances', $this->paginate($this->SurveyInstance));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->SurveyInstance->id = $id;
        if (!$this->SurveyInstance->exists()) {
            throw new NotFoundException(__('Invalid survey instance'));
        }

        $surveyInstance = $this->SurveyInstance->read(null, $id);

        $this->Grouping->recursive = -1;
        $groupings = $this->Grouping->find('all', array(
            'joins' => array(
                array(
                    'table' => 'survey_instances',
                    'alias' => 'SurveyInstance',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Grouping.survey_id = SurveyInstance.survey_id'
                    )
                )
            ),
            'conditions' => array(
                'SurveyInstance.id' => $id
            ),
            'order' => array(
                'Grouping.ordering'
            ),

        ));

        foreach($groupings as &$grouping)
        {
            $grouping['Question'] = array();

            $grouping_questions = $this->Question->find('all', array(
                'recursive' => -1,
                'conditions' => array(
                    'Question.survey_id' => $grouping['Grouping']['survey_id'],
                    'Question.grouping_id' => $grouping['Grouping']['id']
                )
            ));

            foreach($grouping_questions as &$ques)
            {
                //get answers
                $answers = $this->Answer->find('all', array(
                    'recursive' => -1,
                    'conditions' => array(
                        'Answer.survey_instance_id' => $id,
                        'Answer.question_id' => $ques['Question']['id'],
                        'Answer.isDeleted' => 0
                    )
                ));

                $ques['Question']['Answer'][0]['value'] = null;
                foreach($answers as $answer)
                {
                    $ques['Question']['Answer'][0]['value'] .= $answer['Answer']['value'] . ', ';
                }

                $ques['Question']['Answer'][0]['value'] = substr($ques['Question']['Answer'][0]['value'], 0, -2);
                $grouping['Question'][] = $ques['Question'];
            }
            unset($ques);
        }

        unset($grouping);

        //      var_dump($groupings);
        $this->set('groupings', $groupings);

        $surveyInstance['Client']['dob'] = date("m/d/Y", strtotime($surveyInstance['Client']['dob']));
        $this->Set('surveyInstance', $surveyInstance);
        $this->set('id', $id);
    }

    /**
     * add method['Question']
     *
     * @return void
     */
    public function add() {
        /*         * *************************** RETRIEVING DATA *********************** */
        $current_user = $this->Auth->user();
        $this->Survey->recursive = -1;
        $activeSurvey = $this->Survey->find('first', array(
            'conditions' => array(
                'isActive' => 1,
                'Survey.organization_id' => $current_user['organization_id']
            )
        ));

        if (empty($activeSurvey)) {
            $this->Session->setFlash("No Active Surveys Exist For Your Organization");
            $this->redirect(array('action' => 'index'));
        }

        $this->Grouping->recursive = -1;
        $groupings = $this->Grouping->find('all', array(
            'conditions' => array(
                'Grouping.survey_id' => $activeSurvey['Survey']['id']
            )
        ));
        

        //used to fill out the organization drop down box
        $organization_id = $current_user['organization_id'];
        $this->set(compact('activeSurvey'));
        $this->set('organization_id', $organization_id);
        $this->set('remotePath', preg_quote("'" . APP . 'webroot' . DS . 'img' . "'"));

        /*         * ********************************** VALIDATIONS ******************************** */
        foreach ($groupings as &$grouping) {

            $grouping_questions = $this->Question->find('all', array(
                'recursive' => 0,
                'conditions' => array(
                    'Question.survey_id' => $activeSurvey['Survey']['id'],
                    'Question.grouping_id' => $grouping['Grouping']['id']
                ) 
            ));

            $grouping['Question'] = array();
            foreach( $grouping_questions as &$ques )
            {
                //Get options if they exist
                $question_options = $this->Option->find('all', array(
                    'recursive' => -1,
                    'conditions' => array(
                        'Option.question_id' => $ques['Question']['id']
                    )
                ));

                foreach( $question_options as $option)
                {
                    $ques['Option'][] = $option['Option'];
                }
                $grouping['Question'][] = $ques;
            }
            unset($ques);

            unset($grouping_questions); //free up some space

            foreach ($grouping['Question'] as $question) {
                $this->add_validations($question);
            }
        }

        unset($grouping);
        //debug($groupings);
        $personalInformationGrouping = $groupings[0];
        $this->set(compact('groupings', 'personalInformationGrouping'));

        /*         * **************************** POST ********************************* */
        if ($this->request->is('post')) {

            //first, we need to save data into the client table
            $this->request->data['Client']['organization_id'] = $organization_id;

            //need to update date to be in the correct format for saving
            $this->request->data['Client']['dob'] = date("Y-m-d", strtotime($this->request->data['dateDOB']));

            //checking to see if the user wishes to save the data to a new client or to an existing one
            if ($this->request->data['Client']['whichClient'] == 'newClient') {
                $this->Client->create();
                $this->Client->save($this->request->data);
            } else {
                $this->Client->id = $this->request->data['Client']['oldClientID'];
            }

            //then we need to create the survey instance
            $this->SurveyInstance->create();
            $user_id = $this->Auth->user();
            $user_id = $user_id['id'];
            $surveyInstanceToSave = array(
                'survey_id' => $activeSurvey['Survey']['id'],
                'client_id' => $this->Client->id,
                'user_id' => $user_id,
                'vi_score' => 0,
                'is_Deleted' => 0
            );

            if ($this->SurveyInstance->save($surveyInstanceToSave)) {

                //used to calculate vi_score as we go along
                $vi_score = 0;

                //then we need to save all the answers
                foreach ($groupings as $grouping) {
                    foreach ($grouping['Question'] as $question) {
                        if (!isset($this->request->data['Client'][$question['Question']['internal_name']]))
                            continue;

                        $values = $this->request->data['Client'][$question['Question']['internal_name']];

                        if (gettype($values) != 'array') {
                            $valuesTemp = $values;
                            $values = array();
                            $values[0] = $valuesTemp;
                        }

                        $values = $this->add_additional_values($values, $this->request->data['Client'], $question['Question']['internal_name']);

                        //figure out if there is a vi_criterion for this question
                        $criteria = $this->ViCriterium->find('all', array('conditions' => array('ViCriterium.question_id' => intval($question['Question']['id']))));

                        //this is a much more coherent way of doing it and it removed all known bugs that we have had.
                        foreach ($values as $value) {
                            $this->Answer->create();
                            $answerToSave = array(
                                'question_id' => $question['Question']['id'],
                                'client_id' => $this->Client->id,
                                'survey_instance_id' => $this->SurveyInstance->id,
                                'value' => $value,
                                'isDeleted' => 0,
                            );
                            $this->Answer->save($answerToSave);

                            foreach ($criteria as $criterion) {
                                
                                if (strpos($criterion['ViCriterium']['values'], ',') === false) {
                                    $criterion_values = array($criterion['ViCriterium']['values']);
                                } else {
                                    $criterion_values = explode(',', $criterion['ViCriterium']['values']);
                                }
                                foreach ($criterion_values as $c_value) {
                                    switch ($criterion['ViCriterium']['relational_operator']) {
                                        case '<':
                                            if ($value < $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                            }
                                            break;
                                        case '>':
                                            if ($value > $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                            }
                                            break;
                                        case '=':
                                            if ($value == $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                            }
                                            break;
                                        case '<=':
                                            if ($value <= $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                            }
                                            break;
                                        case '>=':
                                            if ($value >= $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                            }
                                            break;
                                    }
                                }
                            }
                        }
                    }
                }

                //suffix logic
                foreach ($this->request->data['Client'] as $key => $value) {
                    $values = explode(" - ", $key);

                    if (count($values) > 1) {
                        $suffix = end($values);
                        switch ($suffix) {

                            //months-years
                            case ("YEARS"):
                                if (!empty($value)) {
                                    $fixedKey = str_replace(' - YEARS', '', $key);
                                    $months = $this->request->data['Client'][$fixedKey . ' - MONTHS'];
                                    $assocQuestion = $this->Question->find('first', array(
                                        'conditions' => array(
                                            'internal_name' => $fixedKey
                                        )
                                            ));
                                    $value = $value . ' years, ' . $months . ' months';
                                    $this->Answer->create();
                                    $answerToSave = array(
                                        'question_id' => $assocQuestion['Question']['id'],
                                        'client_id' => $this->Client->id,
                                        'survey_instance_id' => $this->SurveyInstance->id,
                                        'value' => $value,
                                        'isDeleted' => 0,
                                    );
                                    $this->Answer->save($answerToSave);
                                }
                                break;

                            //refused
                            case ("REFUSED"):
                                if ($value == 1 || $value == "1") {
                                    $fixedKey = str_replace(' - REFUSED', '', $key);
                                    $assocAnswer = $this->Answer->find('first', array(
                                        'conditions' => array(
                                            'Question.internal_name' => $fixedKey
                                        )
                                            ));

                                    //overwriting question if exists with 'REFUSED'
                                    if (!empty($assocAnswer)) {
                                        $this->Answer->id = $assocAnswer['Answer']['id'];
                                        $this->Answer->saveField('value', 'REFUSED');
                                    }

                                    //else creating the answer
                                    else {
                                        $assocQuestion = $this->Question->find('first', array(
                                            'conditions' => array(
                                                'internal_name' => $fixedKey
                                            )
                                                ));
                                        $this->Answer->create();
                                        $answerToSave = array(
                                            'question_id' => $assocQuestion['Question']['id'],
                                            'client_id' => $this->Client->id,
                                            'survey_instance_id' => $this->SurveyInstance->id,
                                            'value' => 'REFUSED',
                                            'isDeleted' => 0,
                                        );
                                        $this->Answer->save($answerToSave);
                                    }
                                }
                                break;

                            //other
                            /*case ("OTHER"):
                                if (!empty($value)) {
                                    $fixedKey = str_replace(' - OTHER', '', $key);
                                    $assocAnswer = $this->Answer->find('first', array(
                                        'conditions' => array(
                                            'Question.internal_name' => $fixedKey
                                        )
                                            ));
                                    $this->Answer->id = $assocAnswer['Answer']['id'];
                                    $this->Answer->saveField('value', $value);
                                }
                                break;

                            //checkbox with other
                            case("checkbox other"):
                                if (!empty($value)) {
                                    $fixedKey = str_replace(' - checkbox other', '', $key);
                                    $assocQuestion = $this->Question->find('first', array(
                                        'conditions' => array(
                                            'internal_name' => $fixedKey
                                        )
                                            ));
                                    $this->Answer->create();
                                    $answerToSave = array(
                                        'question_id' => $assocQuestion['Question']['id'],
                                        'client_id' => $this->Client->id,
                                        'survey_instance_id' => $this->SurveyInstance->id,
                                        'value' => $value,
                                        'isDeleted' => 0,
                                    );
                                    $this->Answer->save($answerToSave);
                                }
                                break; */
                        }
                    }
                }

                //update vi score
                $id = $this->SurveyInstance->id;
                $survey = $this->SurveyInstance->read(null, $id);
                $criterion = $this->ViCriterium->find('first', array('conditions' => array('ViCriterium.type' => 'age')));
                if (count($criterion) > 0) {
                    $vi_score += $this->calculate_age_score(
                            $this->request->data['Client']['dob'], $criterion['ViCriterium']['values'], $criterion['ViCriterium']['relational_operator'], $criterion['ViCriterium']['weight']
                    );
                }
                $survey['SurveyInstance']['vi_score'] = $vi_score;
                $this->SurveyInstance->save($survey);

                $this->Session->setFlash(__('This Survey has been saved!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash("The Survey Could not Be Saved");
                
                //need to update date to be in the correct format for displaying
                $this->request->data['Client']['dob'] = $this->request->data['dateDOB'];
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        /*         * *************************** RETRIEVING DATA *********************** */
        $surveyInstance = $this->SurveyInstance->read(null, $id);
        $client = $this->Client->find('first', array(
            'conditions' => array(
                'Client.id' => $surveyInstance['SurveyInstance']['client_id']
            )
        ));
        $current_user = $this->Auth->user();
        $this->Survey->recursive = -1;
        $activeSurvey = $this->Survey->find('first', array(
            'conditions' => array(
                'isActive' => 1,
                'Survey.organization_id' => $current_user['organization_id']
            )
        ));
        
        if (empty($activeSurvey)) {
            $this->Session->setFlash("No Active Surveys Exist For Your Organization");
            $this->redirect(array('action' => 'index'));
        }

        $this->Grouping->recursive = -1;
        $groupings = $this->Grouping->find('all', array(
            'conditions' => array(
                'Grouping.survey_id' => $activeSurvey['Survey']['id']
            )
        ));
        

        //used to fill out the organization drop down box
        $organization_id = $current_user['organization_id'];
        $this->set(compact('activeSurvey'));
        $this->set('organization_id', $organization_id);

        /*         * ********************************** VALIDATIONS ******************************** */
        foreach ($groupings as &$grouping) {

            $grouping_questions = $this->Question->find('all', array(
                'recursive' => 0,
                'conditions' => array(
                    'Question.survey_id' => $activeSurvey['Survey']['id'],
                    'Question.grouping_id' => $grouping['Grouping']['id']
                ) 
            ));

            $grouping['Question'] = array();
            foreach( $grouping_questions as &$ques )
            {
                //Get options if they exist
                $question_options = $this->Option->find('all', array(
                    'recursive' => -1,
                    'conditions' => array(
                        'Option.question_id' => $ques['Question']['id']
                    )
                ));

                foreach( $question_options as $option)
                {
                    $ques['Option'][] = $option['Option'];
                }
                $grouping['Question'][] = $ques;
            }
            unset($ques);

            unset($grouping_questions); //free up some space

            foreach ($grouping['Question'] as $question) {
                $this->add_validations($question);
            }
        }

        unset($grouping);
        //debug($groupings);
        $personalInformationGrouping = $groupings[0];
        $this->set(compact('groupings', 'personalInformationGrouping'));

        /*         * **************************** POST ********************************* */
        if ($this->request->is('post') || $this->request->is('put')) {
            //first, we need to save data into the client table
            $this->Client->id = $client['Client']['id'];
            $this->request->data['Client']['organization_id'] = $client['Client']['organization_id'];
            $this->request->data['Client']['id'] = $this->Client->id;
            $this->request->data['Client']['dob'] = date("Y-m-d", strtotime($this->request->data['dateDOB']));

            //debug($this->request->data);
            if ($this->Client->save($this->request->data)) {

                //used to calculate vi_score as we go along
                $vi_score = 0;

                //used to help with saving other.
                $total_values = array();

                //then we need to save all the answers
                foreach ($groupings as $grouping) {
                    foreach ($grouping['Question'] as $question) {
                        if (!isset($this->request->data['Client'][$question['Question']['internal_name']]))
                            continue;

                        $values = $this->request->data['Client'][$question['Question']['internal_name']];

                        if (gettype($values) != 'array') {
                            $valuesTemp = $values;
                            $values = array();
                            $values[0] = $valuesTemp;
                        }

                        $values = $this->add_additional_values($values, $this->request->data['Client'], $question['Question']['internal_name']);

                        //figure out if there is a vi_criterion for this question
                        $criteria = $this->ViCriterium->find('all', array('conditions' => array('ViCriterium.question_id' => intval($question['Question']['id']))));

                        //highly inefficient but I need the primary key so that it is updated instead of a new answer created.
                        $resp = $this->Answer->find('all', array(
                            'recursive' => -1, 
                            'conditions' => array(
                                'question_id' => $question['Question']['id'], 
                                'client_id' => $this->Client->id,
                                'survey_instance_id' => $this->SurveyInstance->id
                            )
                        ));

                        //debug( $values );
                        for( $i = count($values); $i < count($resp); $i++ ) //mark extra values as deleted
                        {
                            $this->Answer->id = $resp[$i]['Answer']['id'];
                            $this->Answer->saveField('isDeleted', 1);
                        }
                        $this->Answer->id = null;

                        $i = 0;
                        //this is a much more coherent way of doing it. 
                        foreach ($values as $value) {
                            
                            //debug($value);
                            if( isset($resp[$i]) && isset($resp[$i]['Answer']['value']) )
                            {
                               $resp[$i]['Answer']['value'] = $value;
                               $resp[$i]['Answer']['isDeleted'] = 0;
                               $this->Answer->save($resp[$i]);
                            }
                            else //if it doesn't previously exist create a new entry
                            {
                                $answerToSave = array(
                                    'question_id' => $question['Question']['id'],
                                    'client_id' => $this->Client->id,
                                    'survey_instance_id' => $this->SurveyInstance->id,
                                    'value' => $value,
                                    'isDeleted' => 0,
                                );
                                $this->Answer->create();
                                $this->Answer->save($answerToSave);
                            }
                            $i++;

                            foreach ($criteria as $criterion) {
                                
                                if (strpos($criterion['ViCriterium']['values'], ',') === false) {
                                    $criterion_values = array($criterion['ViCriterium']['values']);
                                } else {
                                    $criterion_values = explode(',', $criterion['ViCriterium']['values']);
                                }
                                foreach ($criterion_values as $c_value) {
                                    switch ($criterion['ViCriterium']['relational_operator']) {
                                        case '<':
                                            if ($value < $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                            }
                                            break;
                                        case '>':
                                            if ($value > $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                            }
                                            break;
                                        case '=':
                                            if ($value == $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                            }
                                            break;
                                        case '<=':
                                            if ($value <= $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                            }
                                            break;
                                        case '>=':
                                            if ($value >= $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                            }
                                            break;
                                    }
                                }
                            }
                        }
                    }
                }

                //suffix logic
                foreach ($this->request->data['Client'] as $key => $value) {
                    $values = explode(" - ", $key);

                    if (count($values) > 1) {
                        $suffix = end($values);

                        switch ($suffix) {

                            //months-years
                            case ("YEARS"):
                                if (!empty($value)) {
                                    $fixedKey = str_replace(' - YEARS', '', $key);
                                    $months = $this->request->data['Client'][$fixedKey . ' - MONTHS'];
                                    $assocQuestion = $this->Question->find('first', array(
                                        'conditions' => array(
                                            'internal_name' => $fixedKey
                                        )
                                            ));
                                    $value = $value . ' years, ' . $months . ' months';

                                    $answerToSave = array(
                                        'question_id' => $assocQuestion['Question']['id'],
                                        'client_id' => $this->Client->id,
                                        'survey_instance_id' => $id,
                                        'value' => $value,
                                        'isDeleted' => 0,
                                    );
                                    $this->Answer->save($answerToSave);
                                }
                                break;

                            //refused
                            case ("REFUSED"):
                                if ($value == 1) {
                                    $fixedKey = str_replace(' - REFUSED', '', $key);
                                    $assocAnswer = $this->Answer->find('first', array(
                                        'conditions' => array(
                                            'Question.internal_name' => $fixedKey
                                        )
                                            ));

                                    //overwriting question if exists with 'REFUSED'
                                    if (!empty($assocAnswer)) {
                                        $this->Answer->id = $assocAnswer['Answer']['id'];
                                        $this->Answer->saveField('value', 'REFUSED');
                                    }

                                    //else creating the answer
                                    else {
                                        $assocQuestion = $this->Question->find('first', array(
                                            'conditions' => array(
                                                'internal_name' => $fixedKey
                                            )
                                                ));

                                        $answerToSave = array(
                                            'question_id' => $assocQuestion['Question']['id'],
                                            'client_id' => $this->Client->id,
                                            'survey_instance_id' => $id,
                                            'value' => 'REFUSED',
                                            'isDeleted' => 0,
                                        );
                                        $this->Answer->save($answerToSave);
                                    }
                                }
                                break;

                            //other ---- this logic has been moved
                            /*case ("OTHER"):
                                if (!empty($value)) {
                                    $fixedKey = str_replace(' - OTHER', '', $key);
                                    $assocAnswer = $this->Answer->find('first', array(
                                        'conditions' => array(
                                            'Question.internal_name' => $fixedKey
                                        )
                                            ));
                                    $this->Answer->id = $assocAnswer['Answer']['id'];
                                    $this->Answer->saveField('value', $value);
                                }
                                break;

                            //checkbox with other  ---- this logic has been moved.
                            case("checkbox other"):
                                if (!empty($value)) {
                                    $fixedKey = str_replace(' - checkbox other', '', $key);
                                    $assocQuestion = $this->Question->find('first', array(
                                        'conditions' => array(
                                            'internal_name' => $fixedKey
                                        )
                                    ));

                                    debug("Here");
                                    $answerToSave = array(
                                        'question_id' => $assocQuestion['Question']['id'],
                                        'client_id' => $this->Client->id,
                                        'survey_instance_id' => $id,
                                        'value' => $value,
                                        'isDeleted' => 0,
                                    );
                                    //$this->Answer->save($answerToSave);
                                }
                                break;
                            */
                        }
                    }
                }

                //update vi score
//                    $id = $this->SurveyInstance->id;
                $survey = $this->SurveyInstance->read(null, $id);
                $criterion = $this->ViCriterium->find('first', array('conditions' => array('ViCriterium.type' => 'age')));
                if (count($criterion) > 0) {
                    $vi_score += $this->calculate_age_score(
                            $this->request->data['Client']['dob'], $criterion['ViCriterium']['values'], $criterion['ViCriterium']['relational_operator'], $criterion['ViCriterium']['weight']
                    );
                }
                $survey['SurveyInstance']['vi_score'] = $vi_score;
                $this->SurveyInstance->save($survey);

                $this->Session->setFlash(__('This Survey has been saved!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash("The Client Could not Be Saved");
                $this->request->data['Client']['dob'] = date("m/d/Y", strtotime($this->request->data['Client']['dob']));

            }
        } else {

            /*             * ********************** AUTOPOPULATING DATA ************************ */

            $this->request->data['Client']['first_name'] = $client['Client']['first_name'];
            $this->request->data['Client']['middle_name'] = $client['Client']['middle_name'];
            $this->request->data['Client']['last_name'] = $client['Client']['last_name'];
            $this->request->data['Client']['nickname'] = $client['Client']['nickname'];
            $this->request->data['Client']['photoName'] = $client['Client']['photoName'];
            $this->request->data['Client']['ssn'] = $client['Client']['ssn'];
            $this->request->data['Client']['dob'] = date("m/d/Y", strtotime($client['Client']['dob']));
            $this->request->data['Client']['phone_number'] = $client['Client']['phone_number'];
            $this->Option->recursive = -1;

            foreach ($groupings as $grouping) {
                foreach ($grouping['Question'] as $question) {
                    $answer = $this->Answer->find('all', array(
                        'conditions' => array(
                            'question_id' => $question['Question']['id'],
                            'Answer.client_id' => $client['Client']['id'],
                            'Answer.survey_instance_id' => $id,
                            'Answer.isDeleted' => 0
                        )
                    ));

                    $autopopulateQ = $question['Question']['internal_name'];

                    $final_answer = array();
                    foreach( $answer as $ans )
                    {
                        $final_answer[] = $ans['Answer']['value'];
                    }

                    if( count($final_answer) === 0 ) $final_answer[] = null;

                    //putting "other" value in the right place
                    if ($question['Type']['label'] == 'selectWithOther' || $question['Type']['label'] == "checkboxWithOther") {
                        $options = $this->Option->find('all', array(
                            'conditions' => array(
                                'Option.question_id' => $question['Question']['id']
                            )
                        ));

                        $i = 0;
                        foreach( $answer as $ans )
                        {
                            $sentinel = true;
                            foreach ($options as $option) {
                                if ($option['Option']['label'] == $ans['Answer']['value']) {
                                    $sentinel = false;
                                    break;
                                }
                            }

                            if ($sentinel) {
                                if ($question['Type']['label'] == 'selectWithOther')
                                {
                                    $autopopulateQ = $autopopulateQ . " - OTHER";
                                }
                                else
                                {
                                    $this->request->data['Client'][$autopopulateQ . ' - checkbox other'] = $ans['Answer']['value'];
                                    unset($final_answer[$i]);
                                }
                            }

                            $i++;
                        }
                    }

                    if( count($final_answer) > 0 )
                    {
                        $this->request->data['Client'][$autopopulateQ] = (count($final_answer) > 1) ? $final_answer : $final_answer[0];
                    }
                }
            }
        }
    }

    /**
     * delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->SurveyInstance->id = $id;
        if (!$this->SurveyInstance->exists()) {
            throw new NotFoundException(__('Invalid survey instance'));
        }
        if ($this->SurveyInstance->delete()) {
            $this->Session->setFlash(__('Survey deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Survey was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * This is will the reports will be.
     * @return void
     */
    public function admin_index($survey_id = null) {
        $this->render_reports_page($survey_id);
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->SurveyInstance->id = $id;
        if (!$this->SurveyInstance->exists()) {
            throw new NotFoundException(__('Invalid survey instance'));
        }
        $this->set('surveyInstance', $this->SurveyInstance->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->SurveyInstance->create();
            if ($this->SurveyInstance->save($this->request->data)) {
                $this->Session->setFlash(__('The survey instance has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The survey instance could not be saved. Please, try again.'));
            }
        }
        $surveys = $this->SurveyInstance->Survey->find('list');
        $clients = $this->SurveyInstance->Client->find('list');
        $users = $this->SurveyInstance->User->find('list');
        $this->set(compact('surveys', 'clients', 'users'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->SurveyInstance->id = $id;
        if (!$this->SurveyInstance->exists()) {
            throw new NotFoundException(__('Invalid survey instance'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->SurveyInstance->save($this->request->data)) {
                $this->Session->setFlash(__('The survey instance has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The survey instance could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->SurveyInstance->read(null, $id);
        }
        $surveys = $this->SurveyInstance->Survey->find('list');
        $clients = $this->SurveyInstance->Client->find('list');
        $users = $this->SurveyInstance->User->find('list');
        $this->set(compact('surveys', 'clients', 'users'));
    }

    /**
     * admin_delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->SurveyInstance->id = $id;
        if (!$this->SurveyInstance->exists()) {
            throw new NotFoundException(__('Invalid survey instance'));
        }
        if ($this->SurveyInstance->delete()) {
            $this->Session->setFlash(__('Survey instance deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Survey instance was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

//Lee -- cannot beileve PHP doesn't have this built in
    function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public function dataTables() {
        $aColumns = explode(',',$this->params['url']['aColumns']);
        $survey_id = $this->params['url']['survey_id'];

        $params = array('recursive' => 0, 'custom' => true);

//Paging
        if (isset($this->params['url']['iDisplayStart']) && $this->params['url']['iDisplayLength'] != '-1') {
            $params['limit'] = $this->params['url']['iDisplayLength'];
            $params['offset'] = $this->params['url']['iDisplayStart'];
        }

//Sorting
        if (isset($this->params['url']['iSortCol_0'])) {
            $order = array();
            for ($i = 0; $i < intval($this->params['url']['iSortingCols']); $i++) {
                if ($this->params['url']['bSortable_' . intval($this->params['url']['iSortCol_' . $i])] == "true") {
                    $order[] = $aColumns[intval($this->params['url']['iSortCol_' . $i])] . ' ' . $this->params['url']['sSortDir_' . $i];
                }
            }

            $params['order'] = $order;
        }

//Filtering---the actual search bar
        if (isset($this->params['url']['sSearch']) && $this->params['url']['sSearch'] != "") {
            $comma = strpos($this->params['url']['sSearch'], ',');
            $space = strpos($this->params['url']['sSearch'], ' ');

            $conditions = array('OR' => array());
            for ($i = 0; $i < count($aColumns); $i++) {
                if (isset($this->params['url']['bSearchable_' . $i]) && $this->params['url']['bSearchable_' . $i] == "true") {
                    $conditions['OR'][$aColumns[$i] . ' LIKE '] = $this->params['url']['sSearch'] . '%';
                }
            }

            $params['conditions'] = $conditions;
        }

        if (isset($this->params['url']['user_id'])) {
            $params['conditions']['SurveyInstance.user_id'] = $this->params['url']['user_id'];
        }

        $raw_data = $this->SurveyInstance->getMostRecentSurveyInstanceForEachUser($survey_id, 'all', $aColumns, $params);

        $total = $this->SurveyInstance->getMostRecentSurveyInstanceForEachUser($survey_id, 'count', $aColumns, array('custom' => true));

        if (isset($params['conditions'])) {
            $filteredTotal = $this->SurveyInstance->getMostRecentSurveyInstanceForEachUser($survey_id, 'count', $aColumns, array('custom' => true, 'conditions' => $params['conditions']));
        } else {
            $filteredTotal = $total;
        }

        $output = array(
            'sEcho' => intval($this->params['url']['sEcho']),
            'iTotalRecords' => $total,
            'iTotalDisplayRecords' => $filteredTotal,
            'aaData' => array()
        );

        foreach ($raw_data as $result) {
            $row = array();
            foreach ($aColumns as $column) {
                if (($pos = strpos($column, '.')) !== false) {
                    if (substr($column, $pos + 1) === 'dob') {
                        $row[] = date('m/d/Y', strtotime(h($result[substr($column, 0, $pos)]['dob'])));
                    } else {
                        $row[] = $result[substr($column, 0, $pos)][substr($column, $pos + 1)];
                    }
                } else {
                    $row[] = $result['Custom'][$column];
                }
            }
            $row['DT_RowId'] = 'client_' . $result['Client']['id'];
            $output['aaData'][] = $row;
        }
        $this->set('output', $output);
    }

    public function reports($survey_id = null) {
        $this->render_reports_page($survey_id);
        $cur_user = $this->Auth->user();
        $this->set('user_id', $cur_user['id']);
    }

    public function render_reports_page($survey_id = null) {
        if ($survey_id == null) {
            $user = $this->Auth->user();
            $surveys = $this->SurveyInstance->Survey->getSurveysForOrganization($user['organization_id'], 'list');
            $this->set(compact('surveys'));
            $this->render("select_survey");
        }
        else
        {
            $this->SurveyInstance->Survey->id = $survey_id;
            $internal_names = $this->SurveyInstance->Survey->getInternalNamesList();
            $this->set(compact('internal_names'));

            //Create google chart for vi score
            $resp = $this->SurveyInstance->getMostRecentSurveyInstanceForEachUser($survey_id, 'all', array('SurveyInstance.vi_score'));

            //group all results and get max score
            $vi_score_count = array();
            $max_score = 0;
            foreach( $resp as $r )
            {
                $vi_score = $r['SurveyInstance']['vi_score'];
                if( isset($vi_score_count[$vi_score]) )
                {
                    $vi_score_count[$vi_score]++;
                }
                else
                {
                    $vi_score_count[$vi_score] = 1;
                }

                if( $vi_score > $max_score ) $max_score = $vi_score;
            }

            $max_count = 0;
            foreach( $vi_score_count as $count )
            {
                if( $count > $max_count ) $max_count = $count;
            }

            $chart = new GoogleChart();
            $chart->type("ColumnChart");
            $chart->options(array(
                'title' => 'Total VI Scores',
                'width' => '750',
                'vAxis' => array(
                    'viewWindow' => array(
                        'min' => 0,
                        'max' => $max_count + 1)),
            ));
            $chart->columns(array(
                'score' => array(
                    'type' => 'number',
                    'label' => 'VI Score'
                ),
                'counts' => array(
                    'type' => 'number',
                    'label' => 'Total'
                )
            ));

            foreach( $vi_score_count as $score => $count )
            {
                $chart->addRow(array('score' => floatval($score), 'counts' => intVal($count)));
            }

            $chart->div('charts_div');
            $this->set(compact('chart'));
        }
    }

    public function checkIfClientExists() {
        $user = $this->Auth->user();
        $userOrganization = $user['organization_id'];
        $firstName = $this->request->data('firstName');
        $lastName = $this->request->data('lastName');
        $dob = $this->request->data('dob');
        $ssn = $this->request->data('ssn');
        $client = $this->Client->find('first', array(
            'conditions' => array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'dob' => $dob,
                'ssn' => $ssn,
                'organization_id' => $userOrganization
            )
        ));

        $response = 0;
        if (!empty($client))
            $response = $client['Client']['id'];
        $this->set('response', $response);
    }

    private function calculate_age_score($dob, $age_threshold, $relational_operator, $weight) {
        $age = $this->get_current_age($dob);
        $score = 0;

        switch ($relational_operator) {
            case '<':
                if ($age < $age_threshold) {
                    $score += $weight;
                }
                break;
            case '>':
                if ($age > $age_threshold) {
                    $score += $weight;
                }
                break;
            case '=':
                if ($age == $age_threshold) {
                    $score += $weight;
                }
                break;
            case '<=':
                if ($age <= $age_threshold) {
                    $score += $weight;
                }
                break;
            case '>=':
                if ($age >= $age_threshold) {
                    $score += $weight;
                }
                break;
        }

        return $score;
    }

    private function get_current_age($dob) {
        list($y, $m, $d) = explode('-', $dob);

        if (($m = (date('m') - $m)) < 0) {
            $y++;
        } elseif ($m == 0 && date('d') - $d < 0) {
            $y++;
        }

        return date('Y') - $y;
    }

    public function export_xls() {
        $clientData = $this->Client->find('all');
        $this->set('rows', $clientData);
        $this->render('export_xls', 'export_xls');
    }

    private function add_validations($question)
    {
        $validations = array(
            $question['Question']['validation_1'] => $question['Question']['v_message_1'], 
            $question['Question']['validation_2'] => $question['Question']['v_message_2'], 
            $question['Question']['validation_3'] => $question['Question']['v_message_3'],
            $question['Question']['validation_4'] => $question['Question']['v_message_4']
        );

        if( $question['Type']['label'] === "checkboxWithOther" )
        {
            if ($question['Question']['is_required']) {
                $this->add_combo_required_validation($question['Question']['internal_name'], 'checkbox other');
            }

            foreach($validations as $validation => $message)
            {
                if( $validation != null )
                {
                    $this->add_combined_field_validation($question['Question']['internal_name'], 'checkbox other', $validation, $validation, $message, 'AND');
                }
            }
        }
        elseif( $question['Type']['label'] === "selectWithOther" )
        {
            if ($question['Question']['is_required']) {
                $this->add_combo_required_validation($question['Question']['internal_name'], 'OTHER');
            }

            foreach($validations as $validation => $message)
            {
                if( $validation != null )
                {
                    $this->add_combined_field_validation($question['Question']['internal_name'], 'OTHER', $validation, $validation, $message, 'AND');
                }
            }
        }
        elseif( strpos($question['Type']['label'], 'WithRefused') !== false )
        {
            if ($question['Question']['is_required']) {
                $this->Client->validator()->add($question['Question']['internal_name'], 'refused_required', array(
                    'rule' => array(
                        'refused_rule',
                        $question['Question']['internal_name'] . ' - REFUSED',
                        'notEmpty',
                    ),
                    'message' => 'A value must be entered or "Refused" should be checked!'
                ));
            }

            foreach($validations as $validation => $message)
            {
                if( $validation != null )
                {
                    $this->add_combined_field_validation($question['Question']['internal_name'], 'REFUSED', $validation, $validation, $message, 'AND');
                }
            }
        }
        else
        {
            if ($question['Question']['is_required']) {
                $this->Client->validator()->add($question['Question']['internal_name'], 'required', array('rule' => 'notEmpty', 'message' => 'A value must be entered!'));
            }

            foreach( $validations as $validation => $message )
            {
                if( $validation != null ) $this->Client->validator()->add($question['Question']['internal_name'], $validation, array(
                    'rule' => $validation,
                    'allowEmpty' => true,
                    'message' => $message
                ));
            }
        }
    }

    private function add_combo_required_validation($internal_name, $extension)
    {
        $this->add_combined_field_validation($internal_name, $extension, 'combo_required', 'notEmpty', 'A value must be entered!', 'OR');
    }

    private function add_combined_field_validation($internal_name, $extension, $rule_name, $rule, $message, $and_or)
    {
        $this->Client->validator()->add($internal_name, $rule_name, array(
            'rule' => array(
                'combined_field_rule',
                $internal_name . ' - ' . $extension,
                $rule,
                $and_or
            ),
            'message' => $message
        ));
    }

    private function add_additional_values($values, $request, $internal_name)
    {
        //if it is a checkbox with other and there is another value append it to the values
        if( isset( $request[$internal_name . ' - checkbox other']) && 
            $request[$internal_name . ' - checkbox other'] != null )
        {
            $values[] = $request[$internal_name . ' - checkbox other'];
        }

        //if it is a select with other replace the original value with the other value
        if( isset( $request[$internal_name . ' - OTHER']) &&
            $request[$internal_name . ' - OTHER'] != null )
        {
            $values[0] = $request[$internal_name . ' - OTHER'];
        }

        return $values;
    }


    public function custom_xls()
    {
        $aColumns = explode(',',$this->params['url']['aColumns']);
        $survey_id = $this->params['url']['survey_id'];

        $params = array('recursive' => 0, 'custom' => true);

        //No paging, sorting, filtering for this so that everything is returned

        if (isset($this->params['url']['user_id'])) {
            $params['conditions']['SurveyInstance.user_id'] = $this->params['url']['user_id'];
        }

        $raw_data = $this->SurveyInstance->getMostRecentSurveyInstanceForEachUser($survey_id, 'all', $aColumns, $params);

        $output = array();

        foreach ($raw_data as $result) {
            $row = array();
            foreach ($aColumns as $column) {
                if (($pos = strpos($column, '.')) !== false) {
                    if (substr($column, $pos + 1) === 'dob') {
                        $row[] = date('m/d/Y', strtotime(h($result[substr($column, 0, $pos)]['dob'])));
                    } else {
                        $row[] = $result[substr($column, 0, $pos)][substr($column, $pos + 1)];
                    }
                } else {
                    $row[] = $result['Custom'][$column];
                }
            }
            $output[] = $row;
        }

        $header = array();
        foreach( $aColumns as $column )
        {
            $pos = strpos($column, '.');
            if( $pos !== false ) 
                $out = substr($column, $pos + 1);
            else
                $out = $column;
            $out = str_replace('_', ' ', $out);
            $header[] = $out;
        }

        $this->set('output', $output);
        $this->set('header', $header);
        $this->render('custom_xls', 'export_xls');
    }
}