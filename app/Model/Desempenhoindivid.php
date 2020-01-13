<?php

App::uses('AppModel', 'Model');

/**
 * Desempenhoindivid Model
 *
 */
class Desempenhoindivid extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'vgv_avulso' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
            ),
        ),
        'vgv_emp' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
            ),
        ),
        'agenciamentos' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
            ),
        ),
        'plantao_imob' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
            ),
        ),
        'plantao_emp' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
            ),
        ),
        'acao_ext' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
            ),
        ),
        'call_center' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
            ),
        ),
        'sistema' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
            ),
        ),
        'desempenho_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'corretor_id' => array(
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
        'Desempenho' => array(
            'className' => 'Desempenho',
            'foreignKey' => 'desempenho_id',
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
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
    );

}
