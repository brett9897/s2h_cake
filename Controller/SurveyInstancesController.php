<?php

App::uses('AppController', 'Controller');

/**
 * SurveyInstances Controller
 *
 * @property SurveyInstance $SurveyInstance
 */
class SurveyInstancesController extends AppController {

    public $uses = array('Grouping', 'Survey', 'SurveyInstance', 'Client', 'Question', 'Type', 'Organization', 'Answer', 'Option', 'ViCriterium');
    public $helpers = array('Question', 'Html');
    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->validatePost = false;
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->SurveyInstance->recursive = 0;
        $user = $this->Auth->user();
        $user_id = $user['id'];
        $conditions;

        if ($user['type'] == 'admin') {
            $activeSurvey = $this->SurveyInstance->find('first', array(
                'conditions' => array(
                    'Survey.isActive' => 1,
                    'Survey.organization_id' => $user['organization_id']
                    )));
            $this->paginate = array(
                'conditions' => array(
                    'survey_id' => $activeSurvey['Survey']['id'],
                )
            );
        } else if ($user['type'] == 'volunteer' || $user['type'] == 'user') {
            $activeSurvey = $this->SurveyInstance->find('first', array(
                'conditions' => array(
                    'Survey.isActive' => 1,
                    'Survey.organization_id' => $user['organization_id']
                    )));

            $this->paginate = array(
                'conditions' => array(
                    'survey_id' => $activeSurvey['Survey']['id'],
                    'SurveyInstance.user_id' => $user_id
                )
            );
        }
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
        $this->SurveyInstance->recursive = 3;
        $this->set('surveyInstance', $this->SurveyInstance->find('first', array(
                    'conditions' => array(
                        'SurveyInstance.id' => $id,
                        ))));
        $this->set('id', $id);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        /*         * *************************** RETRIEVING DATA *********************** */
        var_dump($this->Session->read('requestData'));
        $this->Survey->recursive = 3;
        $activeSurvey = $this->Survey->find('first', array(
            'conditions' => array(
                'isActive' => 1
            )
                ));

        $groupings = $activeSurvey['Grouping'];
        $personalInformationGrouping = $groupings[0];

        //used to fill out the organization drop down box
        $current_user = $this->Auth->user();
        $organization_id = $current_user['organization_id'];
        $this->set(compact('activeSurvey', 'groupings', 'personalInformationGrouping'));
        $this->set('organization_id', $organization_id);
        $this->set('remotePath', preg_quote("'" . APP . 'webroot' . DS . 'img' . DS . 'uploaded_images' . "'"));

        /*         * ********************************** VALIDATIONS ******************************** */
        foreach ($groupings as $grouping) {
            foreach ($grouping['Question'] as $question) {
                $validations = array($question['validation_1'], $question['validation_2'],
                    $question['validation_3'], $question['validation_4']);

                if ($question['is_required'])
                    $this->Client->addValidator($question['internal_name'], $validations);
            }
        }

