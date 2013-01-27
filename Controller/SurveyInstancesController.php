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
        $activeSurvey = $this->SurveyInstance->find('first', array(
            'conditions' => array(
                'Survey.isActive' => 1,
                'SurveyInstance.user_id' => $user_id
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
                    'Survey.isActive' => 1,
                    'SurveyInstance.id' => $id
                ))));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        var_dump($this->request->data);
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
                        $values = $this->request->data['Client'][$question['label']];
                        if (gettype($values) != 'array')
                            $values = array($values);
                        foreach ($values as $value) {
                            $this->Answer->create();
                            $data['Answer'][$i] = array(
                                'question_id' => $question['id'],
                                'client_id' => $this->Client->id,
                                'value' => $value,
                                'isDeleted' => 0,
                            );
                            $this->Answer->save($data['Answer'][$i]);
                        }
                    };
                }
            }


            $this->Session->setFlash(__('This Survey has been saved!'));
            //   $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('The survey instance could not be saved. Please, try again.'));
        }
        // }
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
        var_dump($this->request->data);
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
        $surveyInstance = $this->SurveyInstance->read(null, $id);
        $client_id = $surveyInstance['SurveyInstance']['client_id'];
        $this->set('client_id', $client_id);
        $client = $this->Client->read(null, $client_id);
        $dataArray = array(
            'Client' => array(
                'id' => $this->Client->id,
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
                $dataArray['Client'][$question['label']] = $answer['Answer']['value'];
            }
        }
        $this->data = $dataArray;

        /*         * **************************** POST ********************************* */
        if ($this->request->is('post')) {

            //first, we need to save data into the client table
            $this->request->data['Client']['id'] = $client_id;
            if ($this->Client->save($this->request->data)) {

                //then we need to create the survey instance
                $this->SurveyInstance->id = $id;
                $user_id = $this->Auth->user();
                $user_id = $user_id['id'];
                $data = array('SurveyInstance' => array(
                        'id' => $id,
                        'survey_id' => $activeSurvey['Survey']['id'],
                        'client_id' => $this->Client->id,
                        'user_id' => $user_id,
                        'vi_score' => 0,
                        'is_Deleted' => 0
                        ));
                $this->SurveyInstance->save($data['SurveyInstance']);
                /**
                  //then we need to save all the answers
                  $data['Answer'] = array();
                  foreach ($groupings as $grouping) {
                  $i = 0;
                  foreach ($grouping['Question'] as $question) {
                  $values = $this->request->data['Client'][$question['label']];
                  if (gettype($values) != 'array')
                  $values = array($values);
                  foreach ($values as $value) {
                  $data['Answer'][$i] = array(
                  'question_id' => $question['id'],
                  'client_id' => $this->Client->id,
                  'value' => $value,
                  'isDeleted' => 0,
                  );

                  $this->Answer->save($data['Answer'][$i]);
                  }
                  };
                  }
                 * */
                $this->Session->setFlash(__('This Survey has been saved!'));
                //   $this->redirect(array('action' => 'index'));
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

}
