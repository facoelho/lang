<?php

App::uses('AppModel', 'Model');

/**
 * Manuai Model
 *
 */
class Manuai extends AppModel {

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
        'descricao' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
            'maximo' => array(
                'rule' => array('maxLength', '100'),
                'message' => 'Máximo 100 caracteres',
            )
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
