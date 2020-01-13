<?php

App::uses('AppModel', 'Model');

/**
 * Desempenho Model
 *
 */
class Desempenho extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'dtinicio' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'dtfim' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Desempenhoindivid' => array(
            'className' => 'Desempenhoindivid',
            'foreignKey' => 'desempenho_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => true,
            'finderQuery' => '',
            'counterQuery' => ''
        ),
    );

}
