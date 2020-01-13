<?php

App::uses('AppModel', 'Model');

/**
 * Unsubscribe Model
 *
 */
class Unsubscribe extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'email' => array(
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
     */
    public $hasMany = array(
    );

}
