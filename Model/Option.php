<?php
App::uses('AppModel', 'Model');
/**
 * Option Model
 *
 * @property Question $Question
 */
class Option extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'label';


	public function deleteAllOptionsForQuestion($id)
	{
		$conditions = array('Option.question_id' => $id );
		$this->deleteAll($conditions, false);
	}


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'label' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
