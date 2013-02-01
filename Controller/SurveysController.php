<?php
App::uses('AppController', 'Controller');
/**
 * Surveys Controller
 *
 * @property Survey $Survey
 */
class SurveysController extends AppController {

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
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Survey->recursive = 0;
		$this->set('surveys', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Survey->id = $id;
		if (!$this->Survey->exists()) {
			throw new NotFoundException(__('Invalid survey'));
		}
		$this->set('survey', $this->Survey->read(null, $id));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Survey->recursive = 0;
		$this->set('surveys', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Survey->id = $id;
		if (!$this->Survey->exists()) {
			throw new NotFoundException(__('Invalid survey'));
		}
		$this->set('survey', $this->Survey->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$user = $this->Auth->user();

		if ($this->request->is('post')) {
			$this->Survey->create();
			if( !isset($this->request->data['Survey']['organization_id']) )
			{
				$this->request->data['Survey']['organization_id'] = $user['organization_id'];
			}
			if ($this->Survey->save($this->request->data)) {
				$this->Session->setFlash(__('The survey has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The survey could not be saved. Please, try again.'));
			}
		}
		$organizations = $this->Survey->Organization->find('list');
		
		if( $user['type'] === "superAdmin" )
		{
			$this->set(compact('organizations'));
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Survey->id = $id;
		$user = $this->Auth->user();
		if (!$this->Survey->exists()) {
			throw new NotFoundException(__('Invalid survey'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if( ! isset($this->request->data['Survey']['organization_id']) )
			{
				$this->request->data['Survey']['organization_id'] = $user['organization_id'];
			}
			var_dump($this->request->data);
			if ($this->Survey->save($this->request->data)) {
				if( $this->request->data['Survey']['isActive'] == true )
				{
					$data = $this->Survey->find('all', array( 'conditions' => array('AND' => 
						array( 
							'Survey.id !=' => $id,
							'Survey.organization_id' => $this->request->data['Survey']['organization_id'],
							'Survey.isActive' => true
							)
						)));

					if( $data != null )
					{
						$data[0]['Survey']['isActive'] = false;
						$this->Survey->save($data[0]);
					}
				}
				$this->Session->setFlash(__('The survey has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The survey could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Survey->read(null, $id);
		}
		
		if( $user['type'] === "superAdmin" )
		{
			$organizations = $this->Survey->Organization->find('list');
			$this->set(compact('organizations'));
		}

		var_dump($this->Survey->Grouping->getByOrderNumber($id, 'ASC'));
		
		$this->set('groupings', $this->Survey->Grouping->getByOrderNumber($id, 'ASC'));
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
		$this->Survey->id = $id;
		if (!$this->Survey->exists()) {
			throw new NotFoundException(__('Invalid survey'));
		}
		if ($this->Survey->delete()) {
			$this->Session->setFlash(__('Survey deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Survey was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