        /*         * **************************** POST ********************************* */
        if ($this->request->is('post')) {
            //first, we need to save data into the client table
            $this->request->data['Client']['organization_id'] = $organization_id;

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
            $data = array('SurveyInstance' => array(
                    'survey_id' => $activeSurvey['Survey']['id'],
                    'client_id' => $this->Client->id,
                    'user_id' => $user_id,
                    'vi_score' => 0,
                    'is_Deleted' => 0
                    ));
            $this->SurveyInstance->save($data['SurveyInstance']);

            //used to calculate vi_score as we go along
            $vi_score = 0;

            //then we need to save all the answers
            $data['Answer'] = array();
            foreach ($groupings as $grouping) {
                $i = 0;
                foreach ($grouping['Question'] as $question) {
                    $values = $this->request->data['Client'][$question['internal_name']];
                    if (gettype($values) != 'array')
                        $values = array($values);

                    //figure out if there is a vi_criterion for this question
                    $criterion = $this->ViCriterium->find('first', array('conditions' => array('ViCriterium.question_id' => intval($question['id']))));
                    $found = false;

                    foreach ($values as $value) {
                        if (count($criterion) > 0) {
                            if (strpos($criterion['ViCriterium']['values'], ',') === false) {
                                $criterion_values = array($criterion['ViCriterium']['values']);
                            } else {
                                $criterion_values = explode(',', $criterion['ViCriterium']['values']);
                            }

                            if (!$found) {
                                foreach ($criterion_values as $c_value) {
                                    switch ($criterion['ViCriterium']['relational_operator']) {
                                        case '<':
                                            if ($value < $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                                $found = true;
                                            }
                                            break;
                                        case '>':
                                            if ($value > $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                                $found = true;
                                            }
                                            break;
                                        case '=':
                                            if ($value == $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                                $found = true;
                                            }
                                            break;
                                        case '<=':
                                            if ($value <= $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                                $found = true;
                                            }
                                            break;
                                        case '>=':
                                            if ($value >= $c_value) {
                                                $vi_score += $criterion['ViCriterium']['weight'];
                                                $found = true;
                                            }
                                            break;
                                    }
                                }
                            }
                        }
                        $this->Answer->create();
                        $data['Answer'][$i] = array(
                            'question_id' => $question['id'],
                            'client_id' => $this->Client->id,
                            'survey_instance_id' => $this->SurveyInstance->id,
                            'value' => $value,
                            'isDeleted' => 0,
                        );
                        $this->Answer->save($data['Answer'][$i]);
                    }
                }
            }

            //endsWith-other logic
            foreach ($this->request->data['Client'] as $key => $value) {

                //MONTHS-YEARS
                if ($this->endsWith($key, ' - YEARS') && !empty($value)) {
                    $fixedKey = str_replace(' - YEARS', '', $key);
                    $months = $this->request->data['Client'][$fixedKey . ' - MONTHS'];
                    $assocQuestion = $this->Question->find('first', array(
                        'conditions' => array(
                            'internal_name' => $fixedKey
                        )
                            ));
                    $value = $value . ' years, ' . $months . ' months';
                    $this->Answer->create();
                    $data['Answer'][0] = array(
                        'question_id' => $assocQuestion['Question']['id'],
                        'client_id' => $this->Client->id,
                        'survey_instance_id' => $this->SurveyInstance->id,
                        'value' => $value,
                        'isDeleted' => 0,
                    );
                    $this->Answer->save($data['Answer'][0]);
                }

                //REFUSED
                if ($this->endsWith($key, ' - REFUSED') && $value == 1) {
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
                        $data['Answer'][0] = array(
                            'question_id' => $assocQuestion['Question']['id'],
                            'client_id' => $this->Client->id,
                            'survey_instance_id' => $this->SurveyInstance->id,
                            'value' => 'REFUSED',
                            'isDeleted' => 0,
                        );
                        $this->Answer->save($data['Answer'][0]);
                    }
                }

                //OTHER
                if ($this->endsWith($key, ' - OTHER') && !empty($value)) {
                    $fixedKey = str_replace(' - OTHER', '', $key);
                    $assocAnswer = $this->Answer->find('first', array(
                        'conditions' => array(
                            'Question.internal_name' => $fixedKey
                        )
                            ));
                    $this->Answer->id = $assocAnswer['Answer']['id'];
                    $this->Answer->saveField('value', $value);
                }

                //CHECKBOX OTHER
                if ($this->endsWith($key, ' - checkbox other') && !empty($value)) {
                    $fixedKey = str_replace(' - checkbox other', '', $key);
                    $assocQuestion = $this->Question->find('first', array(
                        'conditions' => array(
                            'internal_name' => $fixedKey
                        )
                            ));
                    $this->Answer->create();
                    $data['Answer'][0] = array(
                        'question_id' => $assocQuestion['Question']['id'],
                        'client_id' => $this->Client->id,
                        'survey_instance_id' => $this->SurveyInstance->id,
                        'value' => $value,
                        'isDeleted' => 0,
                    );
                    $this->Answer->save($data['Answer'][0]);
                }
            }

            //update vi score
            $id = $this->SurveyInstance->id;
            $survey = $this->SurveyInstance->read(null, $id);
            $survey['SurveyInstance']['vi_score'] = $vi_score;
            $this->SurveyInstance->save($survey);

            $this->Session->setFlash(__('This Survey has been saved!'));
            $this->redirect(array('action' => 'index'));
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
        $this->Survey->recursive = 3;
        $activeSurvey = $this->Survey->find('first', array(
            'conditions' => array(
                'isActive' => 1
            )
                ));

        $groupings = $activeSurvey['Grouping'];
        $personalInformationGrouping = $groupings[0];

        //used to fill out the organization drop down box
        $current_user = $this->Auth->user();
        $organization_id = $current_user['organization_id'];
        $this->set(compact('activeSurvey', 'groupings', 'personalInformationGrouping'));
        $this->set('organization_id', $organization_id);
        $this->set('remotePath', preg_quote("'" . APP . 'webroot' . DS . 'img' . DS . 'uploaded_images' . "'"));

        /*         * ********************** AUTOPOPULATING DATA ************************ */
        $surveyInstance = $activeSurvey['SurveyInstance'][0];
        $clientID = $surveyInstance['client_id'];
        $client = $this->Client->read(null, $surveyInstance['client_id']);

