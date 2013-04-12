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

    public function getMostRecentSurveyInstanceForEachUser($survey_id, $type = 'all', $columns = array(), $params = array())
    {
        $query = array();
        $query['fields'] = array('Client.id', 'SurveyInstance.id');
        $customColumns = array();

        foreach( $columns as $column )
        {
            if( ($pos = strpos($column, '.')) !== false )
            {
                $query['fields'][] = $column;
            }
            else
            {
                $customColumns[] = $column;
            }
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

        $result = null;
        if( isset($params['custom']) && $params['custom'] === true )
        {
            $finalQuery .= ' ORDER BY Client.id';

            $result = $this->query($finalQuery);

            foreach( $customColumns as $col )
            {
                $this->Question = ClassRegistry::init('Question');
                $cId = $this->Question->find('first', array('recursive' => -1, 'fields' => 'Question.id', 'conditions' => array( 'Question.internal_name' => $col, 'Question.survey_id' => $survey_id)));
                
                $cParams = array('recursive' => -1);
                $cConditions = array('Answer.question_id' => $cId['Question']['id']);
                $cParams['conditions'] = $cConditions;
                $cParams['Order'] = 'Answer.client_id';
                $customData = $this->Answer->find('all', $cParams);
                //debug( $customData );
                $i = 0;
                foreach($customData as $cData)
                {
                    if( $result[$i]['SurveyInstance']['id'] == $cData['Answer']['survey_instance_id'] )
                    {
                        $result[$i]['Custom'] = array( $col => $cData['Answer']['value']);
                    }
                    $i++; 
                }
            }

            //searching
            if( isset( $params['conditions']) )
            {
                $result = $this->search($result, $params['conditions']);
            }

            //sorting
            if( isset( $params['order']) )
            {
                $sCol = array();
                if( ($p = strpos($params['order'][0], 'asc')) !== false )
                {
                    $sCol[] = trim(substr($params['order'][0], 0, $p));
                    $sCol[] = trim(substr($params['order'][0], $p));
                }
                else if( ($p = strpos($params['order'][0], 'desc')) !== false )
                {
                    $sCol[] = trim(substr($params['order'][0], 0, $p));
                    $sCol[] = trim(substr($params['order'][0], $p));
                }
                else
                {
                    $sCol[] = trim($params['order'][0]);
                    $sCol[] = 'desc';
                }
            
                if( ($pos = strpos($sCol[0], '.')) !== false )
                {
                    $var1 = substr($sCol[0], 0, $pos);
                    $var2 = substr($sCol[0], $pos+1);
                }
                else
                {
                    $var1 = 'Custom';
                    $var2 = $sCol[0];
                }

                usort($result, $this->build_sorter($var1,$var2, $sCol[1]));
            }

            //paging
            if( isset( $params['limit'] ) )
            {
                $result = array_slice($result, $params['offset'], $params['limit']);
            }

            if( $type === 'count' )
            {
                $result = count($result);
            }
        }
        else
        {

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
                $result = count($result);
            }
        }

        //debug($result);
        return $result;
    }


    private function build_sorter($key1, $key2, $dir)
    {
        return function($a, $b) use ($key1, $key2, $dir)
        {
            $x = null;
            $y = null;

            if( $dir === 'asc' )
            {
                $x = $a[$key1][$key2];
                $y = $b[$key1][$key2];
            }
            else
            {
                $x = $b[$key1][$key2];
                $y = $a[$key1][$key2];
            
            }
            if( is_numeric($a[$key1][$key2]) )
            {
                return floatval($x) > floatval($y);
            }
            else
            {
                return strcasecmp($x, $y);
            }
        };
    }

    const SEARCH_OR = 0;
    const SEARCH_AND = 1;
    private function search( $array, $conditions )
    {
        $retArray = $array;
        foreach( $conditions as $left_side => $right_side )
        {
            if( is_array($right_side) )
            {
                if( $left_side === 'OR' )
                {
                    $retArray = $this->search_OR($retArray, $right_side);
                }
                else
                {
                    //$retArray = $this->search_AND($retArray, $right_side);
                }
            }
            else //this is an implicit and
            {
                //debug($left_side);
                //debug($right_side);
                //debug($retArray);
                $retArray = $this->search_LIKE($retArray, $retArray, $left_side, $right_side, self::SEARCH_AND);
            }
        }
        return $retArray;
    }

    private function search_OR($array, $conditions)
    {
        $retArray = array();
        foreach( $conditions as $left_side => $right_side )
        {
            if( strpos($left_side, 'LIKE') !== false )
            {
                $retArray = $this->search_LIKE($retArray, $array, $left_side, $right_side, self::SEARCH_OR);
            }
        }
        return $retArray;
    }

    private function search_LIKE($ret_array, $full_array, $left_side, $right_side, $cond = self::SEARCH_OR)
    {
        $el = trim(substr($left_side, 0, strpos($left_side, 'LIKE')));

        $els = array();
        if( strpos($el, '.') !== false )
        {
            $els = explode('.', $el);
        }
        else
        {
            $els[] = 'Custom';
            $els[] = $el;
        }

        foreach( $full_array as $row )
        {
            $search = str_replace('%', '.*', $right_side);
            $pattern = '/^' . $search . '$/i';

            if( $cond === self::SEARCH_OR )
            {
                if( preg_match( $pattern, $row[$els[0]][$els[1]]) )
                {
                    if( ! in_array($row, $ret_array) )
                    {
                        $ret_array[] = $row;
                    }
                }
            }
            else
            {
                if( !preg_match( $pattern, $row[$els[0]][$els[1]]) )
                {
                    if( ($key = array_search($row, $ret_array)) !== false )
                    {
                        unset($ret_array[$key]);
                    }
                }
            }

        }

        return $ret_array;
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
