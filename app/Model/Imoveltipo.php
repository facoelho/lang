<?php

App::uses('AppModel', 'Model');

/**
 * Imoveltipo Model
 *
 */
class Imoveltipo extends AppModel {

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
    );

}
