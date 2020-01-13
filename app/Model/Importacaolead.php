<?php

App::uses('AppModel', 'Model');

/**
 * Importacaolead Model
 *
 */
class Importacaolead extends AppModel {

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
        'Origen' => array(
            'className' => 'Origen',
            'foreignKey' => 'origen_id',
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

    /**
     * hasMany associations
     */
    public $hasMany = array(
        'Lead' => array(
            'className' => 'Lead',
            'foreignKey' => 'importacaolead_id',
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
