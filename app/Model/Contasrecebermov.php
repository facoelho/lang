<?php

App::uses('AppModel', 'Model');

/**
 * Contasrecebermov Model
 *
 */
class Contasrecebermov extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'contasreceber_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'dtpagamento' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => true,
                'last' => false
            ),
        ),
        'valorparcela' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'dtvencimento' => array(
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
        'Contasreceber' => array(
            'className' => 'Contasreceber',
            'foreignKey' => 'contasreceber_id',
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
        'Lancamento' => array(
            'className' => 'Lancamento',
            'foreignKey' => 'contasrecebermov_id',
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
