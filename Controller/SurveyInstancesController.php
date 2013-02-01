<?php

App::uses('AppController', 'Controller');

/**
 * SurveyInstances Controller
 *
 * @property SurveyInstance $SurveyInstance
 */
class SurveyInstancesController extends AppController {

    public $uses = array('Grouping', 'Survey', 'SurveyInstance', 'Client', 'Question', 'Type', 'Organization', 'Answer', 'Option');
    public $helpers = array('Question');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->SurveyInstance->recursive = 0;
        $user = $this->Auth->user();
        $user_id = $user['id'];
        $activeSurvey = $this->Survey->find('first', array(
            'conditions' => array(
                'Survey.isActive' => 1,
                'Survey.organization_id' => $user['organization_id']
            )
                ));
        $this->paginate = array(
            'conditions' => array(
                'survey_id' => $activeSurvey['Survey']['id']
            )
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
        $this->SurveyInstance->recursive = 4;
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
        $this->Survey->recursive = 3;
        $activeSurvey = $this->Survey->find('first', array(
            'conditions' => array(
                'isActive' => 1
            )
                ));

        $groupings = $activeSurvey['Grouping'];
        $personalInformationGrouping = $groupings[0];

        //used to fill out the organization drop down box
        $organizations = $this->Organization->find('list');
        $this->set(compact('activeSurvey', 'groupings', 'personalInformationGrouping', 'organizations'));

        /*         * ********************************** VALIDATIONS ******************************** */
        foreach ($groupings as $grouping) {
            foreach ($grouping['Question'] as $question) {
                $validations = array($question['validation_1'], $question['validation_2'],
                    $question['validation_3'], $question['validation_4']);

                if( $question['is_required'] == true )
                {
                    $validations[] = 'notEmpty';
                }
                
                $this->Client->addValidator($question['internal_name'], $validations);
            }
        }

        /*         * **************************** POST ********************************* */
        if ($this->request->is('post')) {

            //first, we need to save data into the client table
            $this->Client->create();
            if ($this->Client->save($this->request->data)) {

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

                //then we need to save all the answers
                $data['Answer'] = array();
                foreach ($groupings as $grouping) {
                    $i = 0;
                    foreach ($grouping['Question'] as $question) {
                        $values = $this->request->data['Client'][$question['internal_name']];
                        if (gettype($values) != 'array')
                            $values = array($values);

                        foreach ($values as $value) {
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

                    if ($this->endsWith($key, ' - REFUSED') && $value == 1) {
                        $fixedKey = str_replace(' - REFUSED', '', $key);
                        $assocAnswer = $this->Answer->find('first', array(
                            'conditions' => array(
                                'Question.internal_name' => $fixedKey
                            )
                                ));
                        $this->Answer->id = $assocAnswer['Answer']['id'];
                        $this->Answer->saveField('value', 'REFUSED');
                    }

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
                }

                $this->Session->setFlash(__('This Survey has been saved!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The survey instance could not be saved. Please, try again.'));
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
        $this->Survey->recursive = 3;
        $activeSurvey = $this->SurveyInstance->Survey->find('first', array(
            'conditions' => array(
                'isActive' => 1
            )
                ));

        $groupings = $activeSurvey['Grouping'];
        $personalInformationGrouping = $groupings[0];

        //used to fill out the organization drop down box
        $organizations = $this->Organization->find('list');
        $this->set(compact('activeSurvey', 'groupings', 'personalInformationGrouping', 'organizations'));

        /*         * ********************** AUTOPOPULATING DATA ************************ */
        $surveyInstance = $activeSurvey['SurveyInstance'][0];
        $clientID = $surveyInstance['client_id'];
        $client = $this->Client->read(null, $surveyInstance['client_id']);

        $dataArray = array(
            'Client' => array(
                'id' => $clientID,
                'first_name' => $client['Client']['first_name'],
                'last_name' => $client['Client']['last_name'],
                'organization_id' => $client['Client']['organization_id'],
                'ssn' => $client['Client']['ssn'],
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
                $this->Client->addValidator($question['internal_name'], $validations);
            }
        }

        /*         * **************************** POST ********************************* */
        if ($this->request->is('post')) {

            //first, we need to save data into the client table
            $this->request->data['Client']['id'] = $clientID;
            if ($this->Client->save($this->request->data)) {

                //then we need to update all the answers
                foreach ($groupings as $grouping) {
                    foreach ($grouping['Question'] as $question) {
                        $values = $this->request->data['Client'][$question['internal_name']];
                        if (gettype($values) != 'array')
                            $values = array($values);

                        foreach ($values as $value) {
                            $assocAnswer = $this->Answer->find('first', array(
                                'conditions' => array(
                                    'Question.internal_name' => $question['internal_name']
                                )
                                    ));
                            $this->Answer->id = $assocAnswer['Answer']['id'];
                            $this->Answer->saveField('value', $value);
                        }
                    }
                }

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
            $this->Session->setFlash(__('Survey instance deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Survey instance was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->SurveyInstance->recursive = 0;
        $this->set('surveyInstances', $this->paginate());
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

}
