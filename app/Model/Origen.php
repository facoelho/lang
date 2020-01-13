<?php

App::uses('AppModel', 'Model');

/**
 * Origen Model
 *
 */
class Origen extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'descricao' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'valor_investido' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'compoem_indicador' => array(
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
        'Importacaolead' => array(
            'className' => 'Importacaolead',
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
