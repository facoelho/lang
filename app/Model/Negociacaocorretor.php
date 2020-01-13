<?php

class Negociacaocorretor extends AppModel {

    /**
     * belongsTo associations
     *
     */
    public $belongsTo = array(
        'Negociacao' => array(
            'className' => 'Negociacao',
            'foreignKey' => 'negociacao_id',
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

}

?>
