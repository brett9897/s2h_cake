<?php
App::uses('AppController', 'Controller');
/**
 * Questions Controller
 *
 * @property Question $Question
 */
class QuestionsController extends AppController {

	public $uses = array( 'Question', 'Grouping', 'Type', 'InternalValidation', 'Option' );
	public $helpers = array('Binary');


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

		$this->Security->unlockedFields = array('validation_1', 'validation_2', 'validation_3', 'validation_4',
			'options');
		$this->Security->validatePost = false;
		$this->Security->csrfCheck = false;
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Question->recursive = 0;
		$this->set('questions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Question->id = $id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}
		$this->set('question', $this->Question->read(null, $id));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($id = null) {
		$this->Question->recursive = 0;
		if( $id != null )
		{
			$this->paginate = array( 'conditions' => array( 'Question.grouping_id' => $id));
		}
		$this->set('questions', $this->paginate('Question'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Question->id = $id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}

		$data = $this->Question->read(null, $id);

		for( $i=1; $i < 5; $i++ )
		{
			if( $data['Question']['validation_' . $i] != null )
			{
				$response = $this->InternalValidation->find('all', array( 
					'fields' => array('label'), 
					'conditions' => array('regex' => $data['Question']['validation_' . $i])
					)
				); 

				$data['Question']['validation_' . $i] = $response[0]['InternalValidation']['label'];
				
			}
		}

		$this->set('question', $data);
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($grouping_id = null) {
		if ($this->request->is('post')) {

			if( $grouping_id == null )
			{
				$grouping_id = $this->request->data['Question']['grouping_id'];
			}

			$this->Question->create();

			//pull out options for later use
			$options = explode(',', $this->request->data['Option']['options']);
			unset( $this->request->data['Option'] );

			//get the survey id
			$grouping = $this->Question->Grouping->read(null, $grouping_id);
			$this->request->data['Question']['survey_id'] = $grouping['Grouping']['survey_id'];

			if ($this->Question->save($this->request->data)) {
				
				//now try to save options
				$save_array = array();
				$save_array['Option'] = array();
				$save_array['Option']['question_id'] = $this->Question->id;

				foreach( $options as $option )
				{
					$this->Option->create();
					$save_array['Option']['label'] = $option;
					$this->Option->save($save_array);
				}

				$this->Session->setFlash(__('The question has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		}
		$groupings = $this->Question->Grouping->getByOrderNumber('ASC');
		$types = $this->Question->Type->find('list');
		$validations = $this->InternalValidation->find('all');

		$validation_options = array();
		foreach( $validations as $validation )
		{
			$validation_options[$validation['InternalValidation']['regex']] = $validation['InternalValidation']['label'];
		}

		$this->set(compact('groupings', 'types'));
		$this->set('selected_grouping_id', $grouping_id);
		$this->set('validation_options', $validation_options);
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Question->id = $id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Question->save($this->request->data)) {

				//remove options and re-save
				$this->Option->deleteAllOptionsForQuestion($id);

				$options = explode(',', $this->request->data['Option']['options']);

				//now try to save options
				$save_array = array();
				$save_array['Option'] = array();
				$save_array['Option']['question_id'] = $id;

				foreach( $options as $option )
				{
					$this->Option->create();
					$save_array['Option']['label'] = $option;
					$this->Option->save($save_array);
				}

				$this->Session->setFlash(__('The question has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Question->read(null, $id);

			$options = '';
			foreach( $this->request->data['Option'] as $option )
			{
				$options .= $option['label'] . ',';
			}

			$options = substr($options, 0, -1);
			$this->request->data['Option']['options'] = $options;
		}
		
		$currentValidations = array();
		for( $i=1; $i < 5; $i++ )
		{
			if( $this->request->data['Question']['validation_' . $i] != null )
			{
				$response = $this->InternalValidation->find('all', array( 
					'fields' => array('regex', 'label'), 
					'conditions' => array('regex' => $this->request->data['Question']['validation_' . $i])
					)
				); 

				$currentValidations[] = array( 
					'label' => $response[0]['InternalValidation']['label'],
					'regex' => $response[0]['InternalValidation']['regex']
				);
			}
		}

		$this->set('currentValidations', $currentValidations);

		$groupings = $this->Question->Grouping->getByOrderNumber('ASC');
		$types = $this->Question->Type->find('list');
		$validations = $this->InternalValidation->find('all', array( ));

		$validation_options = array();
		foreach( $validations as $validation )
		{
			$validation_options[$validation['InternalValidation']['regex']] = $validation['InternalValidation']['label'];
		}

		$this->set(compact('groupings', 'types'));
		$this->set('selected_grouping_id', $this->request->data['Question']['grouping_id']);
		$this->set('validation_options', $validation_options);	
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
		$this->Question->id = $id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}
		if ($this->Question->delete()) {
			$this->Session->setFlash(__('Question deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Question was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
