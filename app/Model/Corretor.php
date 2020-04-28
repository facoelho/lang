<?php

App::uses('AppModel', 'Model');

/**
 * Corretor Model
 *
 */
class Corretor extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'nome' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'email' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'gerente' => array(
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
     */
    public $hasMany = array(
        'Lead' => array(
            'className' => 'Lead',
            'foreignKey' => 'corretor_id',
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
        'Desempenhoindivid' => array(
            'className' => 'Desempenhoindivid',
            'foreignKey' => 'corretor_id',
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
//        'Negociacaocorretor' => array(
//            'className' => 'Negociacaocorretor',
//            'foreignKey' => 'corretor_id',
//            'dependent' => true,
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => true,
//            'finderQuery' => '',
//            'counterQuery' => ''
//        ),
    );

}
