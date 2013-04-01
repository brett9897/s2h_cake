<?php

App::uses('AppController', 'Controller');

/**
 * Clients Controller
 *
 * @property Client $Client
 */
class ClientsController extends AppController {

    public $components = array('Session', 'RequestHandler');            //takes care of sessions and requests that need a .json file extension but is not really .json
    public $uses = array('Client', 'SurveyInstance');

    /**
     * index method
     *
     * @return void
     */

    public function index() {
        $this->Client->recursive = 0;
        $this->set('clients', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Client->id = $id;
        if (!$this->Client->exists()) {
            throw new NotFoundException(__('Invalid client'));
        }
        $client = $this->Client->read(null, $id);
        $this->set('client', $client);
        $photoName = ($client['Client']['photoName']) ? $client['Client']['photoName'] : 'none.png';
        $this->set('photoName', $photoName);
        $vi_scores = $this->SurveyInstance->getMostRecentVIScorePerSurvey($id);
        $this->set('vi_scores', $vi_scores);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Client->create();
            if ($this->Client->save($this->request->data)) {
                $this->Session->setFlash(__('The client has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The client could not be saved. Please, try again.'));
            }
        }
        $organizations = $this->Client->Organization->find('list');
        $this->set(compact('organizations'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Client->id = $id;
        if (!$this->Client->exists()) {
            throw new NotFoundException(__('Invalid client'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Client->save($this->request->data)) {
                $this->Session->setFlash(__('The client has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The client could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Client->read(null, $id);
        }
        $organizations = $this->Client->Organization->find('list');
        $this->set(compact('organizations'));
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
        $this->Client->id = $id;
        if (!$this->Client->exists()) {
            throw new NotFoundException(__('Invalid client'));
        }
        if ($this->Client->delete()) {
            $this->Session->setFlash(__('Client deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Client was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Client->recursive = 0;
        $this->set('clients', $this->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Client->id = $id;
        if (!$this->Client->exists()) {
            throw new NotFoundException(__('Invalid client'));
        }
        $this->set('client', $this->Client->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Client->create();
            if ($this->Client->save($this->request->data)) {
                $this->Session->setFlash(__('The client has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The client could not be saved. Please, try again.'));
            }
        }
        $organizations = $this->Client->Organization->find('list');
        $this->set(compact('organizations'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Client->id = $id;
        if (!$this->Client->exists()) {
            throw new NotFoundException(__('Invalid client'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Client->save($this->request->data)) {
                $this->Session->setFlash(__('The client has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The client could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Client->read(null, $id);
        }
        $organizations = $this->Client->Organization->find('list');
        $this->set(compact('organizations'));
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
        $this->Client->id = $id;
        if (!$this->Client->exists()) {
            throw new NotFoundException(__('Invalid client'));
        }
        if ($this->Client->delete()) {
            $this->Session->setFlash(__('Client deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Client was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**  this is the action for the dataTables.
     * 
     */
    public function dataTables() {
        //$aColumns = array('Client.first_name', 'Client.last_name', 'Client.DOB');
        //if( ! isset($this->Session->read('aColumns'))){
        if ($this->Session->read('aColumns') != null) {
            //$aColumns = array('dob', 'first_name', 'last_name');
            $aColumns = array('first_name', 'last_name', 'dob');
//echo 'IF--!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
        } else {
            //$aColumns = array('first_name', 'last_name', 'dob');
            $aColumns = array('first_name', 'last_name');
//echo 'ELSE--!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
        }
///echo 'MUST--!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
        //$aColumns = array('first_name', 'last_name', 'dob');
        $params = array();


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
//echo '$params[\'conditions\'] = ' . $params['conditions'];
        $raw_data = $this->Client->find('all', $params);

        $total = $this->Client->find('count');

        if (isset($params['conditions'])) {
            $filteredTotal = $this->Client->find('count', array('conditions' => $params['conditions']));
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
                'DT_RowId' => 'client_' . $result['Client']['id'],
                'DT_RowClass' => 'highlight-dataTables'
            );
            $output['aaData'][] = $row;
        }
        $this->set('output', $output);
    }

}

