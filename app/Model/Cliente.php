<?php

App::uses('AppModel', 'Model');

/**
 * Cliente
 *
 */
class Cliente extends AppModel {

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
            'maximo' => array(
                'rule' => array('maxLength', '255'),
                'message' => 'Máximo 255 caracteres',
            )
        ),
        'telefone' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'email' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Este campo é obrigatório.',
            ),
        ),
        'corretor_id' => array(
            'corretor_id' => array(
                'allowEmpty' => true
            ),
        ),
        'user_id' => array(
            'user_id' => array(
                'allowEmpty' => true
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
            'foreignKey' => 'cliente_id',
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

?>
