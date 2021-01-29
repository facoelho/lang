<?php

App::uses('AppModel', 'Model');

/**
 * Contaspagar Model
 *
 */
class Contaspagar extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'contrato' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'proprietario' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'inquilino' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'valor' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'dtvencimento' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'corretor_id' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => true,
                'last' => false
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
//        'Contasrecebermov' => array(
//            'className' => 'Contasrecebermov',
//            'foreignKey' => 'contasreceber_id',
//            'dependent' => true,
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => true,
//            'finderQuery' => '',
//            'counterQuery' => ''
//        ),
    );

    public function afterFind($dados, $primary = false) {
        foreach ($dados as $key => $value) {
            if (!empty($value["Contaspagar"]["dtvencimento"])) {
                $dados[$key]["Contaspagar"]["dtvencimento"] = $this->formataData($value["Contaspagar"]["dtvencimento"], 'PT', 'N');
            }
            if (!empty($value["Contaspagar"]["dtrecebimento"])) {
                $dados[$key]["Contaspagar"]["dtrecebimento"] = $this->formataData($value["Contaspagar"]["dtrecebimento"], 'PT', 'N');
            }
            if (!empty($value["Contaspagar"]["dtrepasse"])) {
                $dados[$key]["Contaspagar"]["dtrepasse"] = $this->formataData($value["Contaspagar"]["dtrepasse"], 'PT', 'N');
            }
        }
        return $dados;
    }

}
