<?php

App::uses('AppModel', 'Model');

/**
 * SurveyInstance Model
 *
 * @property Survey $Survey
 * @property Client $Client
 * @property User $User
 */
class SurveyInstance extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'id';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'survey_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'client_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'user_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'vi_score' => array(
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
        'Survey' => array(
            'className' => 'Survey',
            'foreignKey' => 'survey_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Client' => array(
            'className' => 'Client',
            'foreignKey' => 'client_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasMany = array(
        'Answer' => array(
            'className' => 'Answer',
            'foreignKey' => 'survey_instance_id',
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

    public function getMostRecentSurveyInstanceForEachUser($survey_id, $type = 'all', $params = array())
    {
        $query = array();
        $query['fields'] = array('Client.id', 'Client.first_name', 'Client.last_name', 'Client.dob', 'Client.ssn', 'SurveyInstance.vi_score');
        
        if( $type === 'count' )
        {
            $query['fields'][] = 'COUNT(*) as count';
        }

        $query['tables'] = array('survey_instances AS SurveyInstance', 'surveys AS Survey', 'clients AS Client');
        $query['subquery'] = 'INNER JOIN ( ' .
                             '  SELECT survey_id, client_id, MAX(id) as id ' .
                             '  FROM survey_instances ' .
                             '  GROUP BY survey_id, client_id DESC ' .
                             ') si ON si.id = SurveyInstance.id ';
        $query['conditions'] = array(
            'Survey.id' => 'si.survey_id',
            'si.client_id' => 'Client.id',
            'si.survey_id' => $survey_id
        );

        $finalQuery = 'SELECT ' . implode(', ', $query['fields'] ). ' FROM ' . $query['tables'][0] . ' ' . $query['subquery'] . 
                        ', ' . $query['tables'][1] . ', ' . $query['tables'][2];
        $finalQuery .= ' WHERE ';

        foreach( $query['conditions'] as $left_side => $right_side )
        {
            $finalQuery .= $left_side . ' = ' . $right_side . ' AND ';
        }
        $finalQuery = substr($finalQuery, 0, -4);

        if( isset( $params['conditions'] ) )
        {
            $finalQuery .= ' AND ';
            foreach( $params['conditions'] as $left_side => $right_side )
            {
                if(is_array($right_side))
                {
                    if( count($right_side) > 0 )
                    {
                        $finalQuery .= '(';
                        foreach( $right_side as $left => $right )
                        {
                            $finalQuery .= $this->build_condition($left, $right) . " $left_side ";
                        }
                        $end = strlen($left_side) + 2;
                        $finalQuery = substr($finalQuery, 0, -($end));
                        $finalQuery .= ')';
                    }
                }
                else
                {
                    $finalQuery .= $this->build_condition($left_side, $right_side);
                }
                $finalQuery .= ' AND ';
                
            }
            $finalQuery = substr($finalQuery, 0, -4);
        }

        if( isset( $params['order'] ) )
        {
            $finalQuery .= 'ORDER BY ' . $params['order'][0] . ' ';
        }

        if( isset( $params['limit'] ) )
        {
            $finalQuery .= 'LIMIT ';
            if( isset( $params['offset'] ) )
            {
                $finalQuery .= $params['offset'] . ',';
            }
            $finalQuery .= $params['limit'];
        }

        //debug($finalQuery);
        $result = $this->query($finalQuery);
        if( $type === 'count' )
        {
            $result = $result[0]['0']['count'];
        }

        //debug($result);
        return $result;
    }

    public function getMostRecentVIScorePerSurvey($client_id)
    {
        return $this->query('SELECT Survey.label, SurveyInstance.vi_score ' .
                            'FROM survey_instances AS SurveyInstance ' .
                            'INNER JOIN ( ' .
                            '  SELECT survey_id, client_id, MAX(id) as id ' .
                            '  FROM survey_instances ' .
                            '  GROUP BY survey_id, client_id DESC ' . 
                            ') si ON si.id = SurveyInstance.id, ' .
                            'surveys as Survey ' .
                            'WHERE Survey.id = si.survey_id AND si.client_id = ' . $client_id
        );
    }

    private function build_condition($left, $right)
    {
        if( strpos($left, 'LIKE') !== false )
        {
            return $left . "'" . $right . "'";
        }
        else
        {
            return $left . ' = ' . $right;
        }
    }
}
