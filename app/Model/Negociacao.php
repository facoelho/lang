<?php

App::uses('AppModel', 'Model');

/**
 * Negociacao Model
 *
 */
class Negociacao extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'referencia' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'unidade' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => true,
                'last' => false
            ),
        ),
        'endereco' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
//        'cliente_comprador' => array(
//            'notempty' => array(
//                'rule' => 'notEmpty',
//                'allowEmpty' => true,
//                'last' => false
//            ),
//        ),
        'cliente_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
//        'cliente_vendedor' => array(
//            'notempty' => array(
//                'rule' => array('notempty'),
//            ),
//        ),
        'valor_imovel' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'valor_proposta' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'honorarios' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'perc_fechamento' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'vgv_final' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'dtvenda' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => true,
                'last' => false
            ),
        ),
        'nota_imobiliaria' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'nota_corretor' => array(
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
//        'Cliente' => array(
//            'className' => 'Cliente',
//            'foreignKey' => 'cliente_id',
//            'conditions' => '',
//            'fields' => '',
//            'order' => ''
//        ),
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Negociacaostat' => array(
            'className' => 'Negociacaostat',
            'foreignKey' => 'negociacao_id',
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
        'Negociacaohistorico' => array(
            'className' => 'Negociacaohistorico',
            'foreignKey' => 'negociacao_id',
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
        'Contasreceber' => array(
            'className' => 'Contasreceber',
            'foreignKey' => 'negociacao_id',
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

    /**
     * hasAndBelongsToMany associations
     */
    public $hasAndBelongsToMany = array(
        'Corretor' =>
        array(
            'className' => 'Corretor',
            'joinTable' => 'negociacaocorretors',
            'foreignKey' => 'negociacao_id',
            'associationForeignKey' => 'corretor_id',
            'order' => 'Corretor.nome',
        )
    );

}
