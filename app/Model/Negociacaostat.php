<?php

App::uses('AppModel', 'Model');

/**
 * Negociacaostat Model
 *
 */
class Negociacaostat extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'status' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'obs' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'created' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'user_id' => array(
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
        'Negociacao' => array(
            'className' => 'Negociacao',
            'foreignKey' => 'negociacao_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

}
