<?php
App::uses('AppController', 'Controller');
/**
 * Questions Controller
 *
 * @property Question $Question
 */
class QuestionsController extends AppController {

	public $uses = array( 'Question', 'Grouping', 'Type', 'InternalValidation', 'Option' );
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

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Security->unlockedFields = array('validation_1', 'validation_2', 'validation_3', 'validation_4',
			'options');
		$this->Security->validatePost = false;
		$this->Security->csrfCheck = false;
	}
/**
 * add method
 *
 * @return void
 */
/*	public function add() {
		if ($this->request->is('post')) {
			$this->Question->create();
			if ($this->Question->save($this->request->data)) {
				$this->Session->setFlash(__('The question has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		}
		$surveys = $this->Question->Survey->find('list');
		$groupings = $this->Question->Grouping->find('list');
		$types = $this->Question->Type->find('list');
		$this->set(compact('surveys', 'groupings', 'types'));
	}
*/
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
/*	public function edit($id = null) {
		$this->Question->id = $id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Question->save($this->request->data)) {
				$this->Session->setFlash(__('The question has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Question->read(null, $id);
		}
		$surveys = $this->Question->Survey->find('list');
		$groupings = $this->Question->Grouping->find('list');
		$types = $this->Question->Type->find('list');
		$this->set(compact('surveys', 'groupings', 'types'));
	}
*/
/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
/*	public function delete($id = null) {
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
*/
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Question->recursive = 0;
		$this->set('questions', $this->paginate());
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
		$this->set('question', $this->Question->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($grouping_id = null) {
		if ($this->request->is('post')) {
			$this->Question->create();
			var_dump($this->request->data);

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
				$this->Session->setFlash(__('The question has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Question->read(null, $id);
		}
		$surveys = $this->Question->Survey->find('list');
		$groupings = $this->Question->Grouping->find('list');
		$types = $this->Question->Type->find('list');
		$validations = $this->InternalValidation->find('list');
		$this->set(compact('surveys', 'groupings', 'types', 'validations'));
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
