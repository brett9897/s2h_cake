<?php
App::uses('AppModel', 'Model');
/**
 * ViCriterium Model
 *
 * @property Question $Question
 */
class ViCriterium extends AppModel {


	public function getSurveyID()
	{
		$fields = array('survey_id');
		$conditions = array('id' => $this->id);
		$params = array('fields' => $fields, 'recursive' => -1, 'conditions' => $conditions);
		$response = $this->find('first', $params);
		return $response['ViCriterium']['survey_id'];
	}


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'values' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must give at least one value',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'weight' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'The input must be a numeric value',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'question_id' => array(
			'notNullIfQuestionType' => array(
				'rule' => 'notNullIfQuestionType',
				'message' => 'Must choose a question'
			)
		),
		'type' => array(
			'required' => array(
				'rule' => array('notempty'),
				'message' => 'Must choose a criterion type'
			)
		),
		'relational_operator' => array(
			'required' => array(
				'rule' => array('notempty'),
				'message' => 'Must choose a relational_operator'
			)
		)
	);

	/**
     * Brett: Custom not NULL validation method
     *
     * @param type $data
     * @return boolean
     */
    public function notNullIfQuestionType($data) 
    {
        if ($this->data['ViCriterium']['type'] == 'question' && $data['question_id'] == null ) 
        {
            return false;
        }
        return true;
    }

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
		),
		'Survey' => array(
			'className' => 'Survey',
			'foreignKey' => 'survey_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
