<?php

App::uses('AppModel', 'Model');

/**
 * Negociacao Model
 *
 */
class Negociacaohistorico extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'created' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'obs' => array(
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
