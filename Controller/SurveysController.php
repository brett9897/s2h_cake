<?php
App::uses('AppController', 'Controller');
/**
 * Surveys Controller
 *
 * @property Survey $Survey
 */
class SurveysController extends AppController {

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
		if( $this->request->action === 'admin_update_active' )
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
	/*public function index() {
		$this->Survey->recursive = 0;
		$this->set('surveys', $this->paginate());
	}*/

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	/*public function view($id = null) {
		$this->Survey->id = $id;
		if (!$this->Survey->exists()) {
			throw new NotFoundException(__('Invalid survey'));
		}
		$this->set('survey', $this->Survey->read(null, $id));
	}*/

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$cur_user = $this->Auth->user();
		$this->Survey->recursive = 0;
		$this->paginate = array('conditions' => array( 'Survey.organization_id' => $cur_user['organization_id']));
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
				//create a personal information grouping
				$this->Survey->Grouping->create();
				$grouping = array();
				$grouping['Grouping'] = array(
					'survey_id' => $this->Survey->id,
					'label' => 'Personal Information',
					'ordering' => 1,
					'is_used' => 1
				);

				$this->Survey->Grouping->save($grouping);
				
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
		$hasInstance = false;
		if (!$this->Survey->exists()) {
			throw new NotFoundException(__('Invalid survey'));
		}

		if( $this->Survey->hasInstance() )
		{
			$this->Session->setFlash(__('This survey has already been given to someone so there is limited editing.'));
			$hasInstance = true;
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			if( ! isset($this->request->data['Survey']['organization_id']) )
			{
				$this->request->data['Survey']['organization_id'] = $user['organization_id'];
			}
			
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
		

		$groupings = $this->Survey->Grouping->getByOrderNumber($id, 'ASC');
		
		//prepend the default questions to groupings[0] for personal information
		$default_questions = $this->build_default_questions();

		//need to fix ordering
		$groupings[0]['Question'] = array_merge($default_questions, $groupings[0]['Question']);

		$this->set('groupings', $groupings);

		$this->set('hasInstance', $hasInstance);
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

	public function admin_update_active()
	{
		if( $this->RequestHandler->isAjax() )
		{
			$survey = $this->request->data['Survey'];
			$this->Survey->updateActiveFieldToTrue($survey['id']);

			$response = array( 'status' => 'OK', 'message' => 'Saved successfully', 'timestamp' => date('m-d-Y H:i:s') );
		}
		else
		{
			$response = array( 'status' => 'ERROR', 'message' => 'Must be an ajax call', 'timestamp' => date('m-d-Y H:i:s') );
		}

		$this->set('response', $response);
	}

	private function build_default_questions()
	{
		$default_questions = array(
			array(
				'id' => null,
				'ordering' => 1,
				'label' => 'First Name',
				'Type' => array(
					'id' => null,
					'label' => 'default'
				),
				'Option' => array(),
				'is_used' => 1
			),
			array(
				'id' => null,
				'ordering' => 2,
				'label' => 'Middle Name',
				'Type' => array(
					'id' => null,
					'label' => 'default'
				),
				'Option' => array(),
				'is_used' => 1
			),
			array(
				'id' => null,
				'ordering' => 3,
				'label' => 'Last Name',
				'Type' => array(
					'id' => null,
					'label' => 'default'
				),
				'Option' => array(),
				'is_used' => 1
			),
			array(
				'id' => null,
				'ordering' => 4,
				'label' => 'Last 4 of SSN',
				'Type' => array(
					'id' => null,
					'label' => 'default'
				),
				'Option' => array(),
				'is_used' => 1
			),
			array(
				'id' => null,
				'ordering' => 5,
				'label' => 'DOB',
				'Type' => array(
					'id' => null,
					'label' => 'default'
				),
				'Option' => array(),
				'is_used' => 1
			),
			array(
				'id' => null,
				'ordering' => 6,
				'label' => 'Nickname',
				'Type' => array(
					'id' => null,
					'label' => 'default'
				),
				'Option' => array(),
				'is_used' => 1
			),
			array(
				'id' => null,
				'ordering' => 7,
				'label' => 'Phone Number',
				'Type' => array(
					'id' => null,
					'label' => 'default'
				),
				'Option' => array(),
				'is_used' => 1
			),
		);

		return $default_questions;
	}

	public function admin_clone($id = null)
	{

		$label = '';

		if( isset($this->params['url']['label']) )
		{
			$label = $this->params['url']['label'];
		}

		if( $id == null )
		{
			$this->redirect(array('action' => 'choose', '?' => array( 'label' => $label)));
		}

		$this->Survey->id = $id;
		
		if (!$this->Survey->exists()) {
			throw new NotFoundException(__('Invalid survey'));
		}

		if ($this->request->is('post'))
		{
			$user = $this->Auth->user();
			$this->request->data['Survey']['organization_id'] = $user['organization_id'];
			
			if( $this->Survey->clone_survey($this->request->data) )
			{
				$this->Session->setFlash(__('The survey has been cloned'));
				$this->redirect(array('action' => 'edit', $this->Survey->id));
			} 
			else 
			{
				$this->Session->setFlash(__('The survey could not be cloned. Please, try again.'));
				$this->Survey->id = $id;
			}
		}
		else
		{
			$this->request->data['Survey']['label'] = $label;
		}

		$this->set('survey_name', $this->Survey->getSurveyName());
	}

	function admin_choose()
	{
		$cur_user = $this->Auth->user();
		$this->Survey->recursive = 0;
		$surveys = $this->Survey->find('list', array('conditions' => array('Survey.organization_id' => $cur_user['organization_id'])));
		$this->set(compact('surveys'));
		if( isset($this->params['url']['label']) )
		{
			$this->set('label', $this->params['url']['label']);
		}
	}
}
