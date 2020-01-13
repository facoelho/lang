<?php

App::uses('AppModel', 'Model');

/**
 * Lead Model
 *
 */
class Lead extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'arquivo' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'created' => array(
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
        'Importacaolead' => array(
            'className' => 'Importacaolead',
            'foreignKey' => 'importacaolead_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Corretor' => array(
            'className' => 'Corretor',
            'foreignKey' => 'corretor_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Cliente' => array(
            'className' => 'Cliente',
            'foreignKey' => 'cliente_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     */
    public $hasMany = array(
    );

}
