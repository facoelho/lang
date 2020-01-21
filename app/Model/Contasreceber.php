<?php

App::uses('AppModel', 'Model');

/**
 * Contasreceber Model
 *
 */
class Contasreceber extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'negociacao_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'valor_total' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => true,
                'last' => false
            ),
        ),
        'saldo' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'parcelas' => array(
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
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Negociacao' => array(
            'className' => 'Negociacao',
            'foreignKey' => 'negociacao_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Contasrecebermov' => array(
            'className' => 'Contasrecebermov',
            'foreignKey' => 'contasreceber_id',
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
