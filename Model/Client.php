<?php

App::uses('AppModel', 'Model');
App::uses('Validation', 'Utility');

/**
 * Client Model
 *
 * @property Organization $Organization
 * @property Answer $Answer
 * @property SurveyInstance $SurveyInstance
 */
class Client extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'first_name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'first_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter a first name',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'last_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter a last name',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'dob' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ssn' => array(
            'number' => array(
                'rule' => 'numeric',
                'message' => 'Must be 4 digits',
                'allowEmpty' => true
            ),
            'atMost4' => array(
                'rule' => array('maxLength', 4),
                'message' => 'Must be 4 digits',
                'allowEmpty' => true
            ),
            'atLeast4' => array(
                'rule' => array('minLength', 4),
                'message' => 'Must be 4 digits',
                'allowEmpty' => true
            ),
        ),
        /*'phone_number' => array(
            'phone' => array(
                'rule' => array('phone', null, 'us'),
                'allowEmpty' => true,
                'message' => 'Must enter a valid phone number'
            )
        )*/
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Organization' => array(
            'className' => 'Organization',
            'foreignKey' => 'organization_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Answer' => array(
            'className' => 'Answer',
            'foreignKey' => 'client_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'SurveyInstance' => array(
            'className' => 'SurveyInstance',
            'foreignKey' => 'client_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    public function addValidator($key, $validations) {
        foreach ($validations as $validation) {
            if (empty($validation)) continue;
            $this->validator()->add($key, array(
                'validation1' => array(
                    'rule' => $validation,
                    'message' => 'Invalid Input'
                    )));
        }
    }

    public function combined_field_rule($field = array(), $compare_field=null, $rule=null, $validation=array() )
    {
        $mainName = null;
        foreach( $field as $internal_name => $values )
        {
            $mainName = $internal_name;
            break;
        }

        $allGood = true;
        if( is_array($field[$mainName]) )
        {
            foreach( $field[$mainName] as $val )
            {
                if( !Validation::$rule($val) )
                {
                    $allGood = false;
                }
            }
        }
        else
        {
            $allGood = Validation::$rule($field[$mainName]);
        }

        if( $allGood === true || Validation::$rule($this->data[$this->name][$compare_field]) )
        {
            return true;
        }

        $this->invalidate($compare_field, $validation['message']);
        return false;
    }

}