        $dataArray = array(
            'Client' => array(
                'first_name' => $client['Client']['first_name'],
                'last_name' => $client['Client']['last_name'],
                'ssn' => $client['Client']['ssn'],
                'dob' => $client['Client']['dob']
            )
        );

        foreach ($groupings as $grouping) {
            foreach ($grouping['Question'] as $question) {
                $answer = $this->Answer->find('first', array(
                    'conditions' => array(
                        'question_id' => $question['id']
                    )
                        ));
                $dataArray['Client'][$question['internal_name']] = $answer['Answer']['value'];
            }
        }
        $this->data = $dataArray;

        /*         * ********************************** VALIDATIONS ******************************** */
        foreach ($groupings as $grouping) {
            foreach ($grouping['Question'] as $question) {
                $validations = array($question['validation_1'], $question['validation_2'],
                    $question['validation_3'], $question['validation_4']);

                if ($question['is_required'])
                    $this->Client->addValidator($question['internal_name'], $validations);
            }
        }

        /*         * **************************** POST ********************************* */
        if ($this->request->is('post')) {
            //first, we need to save data into the client table
            $this->Client->create();
            $this->request->data['Client']['organization_id'] = $organization_id;
            if ($this->Client->save($this->request->data)) {

                //then we need to create the survey instance
                $this->SurveyInstance->create();
                $user_id = $this->Auth->user();
                $user_id = $user_id['id'];
                $dataSurveyInstance = array('SurveyInstance' => array(
                        'survey_id' => $activeSurvey['Survey']['id'],
                        'client_id' => $this->Client->id,
                        'user_id' => $user_id,
                        'vi_score' => 0,
                        'is_Deleted' => 0
                        ));
                $this->SurveyInstance->save($dataSurveyInstance['SurveyInstance']);

                //used to calculate vi_score as we go along
                $vi_score = 0;

                //then we need to save all the answers
                $data['Answer'] = array();
                foreach ($groupings as $grouping) {
                    $i = 0;
                    foreach ($grouping['Question'] as $question) {
                        $values = $this->request->data['Client'][$question['internal_name']];
                        if (gettype($values) != 'array')
                            $values = array($values);

                        //figure out if there is a vi_criterion for this question
                        $criterion = $this->ViCriterium->find('first', array('conditions' => array('ViCriterium.question_id' => intval($question['id']))));
                        $found = false;

                        foreach ($values as $value) {
                            if (count($criterion) > 0) {
                                if (strpos($criterion['ViCriterium']['values'], ',') === false) {
                                    $criterion_values = array($criterion['ViCriterium']['values']);
                                } else {
                                    $criterion_values = explode(',', $criterion['ViCriterium']['values']);
                                }

                                if (!$found) {
                                    foreach ($criterion_values as $c_value) {
                                        switch ($criterion['ViCriterium']['relational_operator']) {
                                            case '<':
                                                if ($value < $c_value) {
                                                    $vi_score += $criterion['ViCriterium']['weight'];
                                                    $found = true;
                                                }
                                                break;
                                            case '>':
                                                if ($value > $c_value) {
                                                    $vi_score += $criterion['ViCriterium']['weight'];
                                                    $found = true;
                                                }
                                                break;
                                            case '=':
                                                if ($value == $c_value) {
                                                    $vi_score += $criterion['ViCriterium']['weight'];
                                                    $found = true;
                                                }
                                                break;
                                            case '<=':
                                                if ($value <= $c_value) {
                                                    $vi_score += $criterion['ViCriterium']['weight'];
                                                    $found = true;
                                                }
                                                break;
                                            case '>=':
                                                if ($value >= $c_value) {
                                                    $vi_score += $criterion['ViCriterium']['weight'];
                                                    $found = true;
                                                }
                                                break;
                                        }
                                    }
                                }
                            }
                            $this->Answer->create();
                            $data['Answer'][$i] = array(
                                'question_id' => $question['id'],
                                'client_id' => $this->Client->id,
                                'survey_instance_id' => $this->SurveyInstance->id,
                                'value' => $value,
                                'isDeleted' => 0,
                            );
                            $this->Answer->save($data['Answer'][$i]);
                        }
                    }
                }

                //endsWith-other logic
                foreach ($this->request->data['Client'] as $key => $value) {

                    //MONTHS-YEARS
                    if ($this->endsWith($key, ' - YEARS') && !empty($value)) {
                        $fixedKey = str_replace(' - YEARS', '', $key);
                        $months = $this->request->data['Client'][$fixedKey . ' - MONTHS'];
                        $assocQuestion = $this->Question->find('first', array(
                            'conditions' => array(
                                'internal_name' => $fixedKey
                            )
                                ));
                        $value = $value . ' years, ' . $months . ' months';
                        $this->Answer->create();
                        $data['Answer'][0] = array(
                            'question_id' => $assocQuestion['Question']['id'],
                            'client_id' => $this->Client->id,
                            'survey_instance_id' => $this->SurveyInstance->id,
                            'value' => $value,
                            'isDeleted' => 0,
                        );
                        $this->Answer->save($data['Answer'][0]);
                    }

                    //REFUSED
                    if ($this->endsWith($key, ' - REFUSED') && $value == 1) {
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
                            $data['Answer'][0] = array(
                                'question_id' => $assocQuestion['Question']['id'],
                                'client_id' => $this->Client->id,
                                'survey_instance_id' => $this->SurveyInstance->id,
                                'value' => 'REFUSED',
                                'isDeleted' => 0,
                            );
                            $this->Answer->save($data['Answer'][0]);
                        }
                    }

                    //OTHER
                    if ($this->endsWith($key, ' - OTHER') && !empty($value)) {
                        $fixedKey = str_replace(' - OTHER', '', $key);
                        $assocAnswer = $this->Answer->find('first', array(
                            'conditions' => array(
                                'Question.internal_name' => $fixedKey
                            )
                                ));
                        $this->Answer->id = $assocAnswer['Answer']['id'];
                        $this->Answer->saveField('value', $value);
                    }

                    //CHECKBOX OTHER
                    if ($this->endsWith($key, ' - checkbox other') && !empty($value)) {
                        $fixedKey = str_replace(' - checkbox other', '', $key);
                        $assocQuestion = $this->Question->find('first', array(
                            'conditions' => array(
                                'internal_name' => $fixedKey
                            )
                                ));
                        $this->Answer->create();
                        $data['Answer'][0] = array(
                            'question_id' => $assocQuestion['Question']['id'],
                            'client_id' => $this->Client->id,
                            'survey_instance_id' => $this->SurveyInstance->id,
                            'value' => $value,
                            'isDeleted' => 0,
                        );
                        $this->Answer->save($data['Answer'][0]);
                    }
                }

                //update vi score
                $id = $this->SurveyInstance->id;
                $survey = $this->SurveyInstance->read(null, $id);
                $survey['SurveyInstance']['vi_score'] = $vi_score;
                $this->SurveyInstance->save($survey);

                $this->Session->setFlash(__('This Survey has been saved!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The survey instance could not be saved. Please, try again.'));
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
        $aColumns = array('Client.first_name', 'Client.last_name', 'Client.dob', 'Client.ssn', 'SurveyInstance.vi_score');

        $survey_id = $this->params['url']['survey_id'];

        $params = array('recursive' => 0);

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

            if ($comma === false && $space === false) {
                $conditions = array('OR' => array());
                for ($i = 0; $i < count($aColumns); $i++) {
                    if (isset($this->params['url']['bSearchable_' . $i]) && $this->params['url']['bSearchable_' . $i] == "true") {
                        $conditions['OR'][$aColumns[$i] . ' LIKE '] = $this->params['url']['sSearch'] . '%';
                    }
                }
            } else {
                if ($comma !== false) {
                    $firstName = trim(substr($this->params['url']['sSearch'], $comma + 1));
                    $lastName = trim(substr($this->params['url']['sSearch'], 0, $comma));
                } else {
                    $firstName = trim(substr($this->params['url']['sSearch'], 0, $space));
                    $lastName = trim(substr($this->params['url']['sSearch'], $space + 1));
                }

                $conditions = array(
                    $aColumns[0] . ' LIKE ' => $firstName . '%',
                    $aColumns[1] . ' LIKE ' => $lastName . '%'
                );
            }

            $params['conditions'] = $conditions;
        }

        if (isset($this->params['url']['user_id'])) {
            $params['conditions']['SurveyInstance.user_id'] = $this->params['url']['user_id'];
        }

        $raw_data = $this->SurveyInstance->getMostRecentSurveyInstanceForEachUser($survey_id, 'all', $params);

        $total = $this->SurveyInstance->getMostRecentSurveyInstanceForEachUser($survey_id, 'count');

        if (isset($params['conditions'])) {
            $filteredTotal = $this->SurveyInstance->getMostRecentSurveyInstanceForEachUser($survey_id, 'count', array('conditions' => $params['conditions']));
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
            $row = array(
                $result['Client']['first_name'],
                $result['Client']['last_name'],
                date('m/d/Y', strtotime(h($result['Client']['dob']))),
                $result['Client']['ssn'],
                intVal($result['SurveyInstance']['vi_score']),
                'DT_RowId' => 'client_' . $result['Client']['id'],
            );
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

}
