<?php

App::uses('AppModel', 'Model');

/**
 * Cliente Model
 *
 */
class Cliente extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'tipocliente' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'cpf' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
            ),
        ),
        'cpfCliente' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
            ),
        ),
        'cnpj' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
            ),
        ),
        'cnpjCliente' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
            ),
        ),
        'razaosocial' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
            ),
        ),
        'nomefantasia' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
            ),
        ),
        'nome' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
            ),
        ),
        'telefone' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
            ),
        ),
        'email' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
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
    );

}

?>
