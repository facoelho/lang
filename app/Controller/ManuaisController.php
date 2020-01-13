<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Manuais Controller
 */
class ManuaisController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Manuais');
    }

    public function isAuthorized($user) {
        $Users = new UsersController;
        return $Users->validaAcesso($this->Session->read(), $this->request->controller);
        return parent::isAuthorized($user);
    }

    /**
     * index method
     */
    public function index() {
        $dadosUser = $this->Session->read();
        $this->Manuai->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('arquivo' => 'asc')
        );
        $this->set('manuais', $this->Paginator->paginate('Manuai'));
    }

}
