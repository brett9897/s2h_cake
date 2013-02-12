<?php
App::uses('AppController', 'Controller');
/**
 * Groupings Controller
 *
 * @property Grouping $Grouping
 */
class GroupingsController extends AppController {

	public $components = array('RequestHandler', 'Security');

	public function isAuthorized($user = null)
	{
		//non admin pages can be accessed by anyone
		if( empty($this->request->params['admin']) )
		{
			return true;
		}

		//only admins can access admin actions
		if( isset($this->request->params['admin']) )
		{
			return (bool)($user['type'] === 'admin' || $user['type'] === 'superAdmin');
		}

		//default deny
		return false;
	}

	public function beforeFilter()
	{
		parent::beforeFilter();
		
		//turn off security just for this request
		if( $this->request->action === 'admin_update' )
		{
			$this->Security->validatePost = false;
			$this->Security->csrfCheck = false;
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Grouping->recursive = 0;
		$this->set('groupings', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Grouping->id = $id;
		if (!$this->Grouping->exists()) {
			throw new NotFoundException(__('Invalid grouping'));
		}
		$this->set('grouping', $this->Grouping->read(null, $id));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($id = null) {
		$this->Grouping->recursive = 0;
		if( $id != null )
		{
			$this->paginate = array( 'conditions' => array('Grouping.survey_id' => $id));
		}
		$this->set('groupings', $this->paginate('Grouping'));
		$this->set('survey_id', $id);
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Grouping->id = $id;
		if (!$this->Grouping->exists()) {
			throw new NotFoundException(__('Invalid grouping'));
		}
		$this->set('grouping', $this->Grouping->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($survey_id = null) {
		if ($this->request->is('post')) {
			$this->Grouping->create();
			if ($this->Grouping->save($this->request->data)) {
				$this->Session->setFlash(__('The grouping has been saved'));
				$this->redirect(array('action' => 'index', $survey_id));
			} else {
				$this->Session->setFlash(__('The grouping could not be saved. Please, try again.'));
			}
		}

		if( $survey_id != null )
		{
			$this->set('selected_index', $survey_id);
		}
		else
		{
			$this->set('selected_index', 0);
		}

		$surveys = $this->Grouping->Survey->find('list');
		$this->set(compact('surveys'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Grouping->id = $id;
		if (!$this->Grouping->exists()) {
			throw new NotFoundException(__('Invalid grouping'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Grouping->save($this->request->data)) {
				$this->Session->setFlash(__('The grouping has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The grouping could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Grouping->read(null, $id);
		}
		$surveys = $this->Grouping->Survey->find('list');
		$this->set(compact('surveys'));
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
		$this->Grouping->id = $id;
		if (!$this->Grouping->exists()) {
			throw new NotFoundException(__('Invalid grouping'));
		}
		if ($this->Grouping->delete()) {
			$this->Session->setFlash(__('Grouping deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Grouping was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * update method
 *
 * @throws MethodNotAllowedException
 * @param void
 * @return success or failure
 */
	public function admin_update()
	{
		if( $this->RequestHandler->isAjax() )
		{
			foreach($this->request->data['groupings'] as $grouping)
			{
				$this->Grouping->id = $grouping['Grouping']['id'];
				$this->Grouping->saveField('ordering', $grouping['Grouping']['ordering']);
			}

			$response = array( 'status' => 'OK', 'message' => 'Saved successfully', 'timestamp' => date('m-d-Y H:i:s') );
		}
		else
		{
			$response = array( 'status' => 'ERROR', 'message' => 'Must be an ajax call', 'timestamp' => date('m-d-Y H:i:s') );
		}

		$this->set('response', $response);
	}
}
