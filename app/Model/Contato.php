<?php

App::uses('AppModel', 'Model');

/**
 * Contato
 *
 */
class Contato extends AppModel {

    public $useTable = 'perfilclientes';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
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
