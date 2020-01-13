<?php

App::uses('AppModel', 'Model');

/**
 * Caracteristica Model
 *
 */
class Caracteristica extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'operacaotipo_id' => array(
            'notempty' => array(
                'allowEmpty' => true,
            ),
        ),
        'imoveltipo_id' => array(
            'notempty' => array(
                'allowEmpty' => true,
            ),
        ),
        'valor_max' => array(
            'numeric' => array(
                'rule' => array('numeric'),
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
    );

    /**
     * hasMany associations
     */
    public $hasMany = array(
    );

}
